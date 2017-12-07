<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Salary;
use App\Employee;
use App\CashAdvance;
use App\Bonus;
use App\EmployeeTimeEntries;
use App\Holiday;
use App\Loan;
use App\BackPay;
use App\Contribution;
use App\Leave;
use App\Report;
use App\Allowance;

use App\Http\Requests\UpdateComputationRequest;
use Carbon\Carbon;

class PayRollController extends Controller
{
    public function index(){
    	if(! Gate::allows('computation_access'))
        {
    		return response()->view('errors.401', [], 401);
    	}

    	$relations = [
            'employees' => Employee::with(['salaries' => function($q) {
                    $q->orderBy('id', 'desc');
                }])->where('working_status', 'Regular')->get(),
    	];
        
    	return view('admin.salary.index', $relations);
    }

    public function show($id){
        if(! Gate::allows('computation_view'))
        {
            return response()->view('errors.401', [], 401);
        }

        $salary = Salary::findOrFail($id);

        return view('admin.salary.show', compact('salary'));
    }

    public function edit($id){
        if(! Gate::allows('computation_edit'))
        {
            return response()->view('errors.401', [], 401);
        }

        $salary = Salary::with('employee')->where('id', '=', $id)->first();

        return view('admin.salary.edit', compact('salary'));
    }

    public function update(UpdateComputationRequest $request, $id){
        if(! Gate::allows('computation_edit'))
        {
            return response()->view('errors.401', [], 401);
        }

        $salary         = Salary::findOrFail($id);
        $employee       = Employee::where('id', $salary->employee_id)->first();
        $rate           = $employee->departments->first()->pivot->rate;
        $deduct         = 0;
        $loan_to_pay    = 0;
        $paid_loan      = 0;

        if(count($salary->contributions))
        {
            $contribution   = $salary->contributions->first();
            $deduct         = $contribution->sss_employee + $contribution->philc_employee + $contribution->hdmf;
        }

        if(count($employee->loan))
        {
            // get previous paid loan
            $paid_loan = $this->loanPayment($employee->id);

            if($paid_loan != 0)
            {
                $loan_to_pay = $this->monthlyPayment($employee->id);
            }
            else
            {
                $loan_to_pay = $this->monthlyPayment($employee->id);
            }
        }

        if($loan_to_pay > $request->loan)
        {
            $loan_to_pay = $request->loan;
        }

        $salary->date               = $request->date;
        $salary->date_range         = $request->date_range;
        $salary->basic              = $request->basic;
        $salary->holiday            = $request->holiday;
        $salary->cola               = $request->cola;
        $salary->overtime_pay       = $request->overtime_pay;
        $salary->overtime_pay_night = $request->overtime_pay_night;
        $salary->bonus              = $request->bonus;
        $salary->allowance          = $request->allowance;
        $salary->gross              = $salary->basic + $salary->cola + $salary->overtime_pay + $salary->bonus;
        $salary->cash_advance       = $request->cash_advance;
        $salary->late               = $request->late;
        $salary->loan               = $loan_to_pay;
        $salary->total_deductions   = $salary->cash_advance + $salary->late + $salary->tax + $deduct + $salary->loan;
        $salary->net_pay            = $salary->gross - $salary->total_deductions + $salary->allowance + $salary->holiday;
        $salary->save();

        $paid_loan += $salary->loan;

        if(count($employee->loan))
        {
            if($employee->loan->amount == $paid_loan)
            {
                $employee->loan()->update(['status' => 'Paid']);
            }
            else
            {
                $employee->loan()->update(['status' => 'Unpaid']);
            }
        }

        return redirect()->route('admin.salary.index');
    }

    public function destroy($id){
        if(! Gate::allows('computation_delete'))
        {
            return response()->view('errors.401', [], 401);
        }

        $salary = Salary::findOrFail($id);
        $salary->delete();

        return redirect()->route('computation.index');
    }

    public function massDestroy(Request $request){
        if (! Gate::allows('deduction_delete')) 
        {
          return response()->view('errors.401', [], 401);
        }

        if ($request->input('ids')) 
        {
            $entries = Salary::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) 
            {
                $entry->delete();
            }
        }

        return redirect()->route('computation.index');
    }

    public function runPayroll(Request $request){
    	$from           = new Carbon(str_replace('-', '/', $request->from));
    	$to             = new Carbon(str_replace('-', '/', $request->to));
        $report_gross   = 0;
        $report_deduct  = 0;
        $report_netpay  = 0;
        $monthly_pay    = 0;

    	$employees = Employee::with([
            'time_entries' => function($q) use($from, $to) {
                $q->whereBetween('date', array($from, $to))
                ->orderBy('date', 'asc');
            },'departments', 'position', 'cash_advance' => function($q) {
                $q->where('status', 'Unpaid');
            }, 'overtimes' => function($q) {
                $q->where('status', 'Approved');
            }, 'loan' => function($q) {
                $q->where('status', 'Unpaid');
            }
        ])->get();

    	foreach ($employees as $employee) 
        {
            if(count($employee->departments))
            {
                $overtime_pay   = 0;
                $daysWork       = 0;
                $basic_pay      = 0;
                $cashAdvance    = 0;
                $late           = 0;
                $loan_to_pay    = 0;
                $paid_loan      = 0;
                $wage           = 0;
                $holiday_pay    = 0;
                $cont_deduct    = 0;    //contribution deduction
                $wtax           = 0;    //withholding tax
                $rate           = $employee->departments->first()->pivot->rate;
                $allowance      = $this->allowanc($employee->id);
                $leaveWithPay   = $this->leave($employee->id, $from, $to, $rate);
                $schedule       = $employee->schedule;
                $cont           = null;
                if(count($employee->time_entries) > 0)
                {   
                    $holidays = Holiday::whereBetween('date', [$from, $to])->get();

                    //sum all pay for holiday for absent employee
                    foreach ($holidays as $holiday) 
                    {
                        $holiday_pay += $this->isAbsentOnHoliday($holiday, $rate, $employee->id);
                    }


                    foreach($employee->time_entries as $attendance)
                    {
                        $daysWork++;
                        $time_in    = date('H:i', strtotime($attendance->time_in));
                        $time_out   = date('H:i', strtotime($attendance->time_out));

                        //check if schedule is night shift
                        if($this->nightShift($schedule))
                        {
                            $dr          = $this->dayRate($attendance->date, $rate);
                            $wage        = $dr->regular * 1.10;
                            $holiday_pay = $dr->holiday * 1.10;
                        } 
                        else 
                        {
                            $dr          = $this->dayRate($attendance->date, $rate);
                            $wage        = $dr->regular;
                            $holiday_pay += $dr->holiday;
                        }

                        $basic_pay  += $wage;
                        $late       += $this->lateDeduction($schedule, $time_in, $attendance, $rate);
                    }

                    foreach ($employee->cash_advance as $cash) 
                    {
                        $cashAdvance += $cash->amount;
                    }

                    if(count($employee->loan))
                    {
                        // get previous paid loan
                        $paid_loan = $this->loanPayment($employee->id);

                        if($paid_loan != 0)
                        {
                            $loan_to_pay = $this->monthlyPayment($employee->id);
                        } 
                        else 
                        {
                            $loan_to_pay = $this->monthlyPayment($employee->id);
                        }
                    }

                    $overtime = $this->overtimePay($employee->overtimes, $rate, $schedule);

                    //
                    //salary earnings
                    //
                    $salary = [];
                    $salary['date']             = date('Y-m-d');
                    $salary['date_range']       = $request->from.' to '.$request->to;
                    $salary['days']             = $daysWork;
                    $salary['basic']            = $basic_pay + $leaveWithPay;
                    $salary['cola']             = $daysWork * 10;
                    $salary['overtime_regular'] = $overtime->regular;
                    $salary['overtime_night']   = $overtime->night;
                    $salary['holiday']          = $holiday_pay;
                    $salary['bonus']            = count($employee->bonuses) ? $employee->bonuses->last()->amount : 0;
                    $salary['allowance']        = $allowance / 2;
                    $salary['gross']            = $salary['basic'] + $salary['cola'] + $salary['bonus'] 
                                                + $salary['overtime_regular'] + $salary['overtime_night'];

                    //
                    //salary deductions
                    //

                    //
                    //check contribution if can be deducted
                    //
                    if(count($request->contribution))
                    {
                        $cont = $this->Contributions($salary['gross']);

                        if(count($cont))
                        {
                            $cont_deduct =  $cont->sss_employee;
                            $cont_deduct += $cont->philc_employee;
                            $cont_deduct += $cont->hdmf;
                        }
                    }
                    else
                    {
                        $slr = Salary::with('contributions')
                                ->where('employee_id', $employee->id)
                                ->whereBetween('date', [date('Y-m-d'), date('Y-m-d')])
                                ->first();

                        if(count($slr))
                        {
                            if(count($slr->contributions))
                            {
                                $cc =  $slr->contributions->first();

                                if(count($cc))
                                {
                                    $slr->contributions()->detach($cc);
                                    $cc->delete();
                                }

                            }
                        }
                    }

                    //
                    //check tax if can be deducted
                    //
                    if(count($request->tax))
                    {
                        $wtax = $this->withHoldingTax($employee, $salary['gross'] - $cont_deduct);
                    }


                    $salary['tax']              = $wtax;
                    $salary['cash_advance']     = $cashAdvance;
                    $salary['late']             = $late;
                    $salary['loan']             = $loan_to_pay != 0 ? $loan_to_pay : 0;
                    $salary['total_deductions'] = $salary['cash_advance'] + $salary['late'] + $salary['loan'] + $cont_deduct + $salary['tax'];

                    //
                    //check if deductions is greater than total salary
                    //set cash advance amount and loan to 0
                    //
                    if($salary['total_deductions'] > $salary['gross'])
                    {
                        $salary['total_deductions']   += $salary['late'];
                        $salary['cash_advance ']      = 0;
                        $salary['loan ']              = 0;
                    }

                    //
                    // compute net pay
                    //
                    $salary['net_pay'] = $salary['gross'] - $salary['total_deductions'] + $salary['allowance'] + $salary['holiday'];

                    $salary = Salary::updateOrCreate([
                            'date'          => date('Y-m-d'),
                            'employee_id'   => $employee->id
                        ],
                        [
                            'date_range'        => $salary['date_range'],
                            'days'              => $salary['days'],
                            'basic'             => $salary['basic'],
                            'holiday'           => $salary['holiday'],
                            'cola'              => $salary['cola'],
                            'overtime_pay'      => $salary['overtime_regular'],
                            'overtime_pay_night'=> $salary['overtime_night'],
                            'bonus'             => $salary['bonus'],
                            'allowance'         => $salary['allowance'],
                            'gross'             => $salary['gross'],
                            'tax'               => $salary['tax'],
                            'cash_advance'      => $salary['cash_advance'],
                            'late'              => $salary['late'],
                            'loan'              => $salary['loan'],
                            'total_deductions'  => $salary['total_deductions'],
                            'net_pay'           => $salary['net_pay']
                        ]);

                    //
                    // attach salary and contribution
                    //
                    if(count($request->contribution))
                    {
                        $salary->contributions()->attach($cont);
                    }

                    //
                    //check if employee is not active then hold salary
                    //
                    if($employee->working_status == 'Dismissed')
                    {
                        $this->dismissedEmployee($employee, $salary);
                    }

                    //
                    //check payment for cash advance
                    //
                    if($cashAdvance == $salary->cash_advance)
                    {
                        $employee->cash_advance()->update(['status' => 'Paid']);
                    }

                    $paid_loan += $salary->loan;

                    if(count($employee->loan))
                    {
                        if($employee->loan->amount == $paid_loan)
                        {
                            $employee->loan()->update(['status' => 'Paid']);
                        }
                    }

                    $report_gross   += $salary->gross;
                    $report_deduct  += $salary->total_deductions;
                    $report_netpay  += $salary->net_pay;
                } 
            }
        }

        $this->createReport($report_gross, $report_deduct, $report_netpay);

    	return redirect()->route('admin.salary.index');
    }

    public function dismissedEmployee($employee, $salary){
        $backpay = new BackPay();
        $backpay->employee()->associate($employee);
        $backpay->date = $salary->date;
        $backpay->amount = $salary->net_pay;
        $backpay->save();
    }

    public function isAbsentOnHoliday($holiday, $rate, $employee_id){
        $pay        = 0;
        $present    = EmployeeTimeEntries::where('employee_id', $employee_id)
                    ->whereBetween('date', [$holiday->date, $holiday->date])
                    ->count();

        //check if employee is did not work on holiday
        if(!$present)
        {
            if($holiday->type == 'Regular Holiday')
            {
                $pay = ($rate / 22);
            }
        }

        return $pay;
    }

    public function loanPayment($employee_id){
        //get starting loan date
        $unpaid_loan        = Loan::where('status', 'Unpaid')->where('request_status', 'Approved')->first();
        $previous_salary    = 0;

        if(count($unpaid_loan))
        {
            $previous_salary = Salary::selectRaw('sum(loan) as paid_loan')
                ->where('employee_id', $employee_id)
                ->whereBetween('date', [$unpaid_loan->date, date('Y-m-d')])
                ->orderBy('date', 'desc')
                ->groupBy('loan')
                ->first();

            $previous_salary = count($previous_salary) ? $previous_salary->paid_loan : 0;
        }

        return $previous_salary != 0 ? $previous_salary : 0;
    }

    public function overtimePay($overtimes, $monthly_rate, $schedule){
        $schedules      = App('App\Http\Controllers\EmployeeController')->schedule();
        $schedule       = $schedules[$schedule];
        $index          = strpos($schedule, '-');
        $out            = substr($schedule, $index + 1);
        $regular_pay    = 0;
        $night_pay      = 0;
        $rate           = 0;

        foreach ($overtimes as $ot) {
            $holiday        = Holiday::where('date', $ot->date)->first();
            $sched_out      = date('H', strtotime($out));
            $hr             = date('H', strtotime($ot->time_rendered));
            $min            = date('i', strtotime($ot->time_rendered));
            // $hr             = $hr + $sched_out;  //need to identify time if night diff
            $rendered_hour  = 0;

            if($hr > $sched_out)
            {
                $rendered_hour = $hr - $sched_out;
            }

            if(count($holiday))
            {
                if($holiday->type == 'Regular Holiday')
                {
                    $rate = ((($monthly_rate / 22) * 2 + 100) / 7.5) * 2.6;
                } 
                else 
                {    //Special Holiday
                    $rate = ((($monthly_rate / 22) * 1.3) / 7.5) * 1.69;
                }
            } 
            else //regular day
            {
                $rate = (($monthly_rate / 22) / 7.5);
            }

            //has overtime
            if($hr >= $sched_out)
            {
                //night shift differential overtime from 10pm to 12md
                if(($hr >= 22 && $hr <= 24))
                {
                    $night_pay      += ($rate * 1.10) * ($hr - 22);
                    $night_pay      += (($rate * 1.10) / 60) * $min;
                    $rendered_hour  = $rendered_hour - ($hr % 22);   //deduct computed hours

                }
                elseif($hr % 6 && ($hr < 12))                        //from 12md to 6am and time is not less than 12nn
                {
                    $night_pay      += ($rate * 1.10) * ($hr - 6);
                    $night_pay      += (($rate * 1.10) / 60) * $min;
                    $rendered_hour  = $rendered_hour - ($hr % 6);    //deduct computed hours
                }
                
                $regular_pay += $rate * $rendered_hour;
                $regular_pay += ($rate / 60) * $min;
            }
        }

        $array = (object)['regular' => $regular_pay, 'night' => $night_pay];

        return $array;
    }

    public function dayRate($date, $rate){
        $holiday = Holiday::where('date', $date)->first();

        $salary = [];
        $hpay   = 0;
        $reg    = 0;

        if(count($holiday))
        {
            if($holiday->type == 'Regular Holiday'){
                $rate = ($rate / 22);
                $rate = ($rate * 2 + 100);
            } else {    //Special Holiday
                $rate = ($rate / 22) * 1.69;
            }

            $hpay = $rate;
        } else {
            $rate = $rate / 22;
            $reg = $rate;
        }


        $array = [
            'regular'  => $reg,
            'holiday'  => $hpay
        ];

        $salary = (object)$array;

        return $salary;
    }

    public function nightShift($schedule){
        $schedules  = App('App\Http\Controllers\EmployeeController')->schedule();
        $schedule   = $schedules[$schedule];
        $sched_in   = date('H', strtotime(strrev(substr(strrev($schedule), strpos(strrev($schedule), '-') + 1))));

        if($sched_in >= 22)
        {
            return 1;
        }
        return 0;
    }

    public function lateDeduction($schedule, $time_in, $date, $rate){
        $schedules = App('App\Http\Controllers\EmployeeController')->schedule();
        $schedule = $schedules[$schedule];
        $sched_in = date('H', strtotime(substr($schedule, 0, strpos($schedule, '-'))));
        $hr = date('H', strtotime($time_in));
        $min = date('i', strtotime($time_in));
        $rate = $this->dayRate($date, $rate)->regular;
        $deduction = 0;

        if($hr > $sched_in || $min > 0){
            if($hr >= 22 && $hr <= 24){
                $rate = $rate * 1.10;
            }

            //work early
            if($hr < $sched_in){
                $deduction = 0;
            } else {
                $deduction = ($rate / 8) * ($hr - $sched_in);
                $deduction += (($rate / 8) / 60) * $min;
            }
        }

        return $deduction;
    }

    public function leave($id, $from, $to, $rate){
        $dates      = [];
        $payment    = 0;
        $attendance = EmployeeTimeEntries::where('employee_id', $id)->get()->pluck('date'); //check employee attendance of his leave request
        $holidays   = Holiday::whereBetween('date', [$from, $to])->get();
        $leaves     = Leave::whereBetween('date', [$from, $to])
                    ->where('employee_id', $id)
                    ->whereNotIn('date', $attendance)
                    ->get();

        foreach ($leaves as $leave) {
            for($i = 0; $i < $leave->days; $i++)
            {
                $date       = date('Y-m-d', strtotime($leave->date.' +'.$i.' day'));
                $dates[$i]  = $date;
            }
        }

        foreach ($holidays as $holiday) {
            $index = array_search($holiday->date, $dates);
            unset($dates[$index]);
        }

        $payment = count($dates) * ($rate / 22);
        return $payment;
    }

    public function Contributions($salary){
        $sss    = $this->SSSContribution($salary);
        $philc  = $this->PhilcContribution($salary);

        $cont = new Contribution();
        $cont->date             = date('Y-m-d');
        $cont->sss_employer     = $sss->employer;
        $cont->sss_employee     = $sss->employee;
        $cont->sss_total        = $sss->total;
        $cont->philc_employer   = $philc->employer;
        $cont->philc_employee   = $philc->employee;
        $cont->philc_total      = $philc->total;
        $cont->hdmf             = 100;
        $cont->save();

        return $cont;
    }

    public function SSSContribution($salary){
        $msc        = [];
        $base       = 1000;
        $total      = 0;
        $employer   = 0;
        $employee   = 0;

        for($i = 0; $i < 31; $i++){
            if($base <= 16000)
            {
                $msc[$i] = $base;
                $base += 500;
            }
        }

        if($salary <= 16000)
        {
            $credit     = $this->nearest($msc, $salary);
            $total      = $credit   * 0.11;
            $employer   = $total    * 0.669697;
            $employee   = $total    * 0.330303; 
        }
        else
        {
            $total      = 1760;
            $employer   = 1178.7;
            $employee   = 581.3;
        }
        
        $ec         = $salary < 15000 ? 10 : 30;
        $employer   = $employer + $ec;

        $array = [
            'total'     => $total, 
            'employer'  => round($employer, 1, PHP_ROUND_HALF_UP), 
            'employee'  => round($employee, 1, PHP_ROUND_HALF_UP)
        ];

        $contribution = (object)$array;

        return $contribution;
    }

    public function PhilcContribution($salary){
        $total      = 0;
        
        if($salary < 9000)
        {
            $total = 100;
        }
        elseif($salary >= 9000 && $salary <= 35000)
        {
            $base       = 12.5;
            $multiplier = (($salary - 8000) / 1000);
            $total      = ($base * $multiplier) + 100;
        }
        else
        {
            $total = 473.50;
        }

        $array = [
            'total'     => $total * 2, 
            'employer'  => $total, 
            'employee'  => $total
        ];

        $contribution = (object)$array;

        return $contribution;
    }

    public function withHoldingTax($employee, $rate){
        $less   = 0;
        $excess = 0;
        $wTax   = 0;
        //
        //semi-monthly
        //
        // $sme    = (object)[2083,2500,3333,5000,7917,12500,22917];
        // $sme1   = (object)[3125,3542,4375,6042,8958,13542,23958];
        // $sme2   = (object)[4167,4583,5417,7083,10000,14583,25000];
        // $sme3   = (object)[5208,5625,6458,8125,11042,15625,26042];
        // $sme4   = (object)[6250,6667,7500,9167,12083,16667,27083];
        // $taxTbl = [
        //             0 => (object)['base' => 0,      'tax' => 0.05],
        //             1 => (object)['base' => 20.83,  'tax' => 0.10],
        //             2 => (object)['base' => 104.17, 'tax' => 0.15],
        //             3 => (object)['base' => 354.17, 'tax' => 0.20],
        //             4 => (object)['base' => 937.50, 'tax' => 0.25],
        //             5 => (object)['base' => 2083.33,'tax' => 0.30],
        //             6 => (object)['base' => 5208.33,'tax' => 0.32],
        //           ];

        //
        //monthly
        //
        $sme    = (object)[0,4167,5000,6667,10000,15833,25000,45833];
        $sme1   = (object)[0,6250,7083,8750,12083,17917,27083,47917];
        $sme2   = (object)[0,8333,9167,10833,14167,20000,29167,50000];
        $sme3   = (object)[0,10417,11250,12917,16250,22083,31250,52083];
        $sme4   = (object)[0,12500,13333,15000,18333,24167,33333,54167];
        $taxTbl = [
                    0 => (object)['base' => 0,          'tax' => 0.00],
                    1 => (object)['base' => 0,          'tax' => 0.05],
                    2 => (object)['base' => 41.64,      'tax' => 0.10],
                    3 => (object)['base' => 208.33,     'tax' => 0.15],
                    4 => (object)['base' => 708.33,     'tax' => 0.20],
                    5 => (object)['base' => 1875.00,    'tax' => 0.25],
                    6 => (object)['base' => 4166.67,    'tax' => 0.30],
                    7 => (object)['base' => 10416.67,   'tax' => 0.32],
                  ];

        switch($employee->no_of_dependents){
            case 0:
                $less       = $this->nearest($sme, $rate);
                $excess     = $rate - $less;
                $index      = array_search($less, (array)$sme);
                $toe        = $taxTbl[$index];
                $wTax       = ($excess * $toe->tax) + $toe->base ;
            break;
            case 1:
                $less       = $this->nearest($sme1, $rate);
                $excess     = $rate - $less;
                $index      = array_search($less, (array)$sme1);
                $toe        = $taxTbl[$index];
                $wTax       = ($excess * $toe->tax) + $toe->base ;
            break;
            case 2:
                $less       = $this->nearest($sme2, $rate);
                $excess     = $rate - $less;
                $index      = array_search($less, (array)$sme2);
                $toe        = $taxTbl[$index];
                $wTax       = ($excess * $toe->tax) + $toe->base ;
            break;
            case 3:
                $less       = $this->nearest($sme3, $rate);
                $excess     = $rate - $less;
                $index      = array_search($less, (array)$sme3);
                $toe        = $taxTbl[$index];
                $wTax       = ($excess * $toe->tax) + $toe->base ;
            break;
            case 4:
                $less       = $this->nearest($sme4, $rate);
                $excess     = $rate - $less;
                $index      = array_search($less, (array)$sme4);
                $toe        = $taxTbl[$index];
                $wTax       = ($excess * $toe->tax) + $toe->base ;
            break;
        }

        return $wTax;
    }

    public function nearest($arr, $search){
        $closest = null;

        foreach($arr as $item){
            if ($closest === null || 
                abs($search - $closest) > abs($item - $search))
            {
                if($item <= $search)
                    $closest = $item;
            }
        }

        return $closest;
    }

    public function printPreview($id){
        if(! Gate::allows('computation_view')){
            return response()->view('errors.401', [], 401);
        }

        $salary = Salary::findOrFail($id);

        return view('admin.salary.print', compact('salary'));
    }

    public function isSunday($date){
        $sunday = date('Y-m-d', strtotime('sunday'));

        return $date == $sunday ? 1:0;
    }

    public function createReport($gross, $deduct, $netpay){
        $report = Report::updateOrCreate(
            ['date' => date('Y-m-d')],
            [
                'gross'     => $gross,
                'deduction' => $deduct,
                'netpay'    => $netpay
            ]
        );
    }

    public function monthlyPayment($employee_id){
        $loan = Loan::where('employee_id', $employee_id)
                ->where('status', 'Unpaid')
                ->where('request_status', 'Approved')
                ->first();

        return $loan->monthly_payment;
    }

    public function allowanc($employee_id){
        $allowances = Allowance::where('employee_id', $employee_id)->get();
        $amount     = 0;

        foreach ($allowances as $allowance) {
            $amount += $allowance->amount;
        }

        return $amount > 0 ? $amount / 2 : 0;
    }
}

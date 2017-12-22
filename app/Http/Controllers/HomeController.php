<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Employee;
use App\EmployeeTimeEntries;
use App\Salary;
use App\OvertimeRequest;
use App\Month13;
use App\Bonus;
use App\Contribution;
use App\Leave;
use App\LeaveConversion;
use App\Report;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Gate::allows('dashboard_access')){
            return response()->view('errors.401', [], 401);
        }

        $net_pays           = [];
        $leave_total        = 0;
        $time               = EmployeeTimeEntries::whereBetween('date', [date('Y-m-d'), date('Y-m-d')])->get()->pluck('employee_id');
        $active_employee    = Employee::where('working_status', 'Regular')->get()->pluck('id');
        $leave_cash         = LeaveConversion::selectRaw('sum(amount) as total, date')
                                ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                ->groupBy('date')
                                ->get();

        for($i=0; $i < 12; $i++){
            $total  = 0;
            $amount = Report::selectRaw('sum(netpay) as amount')
                    ->whereBetween('date', [
                        date('Y-'.($i +1).'-01'), 
                        date('Y-'.($i +1).'-31')
                    ])->first()->amount;

            for($j = 0; $j < count($leave_cash); $j++)
            {
                $date = date('m', strtotime($leave_cash[$j]['date'])) - 1;

                if($date == $i)
                {
                    $total += $leave_cash[$j]['total'];
                    $leave_total += $leave_cash[$j]['total'];
                }
            }

            $net_pays[$i] = $amount + $total;
        }

        $relations = [
            'active_employees'      => Employee::where('working_status', 'Active')->count(),
            'inactive_employees'    => Employee::whereIn('working_status', ['Inactive', 'On-hold', 'Fired'])->count(),
            'presents'              => Employee::where('working_status', 'Regular')->whereIn('id', $time)->count(),
            'absents'               => Employee::where('working_status', 'Regular')->whereNotIn('id', $time)->count(),
            'overtime'              => OvertimeRequest::where('status', 'Pending')->count(),
            'salary'                => Salary::selectRaw('sum(net_pay) as total')
                                        ->whereIn('employee_id', $active_employee)
                                        ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                        ->first(),
            'sss'                   => Contribution::selectRaw('sum(sss_employer) as employer, sum(sss_employee) as employee')
                                        ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                        ->first(),
            'philc'                 => Contribution::selectRaw('sum(philc_employer) as employer, sum(philc_employee) as employee')
                                        ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                        ->first(),
            'hdmf'                  => Contribution::selectRaw('sum(hdmf) as amount')
                                        ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                        ->first(),                                                 
            'month13'               => Month13::selectRaw('sum(amount) - sum(tax) as total, sum(tax) as tax')
                                        ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                        ->groupBy('date')
                                        ->first(),
            'bonus'                 => Bonus::selectRaw('sum(amount) as total')
                                        ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                        ->first(),
            'tax'                   => Salary::selectRaw('sum(tax) as total')
                                        ->whereIn('employee_id', $active_employee)
                                        ->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                                        ->first(),
            'leave'                 => Leave::where('status', 'Pending')->count(),
            'leave_cash'            => $leave_total,
            'net_pays'              => $net_pays,
        ];

        return view('home', $relations);
    }
}

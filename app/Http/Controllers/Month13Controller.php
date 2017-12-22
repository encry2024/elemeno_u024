<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Employee;
use App\EmployeePosition;
use App\EmployeeTimeEntries;
use App\Month13;

use App\Http\Requests\Update13MonthPayRequest;


class Month13Controller extends Controller
{
    public function index(){
    	if(! Gate::allows('13month_access'))
    	{
    		return response()->view('errors.401', [], 401);
    	}

    	$bonuses = Month13::whereBetween('date', [date('Y-01-01'), date('Y-12-31')])->get();

    	return view('admin.month13.index', compact('bonuses'));
    }

    public function show(){
    	if(! Gate::allows('13month_create')){
    		return response()->view('errors.401', [], 401);
    	}

    	$employees = Employee::all();

    	foreach ($employees as $employee) 
    	{
    		$rate	= $employee->departments->first()->pivot->rate;
    		$bonus  = 0;

    		for($i = 1; $i <= 12; $i++)
    		{
    			$attendance = EmployeeTimeEntries::where('employee_id', $employee->id)
                    ->distinct()
    				->whereBetween('date', [
	    				date('Y-'.$i.'-01'), 
	    				date('Y-'.$i.'-31')
	    			])->count();

    			$bonus += (($rate / 22) / 12) * $attendance;
    		}
            
            $tax = ($bonus > 82000) ? ($bonus * 0.3) : 0;

    		Month13::create([
    				'employee_id' => $employee->id,
    				'date' => date('Y-m-d'),
    				'amount' => $bonus,
                    'tax' => $tax
    			]);
    	}

    	return redirect()->route('admin.month13.index');
    }

    public function edit($id){
    	if(! Gate::allows('13month_edit')){
    		return response()->view('errors.401', [], 401);
    	}

    	$bonus = Month13::findOrFail($id);

    	return view('admin.month13.edit', compact('bonus'));
    }

    public function update(Update13MonthPayRequest $request, $id){
    	if(! Gate::allows('13month_edit')){
    		return response()->view('errors.401', [], 401);
    	}

    	$bonus = Month13::findOrFail($id);
        $bonus->amount = $request->amount;
    	$bonus->tax = ($bonus->amount > 75000) ? ($bonus->amount * 0.3) : 0;
        $bonus->save();

    	return redirect()->route('admin.month13.index');
    }

    public function destroy($id){
        if(! Gate::allows('13month_delete')){
            return response()->view('errors.401', [], 401);
        }

        $bonus = Month13::findOrFail($id);
        $bonus->delete();

        return redirect()->route('admin.month13.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('13month_delete')) {
            return response()->view('errors.401', [], 401);
        }

        if($request->input('ids')) {
           $entries = Month13::whereIn('id', $request->input('ids'))->get();
        }

        foreach ($entries as $entry) {
            $entry->delete();
        }
    }
}

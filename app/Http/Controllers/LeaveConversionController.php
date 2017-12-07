<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Employee;
use App\Leave;
use App\LeaveConversion;
use Carbon\Carbon;

class LeaveConversionController extends Controller
{
    public function index(){
    	if(! Gate::allows('leaveconversion_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$converted = LeaveConversion::whereBetween('date', [date('Y-01-01'), date('Y-12-31')])->get();

    	return view('admin.leaveconversion.index', compact('converted'));
    }

    public function convert(Request $request){
    	if(! Gate::allows('leaveconversion_create'))
    	{
    		return response()->view('errors.401', [], 401);
    	}

    	$from  = new Carbon(str_replace('-', '/', $request->from));
    	$to    = new Carbon(str_replace('-', '/', $request->to));
    	$employees = Employee::where('working_status', '!=', 'Dismissed')->get();

    	foreach ($employees as $employee) {
    		//
    		//count leave used
    		//
    		$used 	= Leave::where('employee_id', $employee->id)
    					->whereBetween('date', [$from, $to])
    					->where('status', 'Approved')
    					->count();

    		$unused = $employee->leave_entitlement - $used;

    		if(count($employee->positions))
    		{
    			$amount = $unused * ($employee->positions->rate / 22);

	    		LeaveConversion::updateOrCreate(
	    			[
	    				'employee_id' 	=> $employee->id,
	    				'date' 			=> date('Y-m-d')
	    			],
	    			[
	    				'unused_leave'	=> $unused,
	    				'amount'		=> $amount
	    			]
	    		);
    		}
    		
    	}

    	return redirect()->route('admin.leaveconversion.index');
    }

    public function destroy($id){
    	if(! Gate::allows('leaveconversion_delete')){
    		return response()->view('errors.401', [], 401);
    	}

    	$leave = LeaveConversion::findOrFail($id);
    	$leave->delete();

    	return redirect()->route('admin.leaveconversion.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('leaveconversion_delete')) {
            return response()->view('errors.401', [], 401);
        }

        if($request->input('ids')) {
           $entries = LeaveConversion::whereIn('id', $request->input('ids'))->get();
        }

        foreach ($entries as $entry) {
            $entry->delete();
        }
    }
}

<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Employee\StoreLeaveRequest;

use App\Leave;
use App\Employee;

use Auth;

class LeaveRequestController extends Controller
{
    public function index(){
        if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }

    	$leaves = Leave::where('employee_id', Auth::user()->employee_id)->orderBy('created_at', 'desc')->get();

    	return view('employee.leave.index', compact('leaves'));
    }

    public function create(){
        $employee   = Employee::findOrFail(Auth::user()->employee_id);
        $used       = Leave::selectRaw('sum(days) as used')
                        ->whereBetween('date', [date('Y-01-01'), date('Y-12-31')])
                        ->where('status', 'Approved')
                        ->first()->used;

        $leave      = $employee->leave_entitlement - $used;

        if($leave == 0)
        {
            return redirect()->back()->with('msg', 'All leave is used!');
        }

    	return view('employee.leave.create');
    }

    public function store(StoreLeaveRequest $request){
        if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }
        
    	Leave::create([
			'employee_id' 	=> Auth::user()->employee->id,
			'date' 			=> $request->date,
			'days'			=> $request->days,
			'reason'		=> $request->reason,
			'status'		=> 1,
		]);

    	return redirect()->route('employee.leave.index');
    }
}

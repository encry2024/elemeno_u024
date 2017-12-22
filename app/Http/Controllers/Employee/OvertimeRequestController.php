<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOvertimeRequest;
use Illuminate\Support\Facades\Gate;

use App\OvertimeRequest;
use App\EmployeeTimeEntries;
use Auth;

class OvertimeRequestController extends Controller
{
    public function index(){
        if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }

    	$overtimes = OvertimeRequest::orderBy('date', 'desc')->get();

    	return view('employee.overtime.index', compact('overtimes'));
    }

    public function create(){
        if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }

    	return view('employee.overtime.create');
    }

    public function store(StoreOvertimeRequest $request){
    	if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }

        $entry = EmployeeTimeEntries::where('employee_id', Auth::user()->employee->id)
                    ->where('date', $request->date)
                    ->first();

        if(count($entry)){
            OvertimeRequest::create([
                'employee_id'   => Auth::user()->employee->id,
                'date'          => $request->date,
                'time_rendered' => $request->time_rendered,
                'status'        => 'Pending'
            ]);

            return redirect()->route('employee.overtime.index');
        }

		return back()->with('msg', 'Date not match');
    }
}

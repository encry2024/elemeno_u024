<?php

namespace App\Http\Controllers;

use App\EmployeeTimeEntries;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Employee;
use App\EmployeeDepartment;
use App\EmployeePosition;

class EmployeeAttendanceController extends Controller
{
    public function index(){
    	if(! Gate::allows('attendance_record_management_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$relations = [
    		'departments' => EmployeeDepartment::get()->pluck('name', 'id'),
    		'positions'   => EmployeePosition::get()->pluck('position', 'id'),
            'employees'   => Employee::with(['time_entries' => function($q) {
                                $q->whereBetween('date', [date('Y-m-d'), date('Y-m-d')]);
                            }])->get(),
    	];

    	return view('admin.attendance.index', $relations);
    }

    public function search(Request $request){
    	if(! Gate::allows('attendance_record_management_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$relations = [
    		'departments' => EmployeeDepartment::get()->pluck('name', 'id'),
    		'positions'   => EmployeePosition::get()->pluck('position', 'id'),
    		'employees'   => Employee::with(['departments', 'departments.positions', 'time_entries' => function($q) use($request) {
                	    		$q->where('date', $request->date);
                	    	}])->whereHas('departments', function($q) use($request) {
                		    	$q->where('department_id', $request->department_id);
                		    })->whereHas('departments.positions', function($q) use($request) {
                		    	$q->where('id', $request->position_id);
                		    })->whereHas('time_entries', function($q) use($request) {
                		    	$q->where('date', $request->date);
                		    })->get(),
    	];

    	return view('admin.attendance.index', $relations);
    }
}

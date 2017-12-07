<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

use App\Employee;
use App\Salary;
use Auth;

class SummaryController extends Controller
{
    public function index(){
        if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }

    	$employee = Employee::with(['salaries' => function($q){
    		$q->orderby('date', 'desc');
    	}])->where('id', Auth::user()->employee->id)->first();

    	return view('employee.summary.index', compact('employee'));
    }

    public function show($id){
        if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }
        
    	$salary = Salary::findOrFail($id);

    	return view('employee.summary.show', compact('salary'));
    }
}

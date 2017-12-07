<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\User;
use App\Leave;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\Employee\UpdateEmployeeRequest;

use Auth;

class InfoController extends Controller
{

	public function __construct()
    {
		$this->middleware('auth');
	}

    public function index()
    {
        if(! Gate::allows('employee_page_access')){
            return response()->view('errors.401', [], 401);
        }

        $employee   = Employee::with(['time_entries' => function($q) {
                        $q->whereBetween('date', [date('Y-m-01'), date('Y-m-31')])->orderBy('date', 'desc');
                    }])->where('id', Auth::user()->employee->id)->first();

        $time       = app('\App\Http\Controllers\EmployeeController')->schedule();

        $used       = Leave::selectRaw('sum(days) as used')
                        ->whereBetween('date', [date('Y-01-01'), date('Y-12-31')])
                        ->where('status', 'Approved')
                        ->first()->used;

        $leave      = $employee->leave_entitlement - $used;

    	return view('employee.info.index', compact('employee', 'time', 'leave'));
    }

    public function show()
    {
    	// return view('employee.info.index');
    }

    public function edit($id)
    {
    	$employee = Employee::findOrFail($id);

    	return view('employee.info.edit', compact('employee'));
    }

    public function update(UpdateEmployeeRequest $request, $id){
    	$employee = Employee::findOrFail($id);
    	$employee->update($request->all());

        $user = User::find(Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

    	return redirect()->route('employee.info.index');
    }
}

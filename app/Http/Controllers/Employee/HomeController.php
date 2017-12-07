<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

use App\Http\Requests\EmployeeLoginRequest;

use App\Employee;
use App\User;
use Auth;
use Hash;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            return redirect('/home');
        }

        return view('employee.index');
    }


    public function auth(EmployeeLoginRequest $request)
    {
        $employee = Employee::with('user')->where('employee_no', $request->employee_no)->first();

        if(! Hash::check($request->password, $employee->user->password))
        {
            return redirect()->back()->with('failed', 'Invalid Credentials');
        }

        if(count($employee)){
            $user = User::where('employee_id', $employee->id)->first();
            Auth::loginUsingId($user->id, true);

            return redirect()->route('employee.info.index');
        }

        return redirect()->back()->with('failed', 'Employee not found!');
    }
}

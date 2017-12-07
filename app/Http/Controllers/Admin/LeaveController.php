<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Leave;
use App\Log;
use Auth;


class LeaveController extends Controller
{
    public function index(){
    	if(! Gate::allows('leave_access')){
    		return abort(401);
    	}

    	$leaves = Leave::orderBy('date', 'desc')->get();

    	return view('admin.leave.index', compact('leaves'));
    }

    public function approve($id){
    	if(! Gate::allows('leave_edit')){
    		return abort(401);
    	}

    	$leave = Leave::findOrFail($id);
    	$leave->update(['status' => 'Approved']);

        $this->log();

    	return redirect()->route('admin.leave.index');
    }

    public function deny($id){
        if(! Gate::allows('leave_edit')){
            return abort(401);
        }

        $leave = Leave::findOrFail($id);
        $leave->update(['status' => 'Denied']);

        $this->log();

        return redirect()->route('admin.leave.index');
    }

    public function log(){

        $employee = Auth::user()->employee;
        $name     = 'Admin';

        if(count($employee))
        {
            $name = Auth::user()->employee->fullname();
        }

        Log::create(
            [
                'date' => date('Y-m-d h:i:s'),
                'name' => $name,
                'type' => 'Leave Request'
            ]
        );
    }
}

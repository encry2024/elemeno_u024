<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\OverTimeRequest;

use App\Http\Requests\UpdateOvertimeRequest;
use App\Log;
use Auth;

class OverTimeController extends Controller
{
    public function index(){
    	if(! Gate::allows('overtime_access')){
    		return response()->view('errors.401', [], 401);
    	}

    	$overtimes = OverTimeRequest::orderBy('date', 'desc')->get();

    	return view('admin.overtime.index', compact('overtimes'));
    }

    public function approve($id){
    	if(! Gate::allows('overtime_edit')){
    		return response()->view('errors.401', [], 401);
    	}

    	$overtime = OverTimeRequest::findOrFail($id);
    	$overtime->update(['status' => 'Approved']);

        $this->log();

    	return redirect()->route('admin.overtime.index');
    }

    public function deny($id){
        if(! Gate::allows('overtime_edit')){
            return response()->view('errors.401', [], 401);
        }

        $overtime = OverTimeRequest::findOrFail($id);
        $overtime->update(['status' => 'Denied']);

        $this->log();

        return redirect()->route('admin.overtime.index');
    }

    public function edit($id){
        if(! Gate::allows('overtime_edit')){
            return response()->view('errors.401', [], 401);
        }

        $overtime = OverTimeRequest::findOrFail($id);

        return view('admin.overtime.edit', compact('overtime'));
    }

    public function update(UpdateOvertimeRequest $request, $id){
        if(! Gate::allows('overtime_edit')){
            return response()->view('errors.401', [], 401);
        }

        $overtime = OvertimeRequest::findOrFail($id);
        $overtime->update($request->all());

        return redirect()->route('admin.overtime.index');
    }

    public function log(){

        $employee = Auth::user()->employee;
        $name     = 'Admin';

        if(count($employee))
        {
            $name = Auth::user()->employee->fullname();
        }

        Log::updateOrCreate(
            [
                'date' => date('Y-m-d h:i:s'),
                'name' => $name,
                'type' => 'Overtime Request'
            ]
        );
    }
}

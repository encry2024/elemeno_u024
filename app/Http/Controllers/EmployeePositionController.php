<?php

namespace App\Http\Controllers;

use App\EmployeePosition;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeePositionRequest;
use App\Http\Requests\UpdateEmployeePositionRequest;
use App\Allowance;
use App\Employee;

class EmployeePositionController extends Controller
{
    public function index()
    {
        if (! Gate::allows('position_access')) {
            return response()->view('errors.401', [], 401);
        }

        $position = EmployeePosition::all();

        return view('admin.position.index', compact('position'));

    }

    public function create()
    {
        if (! Gate::allows('position_create')) {
            return response()->view('errors.401', [], 401);
        }

        $hasRole = \App\EmployeePosition::all()->pluck('employee_id');

        $department = \App\EmployeeDepartment::get()->pluck('name', 'id')->prepend('Please select', '');
        $employee = \App\Employee::select(DB::raw("CONCAT(fname,' ', lname) AS full_name, id"))
                    ->whereNotIn('id', $hasRole)
                    ->pluck('full_name','id')->prepend('Please select', '');
        
        return view('admin.position.create', compact('department', 'employee'));

    }

    public function store(StoreEmployeePositionRequest $request)
    {
        if (! Gate::allows('position_create')) {
            return response()->view('errors.401', [], 401);
        }

        $inputs = array_except(
            $request->toArray(),
            [
                '_token',
                'employee_id',
                'department_id',
                'position',
                'rate',
                'allowance'
            ]
        );


        for($i = 1; $i <= (count($inputs) / 2); $i++)
        {
            $allowance = new Allowance();
            $allowance->employee_id = $request->employee_id;
            $allowance->type        = $inputs['desc_'.$i];
            $allowance->amount      = $inputs['input_'.$i];
            $allowance->save();
        }

        $position = EmployeePosition::create($request->all());

        return redirect()->route('admin.position.index');
    }

    public function edit($id)
    {
        if (! Gate::allows('position_edit')) {
            return response()->view('errors.401', [], 401);
        }

        $position = EmployeePosition::findOrFail($id);
        $department = \App\EmployeeDepartment::get()->pluck('name', 'id')->prepend('Please select', '');
        $employee = \App\Employee::findOrFail($position->employee_id);


        return view('admin.position.edit', compact('position', 'department', 'employee'));

    }

    public function update(UpdateEmployeePositionRequest $request, $id)
    {
        if (! Gate::allows('position_edit')) {
            return response()->view('errors.401', [], 401);
        }
        $inputs = array_except($request->toArray(),
            [
                '_method',
                '_token',
                'employee_id',
                'department_id',
                'position',
                'rate',
                'allowance',
                'employee_name',
                'allowance_description'
            ]
        );

        $allowances = Allowance::where('employee_id', $request->employee_id)->get();

        foreach($allowances as $allowance)
        {
            $allowance->delete();
        }

        for($i = 1; $i <= (count($inputs) / 2); $i++)
        {
            if(count($inputs['input_'.$i]))
            {
                $allowance = new Allowance();
                $allowance->employee_id = $request->employee_id;
                $allowance->type        = $inputs['desc_'.$i];
                $allowance->amount      = $inputs['input_'.$i];
                $allowance->save();

            }
        }

        $position = EmployeePosition::findOrFail($id);
        $position->update($request->all());



        return redirect()->route('admin.position.index');

    }

    public function show($id)
    {
        if (! Gate::allows('position_view')) {
            return response()->view('errors.401', [], 401);
        }

        $position = EmployeePosition::findOrFail($id);
        $employee = Employee::findOrFail($position->employee_id);


        return view('admin.position.show', compact('position', 'employee'));

    }

    public function destroy($id)
    {
        if (! Gate::allows('position_delete')) {
            return response()->view('errors.401', [], 401);
        }

        $position = EmployeePosition::findOrFail($id);
        $position->delete();

        return redirect()->route('admin.position.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('position_delete')) {
            return response()->view('errors.401', [], 401);
        }
        if ($request->input('ids')) {
            $entries = EmployeePosition::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

    public function delete($id){
        $allowance = Allowance::findOrFail($id);

        if(count($allowance))
            $allowance->delete();

        return back();
    }
}

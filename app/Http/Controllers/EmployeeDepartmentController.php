<?php

namespace App\Http\Controllers;

use App\EmployeeDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeDepartmentRequest;
use App\Http\Requests\UpdateEmployeeDepartmentRequest;

class EmployeeDepartmentController extends Controller
{
    public function index()
    {
        if (! Gate::allows('department_access')) {
            return response()->view('errors.401', [], 401);
        }

        $department = EmployeeDepartment::all();

        return view('admin.department.index', compact('department'));
    }

    public function create()
    {
        if (! Gate::allows('department_create')) {
            return response()->view('errors.401', [], 401);
        }

        return view('admin.department.create');

    }

    public function store(StoreEmployeeDepartmentRequest $request)
    {
        if (! Gate::allows('department_create')) {
            return response()->view('errors.401', [], 401);
        }

        $department = EmployeeDepartment::create($request->all());

        return redirect()->route('admin.department.index');
    }

    public function edit($id)
    {
        if (! Gate::allows('department_edit')) {
            return response()->view('errors.401', [], 401);
        }

        $department = EmployeeDepartment::findOrFail($id);

        return view('admin.department.edit', compact('department'));
    }

    public function update(UpdateEmployeeDepartmentRequest $request, $id)
    {
        if (! Gate::allows('department_edit')) {
            return response()->view('errors.401', [], 401);
        }

        $department = EmployeeDepartment::findOrFail($id);
        $department->update($request->all());

        return redirect()->route('admin.department.index');
    }

    public function show($id)
    {
        if (! Gate::allows('department_view')) {
            return response()->view('errors.401', [], 401);
      }

        $position = \App\EmployeePosition::where('department_id', $id)->get();

        $department = EmployeeDepartment::findOrFail($id);

        return view('admin.department.show', compact('department', 'position'));

    }

    public function destroy($id)
    {
        if (! Gate::allows('department_delete')) {
            return response()->view('errors.401', [], 401);
        }

        $department = EmployeeDepartment::findOrFail($id);
        $department->delete();

        return redirect()->route('admin.department.index');
    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('department_delete')) {
            return response()->view('errors.401', [], 401);
        }
        if ($request->input('ids')) {
            $entries = EmployeeDepartment::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

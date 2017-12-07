<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Employee;
use App\EmployeeDepartment;
use App\EmployeePosition;
use App\User;
use App\Leave;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        if (! Gate::allows('employee_access')) {
            return response()->view('errors.401', [], 401);
        }

        $relations = [
            'departments' => EmployeeDepartment::get()->pluck('name','id'),
            'positions' => EmployeePosition::get()->pluck('position','id'),
            'employee' => Employee::all(),
            'time' => $this->schedule(),
        ];

        return view('admin.employee.index', $relations);
    }

    public function search(Request $request){
        if (! Gate::allows('employee_access')) {
            return response()->view('errors.401', [], 401);
        }

        $relations = [
            'departments' => EmployeeDepartment::get()->pluck('name','id'),
            'positions' => EmployeePosition::get()->pluck('position','id'),
            'employee' => Employee::with(['departments' => function($q) use($request) {
                    $q->where('department_id', $request->department_id);
                }, 'departments.positions' => function($q) use($request) {
                    $q->where('id', $request->position_id);
                }])
                ->whereHas('departments', function($q) use($request){
                    $q->where('department_id', $request->department_id);
                })
                ->whereHas('departments.positions', function($q) use($request){
                    $q->where('id', $request->position_id);
                })->get(),
        ];

        return view('admin.employee.index', $relations);
    }

    public function create()
    {
        if (! Gate::allows('employee_create')) {
            return response()->view('errors.401', [], 401);
        }
        
        $time = $this->schedule();

        return view('admin.employee.create', compact('time'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        if (! Gate::allows('employee_create')) {
            return response()->view('errors.401', [], 401);
        }

        $employee = Employee::create($request->all());

        User::create([
            'email'         => $employee->email,
            'password'      => bcrypt(substr(strtolower($employee->fname), 0, 1).strtolower($employee->lname)),
            'role_id'       => 3,       //employee role
            'employee_id'   => $employee->id
        ]);

        return redirect()->route('admin.employee.index');
    }

    public function edit($id)
    {
        if (! Gate::allows('employee_edit')) {
            return response()->view('errors.401', [], 401);
        }

        $employee = Employee::findOrFail($id);
        $time = $this->schedule();

        return view('admin.employee.edit', compact('employee','time'));
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        if (! Gate::allows('employee_edit')) {
            return response()->view('errors.401', [], 401);
        }

        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        User::updateOrCreate(
            ['employee_id' => $employee->id],
            [
                'email'         => $employee->email,
                'password'      => bcrypt(substr($employee->fname, 0, 1).$employee->lname),
                'role_id'       => 2
            ]
        );

        return redirect()->route('admin.employee.index');
    }

    public function show($id)
    {
        if (! Gate::allows('employee_view')) {
            return response()->view('errors.401', [], 401);
      }

        $employee   = Employee::findOrFail($id);
        $time       = $this->schedule();
        $used       = Leave::selectRaw('sum(days) as used')
                        ->whereBetween('date', [date('Y-01-01'), date('Y-12-31')])
                        ->where('status', 'Approved')
                        ->first()->used;

        $leave      = $employee->leave_entitlement - $used;

        return view('admin.employee.show', compact('employee', 'time', 'leave'));

    }

    public function destroy($id)
    {
        if (! Gate::allows('employee_delete')) {
            return response()->view('errors.401', [], 401);
        }

        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.employee.index');

    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('employee_delete')) {
            return response()->view('errors.401', [], 401);
        }

        if($request->input('ids')) {
           $entries = Employee::whereIn('id', $request->input('ids'))->get();
        }

        foreach ($entries as $entry) {
            $entry->delete();
        }
    }

    public function schedule(){
        $time = [];
        for($i = 1; $i <= 24; $i++){
            $am = $i;
            $pm = $i + 9;
            $t1;
            $t2;

            if($am >= 0 && $am <= 12){
                $t1 = $am.' AM';
                $t1 = ($t1 == '12 AM') ? '12 PM': $t1;

                if($pm >= 12){
                    $t2 = ($pm - 12).' PM';
                    $t2 = ($t2 == '0 PM') ? '12 PM' : $t2;
                } else {
                    $t2 = $pm.' AM';
                }
            } else {
                $t1 = ($am - 12).' PM';
                $t1 = ($t1 == '12 PM') ? '12 AM' : $t1;
                $pm = $pm - 12;

                if($pm >= 12){
                    $t2 = ($pm - 12).' AM';
                    $t2 = ($t2 == '0 AM') ? '12 AM' : $t2;
                } else {
                    $t2 = $pm.' PM';
                }

            }

            array_push($time, $t1.' - '.$t2);
        }
        return $time;
    }
}

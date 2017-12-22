<?php

namespace App\Http\Controllers;

use App\EmployeeTimeEntries;
use App\OvertimeRequest;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeTimeEntriesRequest;
use App\Http\Requests\UpdateEmployeeTimeEntriesRequest;

class EmployeeTimeEntriesController extends Controller
{
    public function index()
    {
        if (! Gate::allows('time_entries_access')) {
            return response()->view('errors.401', [], 401);
        }
        // sample time entries
//        for($i = 1; $i <= date('d'); $i++)
//         {
//             if($i != 5 && $i != 6 && $i != 12 && $i != 13 && $i != 19 && $i != 20 && $i != 26 && $i != 27)
//             {
//                 EmployeeTimeEntries::create([
//                     'employee_id' => 1,
//                     'date' => PHP ARTISAdate('Y-m-'.$i),
//                     'time_in' => '08:00:00',
//                     'time_out' => '17:00:00'
//                 ]);
//             }
//
//         }

        $time_entries = EmployeeTimeEntries::orderBy('date', 'desc')->get();

        return view('admin.time_entries.index', compact('time_entries'));
    }

    public function create()
    {
        if (! Gate::allows('time_entries_create')) {
            return response()->view('errors.401', [], 401);
        }

        $department = \App\EmployeeDepartment::get()->pluck('name', 'id')->prepend('Please select', '');
        $position   = \App\EmployeePosition::get()->pluck('position', 'id')->prepend('Please select', '');
        $employee   = \App\Employee::selectRaw("CONCAT(fname,' ', lname) AS full_name, id")
                      ->where('working_status','Regular')
                      ->pluck('full_name','id')
                      ->prepend('Please select', '');

        return view('admin.time_entries.create', compact('department', 'position', 'employee'));
    }

    public function store(StoreEmployeeTimeEntriesRequest $request)
    {
        if (! Gate::allows('time_entries_create')) {
            return response()->view('errors.401', [], 401);
        }

        $time_entries = EmployeeTimeEntries::create($request->all());

        return redirect()->route('admin.time_entries.index');

    }

    public function edit($id)
    {
        if (! Gate::allows('time_entries_edit')) {
            return response()->view('errors.401', [], 401);
        }

        $time_entries = EmployeeTimeEntries::findOrFail($id);

        $department = \App\EmployeeDepartment::get()->pluck('name', 'id')->prepend('Please select', '');
        $position   = \App\EmployeePosition::get()->pluck('position', 'id')->prepend('Please select', '');
        $employee   = \App\Employee::select(DB::raw("CONCAT(fname,' ', lname) AS full_name, id"))
                        ->pluck('full_name','id')->prepend('Please select', '');

        return view('admin.time_entries.edit', compact('time_entries','department', 'position', 'employee'));
    }

    public function update(UpdateEmployeeTimeEntriesRequest $request, $id)
    {
        if (! Gate::allows('time_entries_edit')) {
            return response()->view('errors.401', [], 401);
        }

        $time_entries = EmployeeTimeEntries::findOrFail($id);
        $time_entries->update($request->all());

        return redirect()->route('admin.time_entries.index');
    }


    public function show($id)
    {
      if (! Gate::allows('time_entries_view')) {
        return response()->view('errors.401', [], 401);
      }

      $department   = \App\EmployeeDepartment::where('name', $id)->get();
      $position     = \App\EmployeePosition::where('position', $id)->get();
      $employee     = \App\Employee::where('employee_no', $id)->get();

      $time_entries = EmployeeTimeEntries::findOrFail($id);
      $time_entries->with('employee');
      
      return view('admin.time_entries.show', compact('time_entries', 'department', 'position', 'employee'));

    }

    public function destroy($id)
    {
        if (! Gate::allows('time_entries_delete')) {
            return response()->view('errors.401', [], 401);
        }

        $employee = EmployeeTimeEntries::findOrFail($id);
        $employee->delete();

        return redirect()->route('admin.time_entries.index');

    }

    public function massDestroy(Request $request)
    {
        if (! Gate::allows('time_entries_delete')) {
            return response()->view('errors.401', [], 401);
        }

        if($request->input('ids')) {
           $entries = EmployeeTimeEntries::whereIn('id', $request->input('ids'))->get();
        }

        foreach ($entries as $entry) {
            $entry->delete();
        }
    }

    // public function checkOverTime(EmployeeTimeEntries $time = null, $schedule)
    // {
    //     $schedules = App('App\Http\Controllers\EmployeeController')->schedule();
    //     $schedule = $schedules[$schedule];

    //     $sched_out = (int)date('H', strtotime(substr($schedule, strpos($schedule, '-') + 1)));
    //     $hr = (int)date('H', strtotime($time->time_out));
    //     $min = (int)date('i', strtotime($time->time_out));
    //     $rendered_time = 0;

    //     // if($hr >= 0 && $hr < $sched_out){
    //     //     $rendered_time = (24 % $sched_out) + $hr;
    //     // } else {
    //     //     $rendered_time = $hr % $sched_out;
    //     // }


    //     if($hr > $sched_out || ( ($hr >= $sched_out) && $min))
    //     {
    //         OvertimeRequest::updateOrCreate(
    //             [
    //                 'employee_id' => $time->employee_id,
    //                 'date' => $time->date
    //             ],
    //             [
    //                 'sched_out' => date('H:i:s', strtotime($sched_out.':00:00')),
    //                 'time_out' => date('H:i:s', strtotime($hr.':'.$min.':00')),
    //                 'status' => 1
    //             ]
    //         );
    //     }
    // }
}

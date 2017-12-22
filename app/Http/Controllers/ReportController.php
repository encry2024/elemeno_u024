<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\EmployeeTimeEntries;
use App\Salary;
use App\Report;

class ReportController extends Controller
{
    public function index(){
        if(! Gate::allows('report_access')){
            return response()->view('errors.401', [], 401);
        }

        $reports = Report::all();

        return view('admin.reports.index', compact('reports'));
    }

    public function contribution(){
        if(! Gate::allows('report_access')){
            return response()->view('errors.401', [], 401);
        }

        $salaries = Salary::whereBetween('date', [date('Y-m-01'), date('Y-m-31')])
                    ->whereHas('contributions')->get();

        return view('admin.reports.contribution', compact('salaries'));
    }
}

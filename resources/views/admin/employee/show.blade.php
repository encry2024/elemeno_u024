@extends('layouts.app')

@section('head')
<style type="text/css">
    tr td:first-child{
        width:30%;
        font-weight: bold;
    }
</style>
@stop

@section('content')
    <h3 class="page-title">@lang('quickadmin.employee.sub-title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">Employee Information</div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped col-md-6">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="width:200px">@lang('quickadmin.employee.fields.employee_no')</td>
                                <td colspan="3">{{ $employee->employee_no }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.fullname')</td>
                                <td colspan="3">{{ $employee->fullname() }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.address')</td>
                                <td colspan="3">{{ $employee->address }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.status')</td>
                                <td colspan="3">{{ $employee->status }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.dob')</td>
                                <td colspan="3">{{ $employee->dob }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.pob')</td>
                                <td colspan="3">{{ $employee->pob }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.no_of_dependents')</td>
                                <td colspan="3">{{ $employee->no_of_dependents > 0 ? : 0 }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.leave')</td>
                                <td>{{ $employee->leave_entitlement }}</td>
                                <td style="width:25%;font-weight: bold">Unused Leave</td>
                                <td>{{ $leave }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.email')</td>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.contact')</td>
                                <td>{{ $employee->contact_no }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.contact2')</td>
                                <td>{{ count($employee->contact_no2) ? $employee->contact_no2 : 'None' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.sss')</td>
                                <td>{{ count($employee->sss) ? $employee->sss : 'None' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.pagibig')</td>
                                <td>{{ count($employee->pag_ibig) ? $employee->pag_ibig : 'None' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.philhealth')</td>
                                <td>{{ count($employee->philhealth) ? $employee->philhealth : 'None' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.tin')</td>
                                <td>{{ count($employee->tin) ? $employee->tin : 'None' }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.employee.fields.schedule')</td>
                                <td>{{ $time[$employee->schedule] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('admin.employee.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Attendance Record</div>
        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($employee->time_entries) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>@lang('quickadmin.time-entries.fields.date')</th>
                        <th>@lang('quickadmin.time-entries.fields.time_in')</th>
                        <th>@lang('quickadmin.time-entries.fields.time_out')</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($employee->time_entries) > 0)
                        @foreach ($employee->time_entries->take(10) as $time_entry)
                            <tr data-entry-id="{{ $time_entry->id }}">
                                <td>{{ $time_entry->date }}</td>
                                <td>{{ $time_entry->time_in }}</td>
                                <td>{{ $time_entry->time_out }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>@lang('quickadmin.qa_no_entries_in_table')</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

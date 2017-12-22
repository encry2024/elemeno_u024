@extends('layouts.employee')

@section('head')
    <style type="text/css">
        tr{
            text-transform: uppercase;
        }
        tr td:first-child{
            width:35%;
            font-weight: bold;
        }
    </style>
@stop

@section('content')
    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">EMPLOYEE INFORMATION</div>

            <div class="panel-body">                
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
                                <td style="width:25%;font-weight:bold">Unused Leave</td>
                                <td>{{ $leave }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <td>E-mail Address</td>
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

                <a class="btn btn-warning" href="{{ route('employee.info.edit', [$employee->id]) }}"><i class="fa fa-edit"></i> Edit</a>
            </div>   
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">ATTENDANCE RECORD FOR MONTH OF {{ strtoupper(date('F')) }}</div>

            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>DATE</th>
                        <th>TIME IN</th>
                        <th>TIME OUT</th>
                    </thead>
                    <tbody>
                        @if(count($employee->time_entries))
                            @foreach($employee->time_entries as $entry)
                            <tr>
                                <td>{{ $entry->date }}</td>
                                <td>{{ $entry->time_in }}</td>
                                <td>{{ $entry->time_out }}</td>
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="8">No Attendance</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@stop

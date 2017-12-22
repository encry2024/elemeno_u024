@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.time-entries.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                      <tbody>
                        <tr>
                          <td>@lang('quickadmin.time-entries.fields.employee_no')</td>
                          <td>{{ $time_entries->employee->employee_no }}</td>
                        </tr>
                        
                        <tr>
                          <td>@lang('quickadmin.time-entries.fields.employee_id')</td>
                          <td>{{ $time_entries->employee->fullname() }}</td>
                        </tr>
                        
                        <tr>
                          <td>@lang('quickadmin.time-entries.fields.department_id')</td>
                          <td>{{ count($time_entries->employee->departments) ? $time_entries->employee->departments->first()->name : '' }}</td>
                        </tr>

                        <tr>
                          <td>@lang('quickadmin.time-entries.fields.position_id')</td>
                          <td>{{ count($time_entries->employee->position) ? $time_entries->employee->position->position : '' }}</td>
                        </tr>
                        
                        <tr>
                          <td>@lang('quickadmin.time-entries.fields.date')</td>
                          <td>{{ $time_entries->date }}</td>
                        </tr>
                        
                        <tr>
                          <td>@lang('quickadmin.time-entries.fields.time_in')</td>
                          <td>{{ $time_entries->time_in }}</td>
                        </tr>
                        
                        <tr>
                          <td>@lang('quickadmin.time-entries.fields.time_out')</td>
                          <td>{{ $time_entries->time_out }}</td>
                        </tr>
                      </tbody>
                      
                    </table>
                </div>
            </div><!-- Nav tabs -->
            <a href="{{ route('admin.time_entries.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

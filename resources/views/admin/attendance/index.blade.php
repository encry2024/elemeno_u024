@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.attendance.title')</h3>

    {!! Form::open(['method' => 'post', 'url' => url('admin/attendance/search') ]) !!}
        <div class="row">
            <div class="col-xs-4">
                {!! Form::label('department_id', 'Department', ['class' => 'control-label']) !!}
                {!! Form::select('department_id', $departments, old('department_id'), ['class' => 'form-control select2']) !!}
            </div>
            <div class="col-xs-2">
                {!! Form::label('position_id', 'Position', ['class' => 'control-label']) !!}
                {!! Form::select('position_id', $positions, old('position_id'), ['class' => 'form-control select2']) !!}
            </div>
            <div class="col-xs-2 col-md-2 form-group">
                {!! Form::label('date','Date',['class' => 'control-label']) !!}
                {!! Form::text('date', old('date', Request::get('date', date('Y-m-d'))), ['class' => 'form-control date', 'placeholder' => '']) !!}
            </div>
            <div class="col-xs-4">
                <label class="control-label">&nbsp;</label><br>
                {!! Form::submit('Search',['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    {!! Form::close() !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($employees) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>@lang('quickadmin.attendance.fields.employee_no')</th>
                        <th>@lang('quickadmin.attendance.fields.employee')</th>
                        <th>@lang('quickadmin.attendance.fields.department')</th>
                        <th>@lang('quickadmin.attendance.fields.position')</th>
                        <th>@lang('quickadmin.attendance.fields.date')</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if(count($employees) > 0)
                            @foreach($employees as $employee)
                                @if(count($employee->time_entries) > 0)
                                <tr>
                                    <td>{{ $employee->employee_no }}</td>
                                    <td>{{ $employee->fullname() }}</td>
                                    <td>{{ $employee->departments->first()->name }}</td>
                                    <td>{{ $employee->departments->first()->pivot->position }}</td>
                                    <td>{{ $employee->time_entries->last()->date }}</td>
                                </tr>
                                @endif
                            @endforeach 
                        @else
                        <tr>
                            <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                        @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.employee.sub-title')</h3>
    @can('employee_create')
    <p>
        <a href="{{ route('admin.employee.create') }}" class="btn btn-success">
            <i class="fa fa-user-plus"></i> @lang('quickadmin.qa_add_new')
        </a>
    </p>
    @endcan

    {!! Form::open(['method' => 'post', 'url' => url('admin/employee/search') ]) !!}
        <div class="row">
            <div class="col-xs-4">
                {!! Form::label('department_id', 'Department', ['class' => 'control-label']) !!}
                {!! Form::select('department_id', $departments, old('department_id'), ['class' => 'form-control select2']) !!}
            </div>
            <div class="col-xs-2">
                {!! Form::label('position_id', 'Position', ['class' => 'control-label']) !!}
                {!! Form::select('position_id', $positions, old('position_id'), ['class' => 'form-control select2']) !!}
            </div>
            <div class="col-xs-4">
                <label class="control-label">&nbsp;</label><br>
                <button class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
            </div>
        </div>
    {!! Form::close() !!}
    <br>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($employee) > 0 ? 'datatable' : '' }} @can('employee_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('employee_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.employee.fields.employee_no')</th>
                        <th>@lang('quickadmin.employee.fields.fullname')</th>
                        <th>@lang('quickadmin.employee.fields.schedule')</th>
                        <th>@lang('quickadmin.employee.fields.work_status')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($employee) > 0)
                        @foreach ($employee as $employee)
                            <tr data-entry-id="{{ $employee->id }}">
                                @can('employee_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $employee->employee_no }}</td>
                                <td>{{ $employee->fullname() }}</td>
                                <td>{{ $time[$employee->schedule] }}</td>
                                <td>{{ $employee->working_status }}</td>
                                <td>
                                    @can('employee_view')
                                    <a href="{{ route('admin.employee.show',[$employee->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('employee_edit')
                                    <a href="{{ route('admin.employee.edit',[$employee->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('employee_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.employee.destroy', $employee->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">@lang('quickadmin.qa_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('employee_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.employee.mass_destroy') }}';
        @endcan

    </script>
@endsection

@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.time-entries.title')</h3>
    @can('time_entries_create')
    <p>
        <a href="{{ route('admin.time_entries.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive ">
            <table class="table table-bordered table-hover table-striped {{ count($time_entries) > 0 ? 'datatable' : '' }} @can('time_entries_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('time_entries_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>@lang('quickadmin.employee.fields.employee_no')</th>
                        <th>@lang('quickadmin.employee.fields.fullname')</th>
                        <th>@lang('quickadmin.time-entries.fields.date')</th>
                        <th>@lang('quickadmin.time-entries.fields.time')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($time_entries) > 0)
                        @foreach ($time_entries as $time_entry)
                            <tr data-entry-id="{{ $time_entry->id }}">
                                @can('employee_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $time_entry->employee->employee_no }}</td>
                                <td>{{ $time_entry->employee->fullname() }}</td>
                                <td>{{ $time_entry->date }}</td>
                                <td>{{ $time_entry->time_in.' - '.$time_entry->time_out }}</td>
                                <td>
                                    @can('time_entries_view')
                                    <a href="{{ route('admin.time_entries.show',[$time_entry->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('time_entries_edit')
                                    <a href="{{ route('admin.time_entries.edit',[$time_entry->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('employee_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.time_entries.destroy', $time_entry->id])) !!}
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
        @can('time_entries_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.time_entries.mass_destroy') }}';
        @endcan

    </script>
@endsection

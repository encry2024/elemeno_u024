@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.position.title')</h3>
    @can('position_create')
    <p>
        <a href="{{ route('admin.position.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>

    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($position) > 0 ? 'datatable' : '' }} @can('position_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('position_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.position.fields.employee_id')</th>
                        <th>@lang('quickadmin.position.fields.department_id')</th>
                        <th>@lang('quickadmin.position.fields.position')</th>
                        <th>@lang('quickadmin.position.fields.rate')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($position) > 0)
                        @foreach ($position as $position)
                            <tr data-entry-id="{{ $position->id }}">
                                @can('position_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $position->employee->fullname() }}</td>
                                <td>{{ $position->department->name }}</td>
                                <td>{{ $position->position }}</td>
                                <td>{{ number_format($position->rate) }}</td>
                                <td>
                                    @can('position_view')
                                    <a href="{{ route('admin.position.show',[$position->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('position_edit')
                                    <a href="{{ route('admin.position.edit',[$position->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('time_entry_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.position.destroy', $position->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
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

@section('javascript')
    <script>
        @can('time_entry_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.position.mass_destroy') }}';
        @endcan

    </script>
@endsection

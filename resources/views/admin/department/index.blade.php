@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.department.sub-title')</h3>
    @can('department_create')
    <p>
        <a href="{{ route('admin.department.create') }}" class="btn btn-success">
            <i class="fa fa-plus-circle"></i> 
            @lang('quickadmin.qa_add_new')
        </a>

    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($department) > 0 ? 'datatable' : '' }} @can('department_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('department_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.department.fields.name')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($department) > 0)
                        @foreach ($department as $department)
                            <tr data-entry-id="{{ $department->id }}">
                                @can('department_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $department->name }}</td>
                                <td>
                                    @can('department_view')
                                    <a href="{{ route('admin.department.show',[$department->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('department_edit')
                                    <a href="{{ route('admin.department.edit',[$department->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('department_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.department.destroy', $department->id])) !!}
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
        @can('department_delete')
            window.route_mass_crud_entries_destroy = '{{ route('admin.department.mass_destroy') }}';
        @endcan

    </script>
@endsection

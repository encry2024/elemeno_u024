@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.department.sub-title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.department.fields.name')</th>
                            <td>{{ $department->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#timeentries" aria-controls="timeentries" role="tab" data-toggle="tab">Time entries</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="timeentries">
<table class="table table-bordered table-striped {{ count($position) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.position.fields.department_id')</th>
                        <th>@lang('quickadmin.position.fields.employee_id')</th>
                        <th>@lang('quickadmin.position.fields.position')</th>
                        <th>@lang('quickadmin.position.fields.rate')</th>
                        <th>&nbsp;</th>
        </tr>
    </thead>

    <tbody>
        @if (count($position) > 0)
            @foreach ($position as $position)
                <tr data-entry-id="{{ $position->id }}">
                    <td>{{ $position->department->name  }}</td>
                                <td>{{ $position->employee->fname  }} {{ $position->employee->fname  }} {{ $position->employee->fname  }}</td>
                                <td>{{ $position->position }}</td>
                                <td>{{ $position->rate }}</td>
                                <td>
                                  @can('time_entries_create')
                                  <a href="{{ route('admin.time_entries.show',[$department->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                  @endcan
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
                <td colspan="8">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.department.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

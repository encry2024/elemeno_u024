@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.holiday.title')</h3>
    @can('holiday_create')
    <p>
        <a href="{{ route('admin.holiday.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($holidays) > 0 ? 'datatable' : '' }} @can('holiday_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('holiday_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.holiday.fields.date')</th>
                        <th>@lang('quickadmin.holiday.fields.type')</th>
                        <th>@lang('quickadmin.holiday.fields.description')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($holidays) > 0)
                        @foreach ($holidays as $holiday)
                            <tr data-entry-id="{{ $holiday->id }}">
                                @can('holiday_delete')
                                    <td></td>
                                @endcan

                                <td>{{ $holiday->date }}</td>
                                <td>{{ $holiday->type }}</td>
                                <td>{{ $holiday->description }}</td>
                                <td>
                                    @can('holiday_view')
                                    <a href="{{ route('admin.holiday.show',[$holiday->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('holiday_edit')
                                    <a href="{{ route('admin.holiday.edit',[$holiday->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('holiday_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.holiday.destroy', $holiday->id])) !!}
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

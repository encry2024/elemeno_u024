@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.bonus.title')</h3>
    @can('bonus_create')
    <p>
        <a href="{{ route('admin.bonus.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($bonuses) > 0 ? 'datatable' : '' }} @can('bonus_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('bonus_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.bonus.fields.employee')</th>
                        <th>@lang('quickadmin.bonus.fields.type')</th>
                        <th>@lang('quickadmin.bonus.fields.amount')</th>
                        <th>@lang('quickadmin.bonus.fields.date')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($bonuses) > 0)
                        @foreach ($bonuses as $bonus)
                            <tr data-entry-id="{{ $bonus->id }}">
                                @can('bonus_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $bonus->employee->fullname() }}</td>
                                <td>{{ $bonus->type }}</td>
                                <td>{{ $bonus->amount }}</td>
                                <td>{{ $bonus->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @can('bonus_view')
                                    <a href="{{ route('admin.bonus.show',[$bonus->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('bonus_edit')
                                    <a href="{{ route('admin.bonus.edit',[$bonus->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('bonus_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.bonus.destroy', $bonus->id])) !!}
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

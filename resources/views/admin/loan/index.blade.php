@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.loan.title')</h3>
    @can('loan_create')
    <p>
        <a href="{{ route('admin.loan.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($loans) > 0 ? 'datatable' : '' }} @can('loan_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('loan_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.loan.fields.employee')</th>
                        <th>@lang('quickadmin.loan.fields.date')</th>
                        <th>@lang('quickadmin.loan.fields.amount')</th>
                        <th>@lang('quickadmin.loan.fields.status')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($loans) > 0)
                        @foreach ($loans as $loan)
                            <tr data-entry-id="{{ $loan->id }}">
                                @can('loan_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $loan->employee->fullname() }}</td>
                                <td>{{ $loan->amount }}</td>
                                <td>{{ $loan->date }}</td>
                                <td>{{ $loan->status }}</td>
                                <td>
                                    @can('loan_view')
                                    <a href="{{ route('admin.loan.show',[$loan->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('loan_edit')
                                    <a href="{{ route('admin.loan.edit',[$loan->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('loan_delete')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.loan.destroy', $loan->id])) !!}
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

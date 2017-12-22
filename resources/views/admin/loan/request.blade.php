@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.loan.title')</h3>

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
                                @if($loan->request_status == 'Pending')
                                @can('loan_edit')
                                {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'GET',
                                    'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                    'route' => ['admin.loan.approve', $loan->id])) !!}
                                {!! Form::submit(trans('quickadmin.qa_approve'), array('class' => 'btn btn-xs btn-success')) !!}
                                {!! Form::close() !!}
                                @endcan
                                @can('loan_edit')
                                {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'GET',
                                    'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                    'route' => ['admin.loan.deny', $loan->id])) !!}
                                {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                {!! Form::close() !!}
                                @endcan
                                @else
                                    <span class="label label-{{ $loan->request_status == 'Approved' ? 'danger' : 'success'}}">
                                        {{ $loan->request_status  }}
                                    </span>
                                @endif
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

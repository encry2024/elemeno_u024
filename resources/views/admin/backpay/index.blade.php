@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.backpay.title')</h3>
    @can('backpay_create')
    <p>
        <a href="{{ route('admin.backpay.create') }}" class="btn btn-success">@lang('quickadmin.qa_add_new')</a>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($backpays) > 0 ? 'datatable' : '' }} @can('backpay_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('backpay_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan
                        <th>@lang('quickadmin.backpay.fields.id')</th>
                        <th>@lang('quickadmin.backpay.fields.employee')</th>
                        <th>@lang('quickadmin.backpay.fields.date')</th>
                        <th>@lang('quickadmin.backpay.fields.amount')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($backpays) > 0)
                        @foreach ($backpays as $backpay)
                            @if(count($backpay->employee))
                            <tr data-entry-id="{{ $backpay->id }}">
                                @can('backpay_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $backpay->employee->employee_no }}</td>
                                <td>{{ $backpay->employee->fullname() }}</td>
                                <td>{{ $backpay->date }}</td>
                                <td>{{ $backpay->amount }}</td>
                                <td>
                                @if($backpay->status == 'Pending')
                                    @can('backpay_edit')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'get',
                                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                            'route' => ['admin.backpay.approve', $backpay->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_approve'), array('class' => 'btn btn-xs btn-success')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                    @can('backpay_edit')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'get',
                                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                            'route' => ['admin.backpay.deny', $backpay->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_deny'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                @else
                                    Paid
                                @endif
                                </td>
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

@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.cash_advance.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.cash_advance.fields.employee')</th>
                            <td>{{ $cash_advance->employee->fullname() }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.cash_advance.fields.date')</th>
                            <td>{{ $cash_advance->created_at->format('Y-m-d') }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.cash_advance.fields.amount')</th>
                            <td>{{ $cash_advance->amount }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.cash_advance.fields.status')</th>
                            <td>{{ $cash_advance->status }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.cash_advance.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

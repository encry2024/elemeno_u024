@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.bonus.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.bonus.fields.employee')</th>
                            <td>{{ $bonus->employee->fullname() }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.bonus.fields.date')</th>
                            <td>{{ $bonus->date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.bonus.fields.amount')</th>
                            <td>{{ $bonus->amount }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.bonus.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

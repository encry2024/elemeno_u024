@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.position.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.position.fields.department_id')</th>
                            <td>{{ $position->department->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.position.fields.position')</th>
                            <td>{{ $position->position }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.employee.fields.employee_no')</th>
                            <td>{{ $position->employee->employee_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.position.fields.employee_id')</th>
                            <td>{{ $position->employee->fname  }} {{ $position->employee->mname  }} {{ $position->employee->lname  }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.position.fields.rate')</th>
                            <td>{{ number_format($position->rate) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <thead>
                        <th>Type</th>
                        <th>Amount</th>
                        </thead>
                        <tbody>
                        @if(count($employee->allowances))
                            @foreach($employee->allowances as $allowance)
                                <tr>
                                    <td>{{ $allowance->type }}</td>
                                    <td>{{ $allowance->amount }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>



            <p>&nbsp;</p>

            <a href="{{ route('admin.position.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop

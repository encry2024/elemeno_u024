@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.report.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($salaries) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Date Range</th>
                        <th>Basic Pay</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($salaries) > 0)
                        @foreach ($salaries as $salary)
                            <tr data-entry-id="{{ $salary->id }}">
                                <td>{{ $salary->date }}</td>
                                <td>{{ $salary->date_range }}</td>
                                <td>{{ $salary->basic }}</td>
                                <td>{{ $salary->deductions }}</td>
                                <td>{{ $salary->net_pay }}</td>
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

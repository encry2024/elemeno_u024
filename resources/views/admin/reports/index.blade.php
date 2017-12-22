@extends('layouts.app')

@section('content')
    <h3 class="page-title">SALARY REPORT</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($reports) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>GROSS</th>
                        <th>DEDUCTION</th>
                        <th>NETPAY</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($reports) > 0)
                        @foreach ($reports as $report)
                            <tr data-entry-id="{{ $report->id }}">
                            	<td>{{ $report->date }}</td>
                                <td>{{ number_format($report->gross, 2) }}</td>
                                <td>{{ number_format($report->deduction, 2) }}</td>
                                <td>{{ number_format($report->netpay, 2) }}</td>
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

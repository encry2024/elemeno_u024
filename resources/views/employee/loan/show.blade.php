@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.loan.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.loan.fields.employee')</th>
                            <td>{{ $loan->employee->employee_no }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.loan.fields.employee')</th>
                            <td>{{ $loan->employee->fullname() }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.loan.fields.date')</th>
                            <td>{{ $loan->date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.loan.fields.amount')</th>
                            <td>{{ number_format($loan->amount) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('quickadmin.loan.fields.status')</th>
                            <td>{{ $loan->status }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.loan.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Salary Deducted</div>

        <div class="panel-body">
            <table class="table table-responsive">
                <thead>
                    <th>Date</th>
                    <th>Amount Paid</th>
                </thead>
                <tbody>
                    <?php $amount_paid = 0; ?>
                    @if(count($loan->payments) > 0)
                        @foreach($loan->payments as $payment)
                        <tr>
                            <?php $amount_paid += $payment->loan ?>
                            <td>{{ $payment->date }}</td>
                            <td>{{ $payment->loan }}</td>
                        </tr>
                        @endforeach
                    @else
                    <tr>
                        <td>No Payment Record.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <h4>Balance: <span>{{ number_format($loan->amount - $amount_paid) }}</span></h4>
            <h4>Total Amount Paid: <span>{{ number_format($amount_paid) }}</span></h4>
        </div>
    </div>
@stop

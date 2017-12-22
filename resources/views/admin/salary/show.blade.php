@extends('layouts.app')

@section('head')
<style type="text/css">
    tr td:first-child{
        font-weight: bold;
        width: 15%;
    }
    tbody#table-view tr td:first-child{
        font-weight: bold;
        width: 30%;
    }
</style>
@stop

@section('content')
    <h3 class="page-title">@lang('quickadmin.salary-record-management.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">EMPLOYEE DETAILS</div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                      <tr>
                          <td>@lang('quickadmin.employee.fields.employee_no')</td>
                          <td>{{ $salary->employee->employee_no }} </td>
                      </tr>
                        <tr>
                            <td>@lang('quickadmin.employee.fields.fullname')</td>
                            <td>{{ $salary->employee->fullname() }}</td>
                        </tr>
                        <tr>
                            <td>@lang('quickadmin.employee.fields.address')</td>
                            <td>{{ $salary->employee->address }} </td>
                        </tr>
                        <tr>
                            <td>@lang('quickadmin.employee.fields.status')</td>
                            <td>{{ $salary->employee->status }} </td>
                        </tr>
                        <tr>
                            <td>@lang('quickadmin.employee.fields.dob')</td>
                            <td>{{ $salary->employee->dob }} </td>
                        </tr>
                        <tr>
                            <td>@lang('quickadmin.employee.fields.pob')</td>
                            <td>{{ $salary->employee->pob }} </td>
                        </tr>
                        <tr>
                            <td>@lang('quickadmin.employee.fields.no_of_dependents')</td>
                            <td>{{ $salary->employee->no_of_dependents }} </td>
                        </tr>
                    </table>
                </div>
            </div>           

            <a href="{{ route('admin.salary.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
            <a href="{{ route('admin.salary.print', [$salary->id]) }}" class="btn btn-success"><i class="fa fa-print"></i> Print</a>
        </div>

        
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">SALARY DETAILS</div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-hover table-bordered">
                        <tdead>
                            <td>@lang('quickadmin.salary-computation.detail')</td>
                            <td>@lang('quickadmin.salary-computation.fields.date') : {{ date('F d, Y', strtotime($salary->date)) }}</td>
                        </tdead>
                        <tbody id="table-view">
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.range')</td>
                                <td>{{ $salary->date_range }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.days')</td>
                                <td>{{ $salary->days }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.basic')</td>
                                <td>{{ number_format($salary->basic, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Holiday</td>
                                <td>{{ number_format($salary->holiday, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.cola')</td>
                                <td>{{ number_format($salary->cola, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.ot')</td>
                                <td>{{ number_format($salary->overtime_pay, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.otn')</td>
                                <td>{{ number_format($salary->overtime_pay_night, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.bonus')</td>
                                <td>{{ number_format($salary->bonus, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.allowance')</td>
                                <td>{{ number_format($salary->allowance, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.gross')</td>
                                <td>{{ number_format($salary->gross, 2) }}</td>
                            </tr>
                        </tbody>             
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-hover table-bordered">
                        <tdead>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tdead>
                        <tbody id="table-view">
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.tax')</td>
                                <td>{{ number_format($salary->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.sss')</td>
                                <td>
                                    @if(count($salary->contributions))
                                    {{ number_format($salary->contributions->first()->sss_employee, 2) }}
                                    @else
                                    0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.pagibig')</td>
                                <td>
                                    @if(count($salary->contributions))
                                    {{ number_format($salary->contributions->first()->hdmf, 2) }}
                                    @else
                                    0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.philhealth')</td>
                                <td>
                                    @if(count($salary->contributions))
                                    {{ number_format($salary->contributions->first()->philc_employee, 2) }}
                                    @else
                                    0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.cash_advance')</td>
                                <td>{{ number_format($salary->cash_advance, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.loan')</td>
                                <td>{{ number_format($salary->loan, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.late')</td>
                                <td>{{ number_format($salary->late, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.deduction')</td>
                                <td>{{ number_format($salary->total_deductions, 2) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('quickadmin.salary-computation.fields.net')</td>
                                <td>{{ number_format($salary->net_pay, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>    

            </div>
        </div>
    </div>
@stop

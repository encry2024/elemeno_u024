@extends('layouts.app')

@section('head')
<link rel="stylesheet" type="text/css" 
      href="{{ asset('/css/payslip.css') }}">


@stop

@section('content')
    <h3 class="page-title noPrint">Payslip</h3>

    <div class="panel panel-default noBorder">
        <div class="panel-heading noPrint">Preview</div>

        <div class="panel-body">
            <div class="row">
                <div class="payslip">
                    <div class="payslip-header">
                        <p class="pay_em_name">{{ $salary->employee->fullname() }}</p>
                        <p class="pay_em_no">{{ $salary->employee->employee_no }}</p>
                        <p class="pay_period">

                        <?php 
                            $index  = strpos($salary->date_range, 'to');
                            $from   = substr($salary->date_range, 0, $index);
                            $from   = new Carbon\Carbon(str_replace('-', '/', $from));
                            $from   = date('d-', strtotime($from));

                            $to     = substr($salary->date_range, $index + 2);
                            $to     = new Carbon\Carbon(str_replace('-', '/', $to));
                            $to     = date('F-d', strtotime($to));

                            echo $from.$to;
                        ?>
                        </p>  
                    </div>
                    <div class="payslip-content">
                        <p class="pay_basic">{{ number_format($salary->basic, 2) }}</p>
                        <p class="pay_basic_late">{{ $salary->late > 0 ? number_format($salary->late, 2): '-    &nbsp;' }}</p>
                        <p class="pay_basic_allowance">{{ $salary->allowance > 0 ? number_format($salary->allowance, 2): '-    &nbsp;' }}</p>
                        <p class="pay_basic_net">
                            <?php
                                $basic      = $salary->basic;
                                $late       = $salary->late;
                                $allowance  = $salary->allowance;
                                $gross_pay  = ($basic + $allowance) - $late;

                                echo number_format($gross_pay, 2);
                            ?>
                        </p>
                        <p class="pay_ecola">{{ number_format($salary->cola, 2) }}</p>
                        <p class="pay_ecola_absent">-    &nbsp;</p>
                        <p class="pay_ecola_net">{{ number_format($salary->cola, 2) }}</p>
                        <p class="pay_basic_gross">{{ number_format($gross_pay + $salary->cola, 2) }}</p>

                        <!-- deductions -->
                        <p class="pay_deduct_tax">{{ $salary->tax > 0 ? number_format($salary->tax, 2): '-    &nbsp;' }}</p>
                        <p class="pay_deduct_sss">
                            @if(count($salary->contributions))
                            {{ 
                                $salary->contributions->first()->sss_employee > 0 ? 
                                number_format($salary->contributions->first()->sss_employee, 2) : '-    &nbsp;'
                            }}
                            @else
                            -    &nbsp;
                            @endif
                        </p>
                        <p class="pay_deduct_philc">
                            @if(count($salary->contributions))
                            {{ 
                                $salary->contributions->first()->philc_employee > 0 ? 
                                number_format($salary->contributions->first()->philc_employee, 2) : '-    &nbsp;'
                            }}
                            @else
                            -    &nbsp;
                            @endif
                        </p>
                        <p class="pay_deduct_hdmf">
                            @if(count($salary->contributions))
                            {{ 
                                $salary->contributions->first()->hdmf > 0 ? 
                                number_format($salary->contributions->first()->hdmf, 2) : '-    &nbsp;' 
                            }}
                            @else
                            -    &nbsp;
                            @endif
                        </p>
                        <p class="pay_deduct_loan">{{ $salary->loan > 0 ? number_format($salary->loan, 2): '-    &nbsp;' }}</p>
                        <p class="pay_deduct_advance">
                            {{ $salary->cash_advance > 0 ? number_format($salary->cash_advance, 2): '-    &nbsp;' }}
                        </p>
                        <p class="pay_deduct_total">{{ number_format($salary->total_deductions, 2) }}</p>

                        <!--  -->
                        <p class="pay_gross_pay">{{ number_format($salary->gross, 2) }}</p>
                        <p class="pay_total_deduction">{{ number_format($salary->total_deductions, 2) }}</p>
                        <p class="pay_net_pay">{{ number_format($salary->gross - $salary->total_deductions, 2) }}</p>
                        <p class="pay_overtime">
                            {{ 
                                ($salary->overtime_pay + $salary->overtime_pay_night) > 0 ? 
                                number_format($salary->overtime_pay + $salary->overtime_pay_night, 2): '-' 
                            }}
                        </p>
                        <p class="pay_total_pay">{{ number_format($salary->net_pay, 2) }}</p>
                    </div>
                    <img src="{{ asset('quickadmin/images/payslip.png') }}">
                </div>
                
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.salary.index') }}" class="btn btn-default noPrint">@lang('quickadmin.qa_back_to_list')</a>
            <button class="btn btn-success noPrint" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
@stop

@section('javascript')
<script type="text/javascript">
    $('*').on('dragStart', function(){
        return false;
    });
</script>
@stop
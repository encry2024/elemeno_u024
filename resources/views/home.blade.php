@extends('layouts.app')

@section('head')
<link rel="css/stylesheet" href="{{ asset('/css/highcharts.css') }}">
<style type="text/css">
    #line-chart{
        width: 100%;
        height: 240px;
    }
    #donut-chart{
        width: 100%;
        height: 240px;
    }
    .c_purple_bd{
        border-color: #a1adea;
    }
    .c_purple_bg{
        color: #434f90;
        background-color: #a1b0ff;
        border-color: #96a6fb;
    }
</style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">&nbsp;</div>

                <div class="panel-body">
                    <div id="line-chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">&nbsp;</div>

                <div class="panel-body">
                    <div id="donut-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading"><i class="fa fa-calculator"></i> <b>PAYOUT FOR {{ strtoupper(date('F')) }}</b></div>
                <div class="panel-body">
                    <h4>Total Amount</h4>
                    <h4>
                        <b>
                        @if(count($salary) || count($month13) || count($bonus))
                            <?php 
                                $net_pay        = count($salary) ? $salary->total : 0;
                                $month13_total  = count($month13) ? $month13->total : 0;
                                $bonus_total    = count($bonus) ? $bonus->total: 0;
                                $leave_cash     = count($leave_cash) ? $leave_cash : 0;

                                echo number_format($net_pay + $month13_total + $bonus_total + $leave_cash, 2);
                            ?>
                        @else
                        0.00
                        @endif
                        </b>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-danger">
                <div class="panel-heading"><b><i class="fa fa-money"></i> WITHHOLDING TAX</b></div>

                <div class="panel-body">
                    <h4>Total Amount </h4>
                    <h4>
                        <b>{{ count($tax) ? $tax->total + (count($month13) ? number_format($month13->tax, 2) : 0.00) : 0.00 }}</b>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel c_purple_bd">
                <div class="panel-heading c_purple_bg"><i class="fa fa-clock-o"></i> <b>OVERTIME REQUEST</b></div>
                <div class="panel-body">
                    <h4>For Approval </h4>
                    <h4>
                        <b>{{ $overtime ? : 0 }}</b>
                        <a class="btn btn-xs btn-primary pull-right" style="margin-right:20px" href="{{ route('admin.overtime.index') }}">
                            <i class="fa fa-clock-o"></i> View</a>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-money"></i> <b>EMPLOYEE'S CONTRIBUTION</b></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>Contribution</th>
                            <th>Amount</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SSS</td>
                                <td><b>{{ count($sss) ? number_format($sss->employee, 2) : 0.00 }}</b></td>
                            </tr>
                            <tr>
                                <td>PHILC</td>
                                <td><b>{{ count($philc) ? number_format($philc->employee, 2) : 0.00 }}</b></td>
                            </tr>
                            <tr>
                                <td>HDMF</td>
                                <td><b>{{ count($hdmf) ? number_format($hdmf->amount, 2) : 0.00 }}</b></td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading"><i class="fa fa-money"></i> <b>EMPLOYER CONTRIBUTION</b></div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <th>Contribution</th>
                            <th>Amount</th>
                            <th>&nbsp;</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SSS</td>
                                <td><b>{{ count($sss) ? number_format($sss->employer, 2) : 0.00 }}</b></td>
                            </tr>
                            <tr>
                                <td>PHILC</td>
                                <td><b>{{ count($philc) ? number_format($philc->employer, 2) : 0.00 }}</b></td>
                            </tr>
                            <tr>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.reports.contribution') }}">
                                        <i class="fa fa-th-list"></i> VIEW
                                    </a>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading"><b><i class="fa fa-calendar"></i> LEAVE REQUEST</b></div>

                <div class="panel-body">
                    <h4>For Approval </h4>
                    <h4>
                        <b>{{ $leave ? : 0.00 }}</b>
                        <a class="btn btn-xs btn-primary pull-right" style="margin-right:20px" href="{{ route('admin.leave.index') }}">
                            <i class="fa fa-calendar"></i> View</a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading"><b><i class="fa fa-calendar"></i> LOAN REQUEST</b></div>

                <div class="panel-body">
                    <h4>For Approval </h4>
                    <h4>
                        <b>0</b>
                        <a class="btn btn-xs btn-primary pull-right" style="margin-right:20px" href="{{  route('admin.loan.request') }}">
                            <i class="fa fa-money"></i> View</a>
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('/js/highcharts.js') }}"></script>
    <script type="text/javascript">
        Highcharts.chart('line-chart', {
           chart: {
                type: 'line'
            },
            title: {
                text: 'NET PAY LIST FOR ' + {{ date('Y') }}
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Amount'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            colors: ['red'],
            series: [{
                name: 'Amount',
                data: [
                    @foreach($net_pays as $net_pay)
                        {{ $net_pay >0 ? $net_pay: 0 }},
                    @endforeach
                ]
            }]

        });


        Highcharts.chart('donut-chart', {
            chart: {
                type: 'pie',
            },
            title: {
                text: 'Employees Attendance'
            },
            plotOptions: {
                pie: {
                    innerSize: 45
                }
            },
            series: [{
                name: 'Employee',
                data: [
                    ['Present', {{ $presents }}],
                    ['Absent', {{ $absents }}],
                ]
            }]
        });


        $('.highcharts-credits').hide();

    </script>
@stop

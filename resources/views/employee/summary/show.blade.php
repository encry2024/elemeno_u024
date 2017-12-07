@extends('layouts.employee')

@section('head')
    <style type="text/css">
        tr{
            text-transform: uppercase;
        }
        tr td:first-child{
            width: 30%;
            font-weight: bold;
        }
        tbody#info tr td:first-child{
        	width: 15%;
        }
    </style>
@stop

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">EMPLOYEE DETAILS</div>

		<div class="panel-body">
			<table class="table table-responsive table-striped table-bordered">
				<tbody id="info">
					<tr>
						<td>Employee No.</td>
						<td>: {{ $salary->employee->employee_no }}</td>
					</tr>
					<tr>
						<td>Name:</td>
						<td>: {{ $salary->employee->fullname() }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!--  -->

	<div class="panel panel-default">
		<div class="panel-heading">SALARY DETAILS</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">EARNINGS</div>

						<div class="panel-body">
							<table class="table table-responsive table-striped table-bordered">
								<tbody>
									<tr>
										<td>Date</td>
										<td>: {{ $salary->date }}</td>
									</tr>
									<tr>
										<td>Date Range</td>
										<td>: {{ $salary->date_range }}</td>
									</tr>
									<tr>
										<td>Days Worked</td>
										<td>: {{ $salary->days }}</td>
									</tr>
									<tr>
										<td>BASIC PAY</td>
										<td>: {{ number_format($salary->basic, 2) }}</td>
									</tr>
									<tr>
										<td>HOLIDAY PAY</td>
										<td>: {{ number_format($salary->holiday, 2) }}</td>
									</tr>
									<tr>
										<td>COLA</td>
										<td>: {{ number_format($salary->cola, 2) }}</td>
									</tr>
									<tr>
										<td>OVERTIME PAY</td>
										<td>: {{ number_format($salary->overtime_pay, 2) }}</td>
									</tr>
									<tr>
										<td>OVERTIME PAY NIGHT DIFF.</td>
										<td>: {{ number_format($salary->overtime_pay_night, 2) }}</td>
									</tr>
									<tr>
										<td>LATE</td>
										<td>: {{ number_format($salary->late, 2) }}</td>
									</tr>
									<tr>
										<td>BONUS</td>
										<td>: {{ number_format($salary->bonus, 2) }}</td>
									</tr>
									<tr>
										<td>ALLOWANCE:</td>
										<td>: {{ number_format($salary->bonus, 2) }}</td>
									</tr>
									<tr>
										<td>GROSS PAY</td>
										<td>: {{ number_format($salary->gross, 2) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">DEDUCTIONS</div>

						<div class="panel-body">
							<table class="table table-responsive table-striped table-bordered">
								<tbody>
									<tr>
										<td>W. Tax</td>
										<td>: {{ number_format($salary->tax, 2) }}</td>
									</tr>
									<tr>
										<td>SSS</td>
										@if(count($salary->contributions))
										<td>: {{ number_format($salary->contributions->first()->sss_employee, 2) }}</td>
										@else
											<td>: 0.00</td>
										@endif
									</tr>
									<tr>
										<td>Philhealth</td>
										@if(count($salary->contributions))
										<td>: {{ number_format($salary->contributions->first()->philc_employee, 2) }}</td>
										@else
											<td>: 0.00</td>
										@endif
									</tr>
									<tr>
										<td>HDMF</td>
										@if(count($salary->contributions))
										<td>: {{ number_format($salary->contributions->first()->hdmf, 2) }}</td>
										@else
											<td>: 0.00</td>
										@endif
									</tr>
									<tr>
										<td>CASH ADVANCE</td>
										<td>: {{ number_format($salary->cash_advance, 2) }}</td>
									</tr>
									<tr>
										<td>COMPANY LOAN</td>
										<td>: {{ number_format($salary->loan, 2) }}</td>
									</tr>
									<tr>
										<td>TOTAL DEDUCTIONS</td>
										<td>: {{ number_format($salary->total_deductions, 2) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!--  -->

			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-primary">
						<div class="panel-heading">TOTAL</div>

						<div class="panel-body">
							<table class="table table-responsive table-striped table-bordered">
								<tbody>
									<tr>
										<td>GROSS PAY</td>
										<td>: {{ number_format($salary->gross, 2) }}</td>
									</tr>
									<tr>
										<td>DEDUCTIONS</td>
										<td>: {{ number_format($salary->total_deductions, 2) }}</td>
									</tr>
									<tr>
										<td>NET PAY</td>
										<td>: {{ number_format($salary->net_pay, 2) }}</td>
									</tr>
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
			</div>

			<a class="btn btn-primary" href="{{ route('employee.summary.index') }}">
				<i class="fa fa-arrow-left"></i> BACK TO LIST
			</a>
		</div>
	</div>
@stop
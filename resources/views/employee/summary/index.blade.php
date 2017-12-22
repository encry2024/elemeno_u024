@extends('layouts.employee')

@section('content')
	
	<div class="panel panel-default">
		<div class="panel-heading">PAYOUT SUMMARY</div>

		<div class="panel-body">
			<table class="table table-responsive table-bordered table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Gross Pay</th>
						<th>Deductions</th>
						<th>Net Pay</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					@if(count($employee))
						@if(count($employee->salaries))
							@foreach($employee->salaries as $salary)
								<tr>
									<td>{{ $salary->date }}</td>
									<td>{{ $salary->gross }}</td>
									<td>{{ $salary->total_deductions }}</td>
									<td>{{ $salary->net_pay }}</td>
									<td>
										<a class="btn btn-xs btn-primary" href="{{ route('employee.summary.show', [$salary->id]) }}">
										<i class="fa fa-info-circle"></i> Details</a>
									</td>
								</tr>
							@endforeach
							@else
							<tr>
								<td colspan="5">@lang('quickadmin.qa_no_entries_in_table')</td>
							</tr>
						@endif
					@endif
				</tbody>
			</table>
		</div>
	</div>

@stop
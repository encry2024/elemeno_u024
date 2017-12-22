@extends('layouts.app')

@section('head')
<style type="text/css">
	tr td:first-child{
		width: 25%;
	}
	td{
		text-transform: uppercase;
	}
</style>
@stop

@section('content')

	<div class="panel panel-default">
		<div class="panel-heading">Employer Contributions</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					@if(count($salaries))
					<h4>Date: {{ date('F d, Y', strtotime($salaries->first()->date)) }}</h4>
					@endif

					<table class="table table-responsive table-striped table-bordered {{ count($salaries) ? 'datatable': ''}}">
						<thead>
							<th>Employee No.</th>
							<th>Employee Name</th>
							<th>SSS</th>
							<th>Philc</th>
							<th>Total</th>
						</thead>
						<tbody>
							@if(count($salaries))
							@foreach($salaries as $salary)
								<tr data-entry-id="{{ $salary->id }}">
									<td>{{ $salary->employee->employee_no }}</td>
									<td>{{ $salary->employee->fullname() }}</td>
									<td>
										@if(count($salary->contributions))
										{{ number_format($salary->contributions->first()->sss_employer, 2) }}
										@else
										0.00
										@endif
									</td>
									<td>
										@if(count($salary->contributions))
										{{ number_format($salary->contributions->first()->philc_employer, 2) }}
										@else
										0.00
										@endif
									</td>
									<td>
										@if(count($salary->contributions))
										{{ 
											number_format(
												$salary->contributions->first()->sss_employer + 
												$salary->contributions->first()->philc_employer, 
											2) 
										}}
										@else
										0.00
										@endif
									</td>
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
		</div>
	</div>

@stop
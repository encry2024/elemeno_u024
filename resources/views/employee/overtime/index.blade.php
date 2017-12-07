@extends('layouts.employee')

@section('content')
	<p>
		<a class="btn btn-success" href="{{ route('employee.overtime.create') }}"><i class="fa fa-plus-circle"></i> Create Request</a>
	</p>
	

	<div class="panel panel-default">
		<div class="panel-heading">Overtime Request List</div>

		<div class="panel-body">

			<table class="table table-responsive">
				<thead>
					<th>#</th>
					<th>Date</th>
					<th>Time Rendered</th>
					<th>Status</th>
				</thead>
				<tbody>
					@if(count($overtimes))
						@foreach($overtimes as $overtime)
						<tr>
							<td>&nbsp;</td>
							<td>{{ $overtime->date }}</td>
							<td>{{ $overtime->time_rendered }}</td>
							<td>
								<span class="label label-{{ $overtime->status == 'Pending' ? 
											'default' : ($overtime->status == 'Approved' ? 'success' : 'danger') }}">
										{{ $overtime->status }}
								</span>
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

@stop
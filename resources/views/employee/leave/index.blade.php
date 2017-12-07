@extends('layouts.employee')

@section('content')
	@if(session('msg'))
	<div class="alert alert-danger">
		{{ session('msg') }}
	</div>
	@endif

	<p>
		<a class="btn btn-success" href="{{ route('employee.leave.create') }}"><i class="fa fa-plus-circle"></i> Create Request</a>
	</p>


	<div class="panel panel-default">
		<div class="panel-heading">Leave Request List</div>

		<div class="panel-body">

			<table class="table table-responsive">
				<thead>
					<th>#</th>
					<th>Start Date</th>
					<th>Days Leave</th>
					<th>Reason</th>
					<th>Status</th>
					<th>&nbsp;</th>
				</thead>
				<tbody>
					@if(count($leaves))
						@foreach($leaves as $leave)
						<tr>
							<td>&nbsp;</td>
							<td>{{ $leave->date }}</td>
							<td>{{ $leave->days }}</td>
							<td>{{ $leave->reason }}</td>
							<td>
								<span class="label label-{{ 
										$leave->status == 'Pending' ? 
										'default' : ( $leave->status =='Approved' ? 'success' : 'danger')
										}}">
									{{ $leave->status }}
                                </span>
                            </td>
							<td></td>
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
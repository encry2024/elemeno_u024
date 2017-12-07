@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            Leave Request List
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($leaves) > 0 ? 'datatable' : '' }}">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Days</th>
                        <th>Reason</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr data-entry-id="{{ $leave->id }}">
                            <td>{{ $leave->employee->fullname() }}</td>
                            <td>{{ $leave->date }}</td>
                            <td>{{ $leave->days }}</td>
                            <td>{{ $leave->reason }}</td>
                            <td>
                                @if($leave->status == 'Pending')
                                    @can('leave_edit')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'GET',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.leave.approve', $leave->id])) !!}
                                    {!! Form::submit('Approve', array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                    @can('leave_edit')
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'GET',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['admin.leave.deny', $leave->id])) !!}
                                    {!! Form::submit('Deny', array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                @else
                                    <span class="label label-{{ $leave->status == 'Approved' ? 'success' : 'danger'}}">
                                            {{ $leave->status }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

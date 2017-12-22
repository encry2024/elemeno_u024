@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.overtime.title')</h3>
    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($overtimes) > 0 ? 'datatable' : '' }} @can('overtime_delete') dt-select @endcan">
                <thead>
                    <tr>
                        @can('overtime_delete')
                            <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        @endcan

                        <th>@lang('quickadmin.overtime.fields.id')</th>
                        <th>@lang('quickadmin.overtime.fields.employee')</th>
                        <th>@lang('quickadmin.overtime.fields.date')</th>
                        <th>@lang('quickadmin.overtime.fields.time')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($overtimes) > 0)
                        @foreach ($overtimes as $overtime)
                            <tr data-entry-id="{{ $overtime->id }}">
                                @can('overtime_delete')
                                    <td></td>
                                @endcan
                                <td>{{ $overtime->employee->employee_no }}</td>
                                <td>{{ $overtime->employee->fullname() }}</td>
                                <td>{{ $overtime->date }}</td>
                                <td>
                                    <?php
                                        $schedule   = $overtime->employee->schedule;
                                        $schedules  = App('App\Http\Controllers\EmployeeController')->schedule();
                                        $schedule   = $schedules[$schedule];

                                        $index      = strpos($schedule, '-');
                                        $substr     = substr($schedule, $index + 1);
                                        $time       = date('h', strtotime($substr));
                                        $min        = date('i', strtotime($overtime->time_rendered));

                                        echo ($time - $overtime->rendered_time) . ':' . $min ;
                                    ?>




                                </td>
                                <td>
                                    @if($overtime->status == 'Pending')
                                        @can('overtime_edit')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'get',
                                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                            'route' => ['admin.overtime.approve', $overtime->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_approve'), array('class' => 'btn btn-xs btn-success')) !!}
                                        {!! Form::close() !!}
                                        @endcan
                                        @can('overtime_edit')
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'get',
                                            'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                            'route' => ['admin.overtime.deny', $overtime->id])) !!}
                                        {!! Form::submit(trans('quickadmin.qa_deny'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                        @endcan
                                        @can('overtime_edit')
                                        <a href="{{ route('admin.overtime.edit', [$overtime->id]) }}" class="btn btn-xs btn-info">
                                            @lang('quickadmin.qa_edit')
                                        </a>
                                    @endcan
                                    @else
                                        <span class="label label-{{ $overtime->status == 'Approved' ? 'success' : 'danger'}}">
                                                {{ $overtime->status }}
                                        </span>
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
@stop

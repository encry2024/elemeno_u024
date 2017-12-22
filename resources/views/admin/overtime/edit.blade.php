@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.overtime.title')</h3>

    {!! Form::model($overtime, ['method' => 'PUT', 'route' => ['admin.overtime.update', $overtime->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::hidden('id', $overtime->id ) !!}
                    {!! Form::label('employee', 'Full Name *', ['class' => 'control-label']) !!}
                    {!! Form::text('employee', $overtime->employee->fullname(), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('id'))
                        <p class="help-block">
                            {{ $errors->first('id') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('date', 'Date*', ['class' => 'control-label']) !!}
                    {!! Form::text('date', $overtime->date, ['class' => 'form-control text', 'placeholder' => '2017-05-28']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('date'))
                        <p class="help-block">
                            {{ $errors->first('date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('sched_out', 'Schedule Out*', ['class' => 'control-label']) !!}
                    {!! Form::text('sched_out', $overtime->sched_out, ['class' => 'form-control date', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('sched_out'))
                        <p class="help-block">
                            {{ $errors->first('sched_out') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('time_out', 'Time Out*', ['class' => 'control-label']) !!}
                    {!! Form::text('time_out', $overtime->time_out, ['class' => 'form-control date', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('time_out'))
                        <p class="help-block">
                            {{ $errors->first('time_out') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('status', 'Request Status*', ['class' => 'control-label']) !!}
                    {!! Form::select('status', ['1' => 'Pending', 'Approve', 'Deny'],$overtime->status, ['class' => 'form-control select2', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('status'))
                        <p class="help-block">
                            {{ $errors->first('status') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script src="{{ url('prysystmctrl/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm:ss"
        });
    </script>

@stop

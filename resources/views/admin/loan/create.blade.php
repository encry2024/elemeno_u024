@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.loan.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.loan.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('employee_id', 'Full Name *', ['class' => 'control-label']) !!}
                    {!! Form::select('employee_id', $employees, old('employee_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('employee_id'))
                        <p class="help-block">
                            {{ $errors->first('employee_id') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('date', 'Date*', ['class' => 'control-label']) !!}
                    {!! Form::text('date', old('date', Request::get('date', date('Y-m-d'))), ['class' => 'form-control date']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('date'))
                        <p class="help-block">
                            {{ $errors->first('date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('amount', 'Cash Amount*', ['class' => 'control-label']) !!}
                    {!! Form::text('amount', old('amount'), ['class' => 'form-control']) !!}
                    {!! Form::hidden('status', 'Unpaid') !!}
                    <p class="help-block"></p>
                    @if($errors->has('amount'))
                        <p class="help-block">
                            {{ $errors->first('amount') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('months', 'Plan of Payment (Month)*', ['class' => 'control-label']) !!}
                    {!! Form::select('months',
                            [
                                '1'  => '1',
                                '3'  => '3',
                                '6'  => '6',
                                '9'  => '9',
                                '12' => '12',
                                'Others' => 'Others'],
                            old('pop'),
                            [
                                'class' => 'form-control select2'
                            ])
                    !!}

                    <p class="help-block"></p>
                    @if($errors->has('months'))
                        <p class="help-block">
                            {{ $errors->first('months') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group" id="pane_other" hidden>
                    {!! Form::label('others', 'Others*', ['class' => 'control-label']) !!}
                    {!! Form::text('others', old('others'), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('others'))
                        <p class="help-block">
                            {{ $errors->first('others') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_save'), ['class' => 'btn btn-danger']) !!}
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

        $('#pane_other').hide();

        $('#months').on('change', function()
        {
            if($('#months').val() == 'Others')
            {
                $('#pane_other').css('display', 'block');
            }
            else
            {
                $('#pane_other').css('display', 'none');
            }
        });

    </script>

@stop

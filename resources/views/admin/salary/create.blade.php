@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('prsystmctrl.computation.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['computation.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('prsystmctrl.pr_create')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::hidden('employee_id', $employee->id) !!}
                    {!! Form::label('employee_name', 'Full Name *', ['class' => 'control-label']) !!}
                    {!! Form::text('employee_name', $employee->fullname(), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('employee_id'))
                        <p class="help-block">
                            {{ $errors->first('employee_id') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('date', 'Date Entry*', ['class' => 'control-label']) !!}
                    {!! Form::text('date', old('date'), ['class' => 'form-control text', 'placeholder' => '2017-05-28']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('date'))
                        <p class="help-block">
                            {{ $errors->first('date') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('cash_advance', 'Cash Advance*', ['class' => 'control-label']) !!}
                    {!! Form::text('cash_advance', old('cash_advance'), ['class' => 'form-control text', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('cash_advance'))
                        <p class="help-block">
                            {{ $errors->first('cash_advance') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group">
                    {!! Form::label('sss', 'SSS*', ['class' => 'control-label']) !!}
                    {!! Form::text('sss', old('sss'), ['class' => 'form-control text', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('sss'))
                        <p class="help-block">
                            {{ $errors->first('sss') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('pag_ibig', 'Pag Ibig*', ['class' => 'control-label']) !!}
                    {!! Form::text('pag_ibig', old('pag_ibig'), ['class' => 'form-control text', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('pag_ibig'))
                        <p class="help-block">
                            {{ $errors->first('pag_ibig') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group">
                    {!! Form::label('philhealth', 'Philhealth*', ['class' => 'control-label']) !!}
                    {!! Form::text('philhealth', old('philhealth'), ['class' => 'form-control text', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('philhealth'))
                        <p class="help-block">
                            {{ $errors->first('philhealth') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('prsystmctrl.pr_save'), ['class' => 'btn btn-danger']) !!}
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

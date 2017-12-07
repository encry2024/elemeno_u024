@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.time-entries.title')</h3>
    {!! Form::open(array(
        'autocomplete' => 'off',
        'method' => 'POST',
        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
        'route' => ['admin.time_entries.store'])) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_create')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4 form-group {{ $errors->has('employee_id') ? 'has-error' : '' }}">
                    {!! Form::label('employee_id', 'Employee *', ['class' => 'control-label']) !!}
                    {!! Form::select('employee_id', $employee, old('employee_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('employee_id'))
                        <p class="help-block">
                            {{ $errors->first('employee_id') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                    {!! Form::label('date', 'Date*', ['class' => 'control-label']) !!}
                    {!! Form::text('date', old('date'), ['class' => 'form-control date', 'placeholder' => 'e.g '.date('Y-m-d')]) !!}
                    <p class="help-block"></p>
                    @if($errors->has('date'))
                        <p class="help-block">
                            {{ $errors->first('date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group {{ $errors->has('time_in') ? 'has-error' : '' }}">
                    {!! Form::label('time_in', 'Time In*', ['class' => 'control-label']) !!}
                    {!! Form::text('time_in', old('time_in'), ['class' => 'form-control time', 'placeholder' => 'e.g 08:00:00']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('time_in'))
                        <p class="help-block">
                            {{ $errors->first('time_in') }}
                        </p>
                    @endif
                </div>
              <div class="col-xs-4 form-group {{ $errors->has('time_out') ? 'has-error' : '' }}">
                  {!! Form::label('time_out', 'Time Out*', ['class' => 'control-label']) !!}
                  {!! Form::text('time_out', old('time_out'), ['class' => 'form-control time', 'placeholder' => 'e.g 17:00:00']) !!}
                  <p class="help-block"></p>
                  @if($errors->has('time_out'))
                      <p class="help-block">
                          {{ $errors->first('time_out') }}
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
    <script src="{{ url('quickadmin/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>    <script>
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm:ss"
        });
    </script>

@stop

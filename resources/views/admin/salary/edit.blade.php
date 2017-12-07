@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.salary-record-management.title')</h3>

    {!! Form::model(null, [
        'method' => 'PUT',
        'onsubmit' => "return confirm('Do you want to Update');",
        'route' => ['admin.salary.update', $salary->id]])
    !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('employee_name', 'Full Name', ['class' => 'control-label']) !!}
                    {!! Form::text('employee_name', $salary->employee->fullname(), ['class' => 'form-control', 'readonly' => 'true']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('employee_name'))
                        <p class="help-block">
                            {{ $errors->first('employee_name') }}
                        </p>
                    @endif
                </div>   
                <div class="col-xs-3 form-group">
                    {!! Form::label('date', 'Payroll Date', ['class' => 'control-label']) !!}
                    {!! Form::text('date', $salary->date, ['class' => 'form-control', 'readonly' => 'true']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('date'))
                        <p class="help-block">
                            {{ $errors->first('date') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('date_range', 'Date Range', ['class' => 'control-label']) !!}
                    {!! Form::text('date_range', $salary->date_range, ['class' => 'form-control', 'readonly' => 'true']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('date'))
                        <p class="help-block">
                            {{ $errors->first('date') }}
                        </p>
                    @endif
                </div>           
            </div>

            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('basic', 'Basic Pay', ['class' => 'control-label']) !!}
                    {!! Form::text('basic', $salary->basic, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('basic'))
                        <p class="help-block">
                            {{ $errors->first('basic') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('holiday', 'Holiday Pay', ['class' => 'control-label']) !!}
                    {!! Form::text('holiday', $salary->holiday, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('holiday'))
                        <p class="help-block">
                            {{ $errors->first('holidayy') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('cola', 'Cola', ['class' => 'control-label']) !!}
                    {!! Form::text('cola', $salary->cola, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('cola'))
                        <p class="help-block">
                            {{ $errors->first('cola') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('overtime_pay', 'Overtime Pay', ['class' => 'control-label']) !!}
                    {!! Form::text('overtime_pay', $salary->overtime_pay, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('overtime_pay'))
                        <p class="help-block">
                            {{ $errors->first('overtime_pay') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-3 form-group">
                    {!! Form::label('overtime_pay_night', 'Overtime Pay Night.', ['class' => 'control-label']) !!}
                    {!! Form::text('overtime_pay_night', $salary->overtime_pay_night, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('overtime_pay_night'))
                        <p class="help-block">
                            {{ $errors->first('overtime_pay_night') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('bonus', 'Bonus', ['class' => 'control-label']) !!}
                    {!! Form::text('bonus', $salary->bonus, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('bonus'))
                        <p class="help-block">
                            {{ $errors->first('bonus') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('allowance', 'Allowance', ['class' => 'control-label']) !!}
                    {!! Form::text('allowance', $salary->allowance, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('allowance'))
                        <p class="help-block">
                            {{ $errors->first('allowance') }}
                        </p>
                    @endif
                </div> 
                <div class="col-xs-3 form-group">
                    {!! Form::label('late', 'Late Deduction', ['class' => 'control-label']) !!}
                    {!! Form::text('late', $salary->late, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('late'))
                        <p class="help-block">
                            {{ $errors->first('late') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('cash_advance', 'Cash Advance', ['class' => 'control-label']) !!}
                    {!! Form::text('cash_advance', $salary->cash_advance, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('cash_advance'))
                        <p class="help-block">
                            {{ $errors->first('cash_advance') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group">
                    {!! Form::label('loan', 'Company Loan', ['class' => 'control-label']) !!}
                    {!! Form::text('loan', $salary->loan, ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('loan'))
                        <p class="help-block">
                            {{ $errors->first('loan') }}
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

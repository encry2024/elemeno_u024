@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.employee.sub-title')</h3>

    {!! Form::model($employee,
       ['method' => 'PUT',
       'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."')",
       'route' => ['admin.employee.update', $employee->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-4 form-group {{ $errors->has('employee_no') ? 'has-error' : '' }}">
                    {!! Form::label('employee_no', 'Employee No.*', ['class' => 'control-label']) !!}
                    {!! Form::text('employee_no', old('employee_no'), ['class' => 'form-control', 'placeholder' => '', 'readonly']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('employee_no'))
                        <p class="help-block">
                            {{ $errors->first('employee_no') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
                    {!! Form::label('fname', 'First Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('fname', old('fname'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('fname'))
                        <p class="help-block">
                            {{ $errors->first('fname') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group {{ $errors->has('mname') ? 'has-error' : '' }}">
                    {!! Form::label('mname', 'Middle Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('mname', old('mname'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('mname'))
                        <p class="help-block">
                            {{ $errors->first('mname') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-4 form-group {{ $errors->has('lname') ? 'has-error' : '' }}">
                    {!! Form::label('lname', 'Last Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('lname', old('lname'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('lname'))
                        <p class="help-block">
                            {{ $errors->first('lname') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    {!! Form::label('address', 'Address*', ['class' => 'control-label']) !!}
                    {!! Form::text('address', old('address'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('address'))
                        <p class="help-block">
                            {{ $errors->first('address') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                    {!! Form::label('status', 'Civil Status*', ['class' => 'control-label']) !!}
                    {!! Form::text('status', old('status'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('status'))
                        <p class="help-block">
                            {{ $errors->first('status') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
                    {!! Form::label('dob', 'Date of Birth*', ['class' => 'control-label']) !!}
                    {!! Form::text('dob', old('dob'), ['class' => 'form-control', 'placeholder' => 'YYYY-MM-DD']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('dob'))
                        <p class="help-block">
                            {{ $errors->first('dob') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('pob') ? 'has-error' : '' }}">
                    {!! Form::label('pob', 'Place of Birth*', ['class' => 'control-label']) !!}
                    {!! Form::text('pob', old('pob'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('pob'))
                        <p class="help-block">
                            {{ $errors->first('pob') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('no_of_dependents') ? 'has-error' : '' }}">
                    {!! Form::label('no_of_dependents', 'No. of Dependents*', ['class' => 'control-label']) !!}
                    {!! Form::text('no_of_dependents', old('no_of_dependents'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('no_of_dependents'))
                        <p class="help-block">
                            {{ $errors->first('no_of_dependents') }}
                        </p>
                    @endif
                </div>
            </div>

            <!--  -->
            <div class="row">
                <div class="col-xs-3 form-group {{ $errors->has('sss') ? 'has-error' : '' }}">
                    {!! Form::label('sss', 'SSS No.', ['class' => 'control-label']) !!}
                    {!! Form::text('sss', old('sss'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('sss'))
                        <p class="help-block">
                            {{ $errors->first('sss') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('pag_ibig') ? 'has-error' : '' }}">
                    {!! Form::label('pag_ibig', 'HDMF No.', ['class' => 'control-label']) !!}
                    {!! Form::text('pag_ibig', old('pag_ibig'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('pag_ibig'))
                        <p class="help-block">
                            {{ $errors->first('pag_ibig') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('philhealth') ? 'has-error' : '' }}">
                    {!! Form::label('philhealth', 'Philhealth No*', ['class' => 'control-label']) !!}
                    {!! Form::text('philhealth', old('philhealth'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('philhealth'))
                        <p class="help-block">
                            {{ $errors->first('philhealth') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('tin') ? 'has-error' : '' }}">
                    {!! Form::label('tin', 'Tin No.', ['class' => 'control-label']) !!}
                    {!! Form::text('tin', old('tin'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('tin'))
                        <p class="help-block">
                            {{ $errors->first('tin') }}
                        </p>
                    @endif
                </div>
            </div>
            <!--  -->

            <!--  -->
            <div class="row">
                <div class="col-xs-3 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', 'E-mail Address*', ['class' => 'control-label']) !!}
                    {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                    {!! Form::label('contact_no', 'Contact No.*', ['class' => 'control-label']) !!}
                    {!! Form::text('contact_no', old('contact_no'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('contact_no'))
                        <p class="help-block">
                            {{ $errors->first('contact_no') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('contact_no2') ? 'has-error' : '' }}">
                    {!! Form::label('contact_no2', 'Additional Contact No.*', ['class' => 'control-label']) !!}
                    {!! Form::text('contact_no2', old('contact_no2'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('contact_no2'))
                        <p class="help-block">
                            {{ $errors->first('contact_no2') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('schedule') ? 'has-error' : '' }}">
                    {!! Form::label('schedule', 'Schedule*', ['class' => 'control-label']) !!}
                    {!! Form::select('schedule', $time, old('schedule'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('schedule'))
                        <p class="help-block">
                            {{ $errors->first('schedule') }}
                        </p>
                    @endif
                </div>
            </div>
            <!--  -->

            <div class="row">
                <div class="col-xs-3 form-group {{ $errors->has('no_of_dependents') ? 'has-error' : '' }}">
                    {!! Form::label('working_status', 'Employment Status*', ['class' => 'control-label']) !!}
                    {!! Form::select('working_status', [1 => 'Regular', 'Project Based', 'Dismissed'], old('working_status'), ['class' => 'form-control select2', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('working_status'))
                        <p class="help-block">
                            {{ $errors->first('working_status') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-3 form-group {{ $errors->has('leave_entitlement') ? 'has-error' : '' }}">
                    {!! Form::label('leave_entitlement', 'Employment Status*', ['class' => 'control-label']) !!}
                    {!! Form::text('leave_entitlement', old('leave_entitlement'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('leave_entitlement'))
                        <p class="help-block">
                            {{ $errors->first('leave_entitlement') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

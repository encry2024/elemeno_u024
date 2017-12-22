@extends('layouts.employee')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">Request for a Leave</div>

			<div class="panel-body">
				{!! Form::open([
					'method' => 'post', 
					'route' => ['employee.leave.store'],
					'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');"
					]) !!}
					<div class="row">
						<div class="form-group col-md-3">
							{!! Form::label('employee_no', 'Employee No.', ['class' => 'control-label']) !!}
							{!! Form::text('employee_no', 
								Auth::user()->employee->employee_no, [
								'class' => 'form-control' , 
								'readonly' => 'true'
							]) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{!! Form::label('fullname', 'Name', ['class' => 'control-label']) !!}
							{!! Form::text('fullname', Auth::user()->employee->fullname(), ['class' => 'form-control' , 'readonly' => 'true']) !!}
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							{!! Form::label('date', 'Start Date*', ['class' => 'control-label']) !!}
							{!! Form::text(
									'date', old('date'), [
									'class' => 'form-control date', 
									'placeholder' => date('Y-m-d')
							]) !!}
							<p class="help-block"></p>
		                    @if($errors->has('date'))
		                        <p class="help-block">
		                            {{ $errors->first('date') }}
		                        </p>
		                    @endif
						</div>
						<div class="form-group col-md-3">
							{!! Form::label('days', 'Day(s) Leave*', ['class' => 'control-label']) !!}
							{!! Form::text(
									'days', old('days'), [
									'class' => 'form-control', 
									'placeholder' => '0'
							]) !!}
							<p class="help-block"></p>
		                    @if($errors->has('days'))
		                        <p class="help-block">
		                            {{ $errors->first('days') }}
		                        </p>
		                    @endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							{!! Form::label('reason', 'Reason*', ['class' => 'control-label']) !!}
							{!! Form::text('reason', old('reason'), ['class' => 'form-control']) !!}
							<p class="help-block"></p>
		                    @if($errors->has('date'))
		                        <p class="help-block">
		                            {{ $errors->first('from') }}
		                        </p>
		                    @endif
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							<button class="btn btn-primary"><i class="fa fa-send"></i> Send Request</button>
						</div>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop
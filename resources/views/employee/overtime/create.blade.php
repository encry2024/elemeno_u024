@extends('layouts.employee')

@section('content')

	@if(session('msg'))
		<div class="alert alert-danger">
			{{ session('msg') }}
		</div>
	@endif

	<div class="panel panel-default">
		

		<div class="panel-heading">Create Overtime Request</div>

			<div class="panel-body">
				{!! Form::open([
					'method' => 'post', 
					'route' => ['employee.overtime.store'],
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
							{!! Form::label('date', 'Date*', ['class' => 'control-label']) !!}
							{!! Form::text('date', old('date'), ['class' => 'form-control date', 'placeholder' => date('Y-m-d')]) !!}
							<p class="help-block"></p>
		                    @if($errors->has('date'))
		                        <p class="help-block">
		                            {{ $errors->first('date') }}
		                        </p>
		                    @endif
						</div>
						<div class="form-group col-md-3">
							{!! Form::label('time_rendered', 'Time Rendered*', ['class' => 'control-label']) !!}
							{!! Form::text(
									'time_rendered', 
									old('time_rendered'), [
									'class' => 'form-control time', 
									'placeholder' => '01:20:00'
							]) !!}
							<p class="help-block"></p>
		                    @if($errors->has('time_rendered'))
		                        <p class="help-block">
		                            {{ $errors->first('time_rendered') }}
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
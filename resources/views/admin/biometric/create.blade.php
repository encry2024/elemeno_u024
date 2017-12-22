@extends('layouts.app')

@section('content')
    <h3 class="page-title">Biometric Management</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.biometric.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Create
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('device_name', 'Device Name *', ['class' => 'control-label']) !!}
                    {!! Form::text('name', '', ['class' => 'form-control']) !!}
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('serial_number', 'Serial Number *', ['class' => 'control-label']) !!}
                    {!! Form::text('sn', '', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('verification_code', 'Verification Code *', ['class' => 'control-label']) !!}
                    {!! Form::text('vc', '', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('activation_code', 'Activation Code *', ['class' => 'control-label']) !!}
                    {!! Form::text('ac', '', ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6 form-group">
                    {!! Form::label('verification_key', 'Verification Key *', ['class' => 'control-label']) !!}
                    {!! Form::text('vkey', '', ['class' => 'form-control']) !!}
                </div>
            </div>
        </div> <!-- panel-body closing -->
    </div> <!-- panel-default closing -->

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop


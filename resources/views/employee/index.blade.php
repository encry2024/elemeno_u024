<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="{{ asset('quickadmin/css/bootstrap.min.css') }}">

    <style type="text/css">
        html, body {
            background-color: #fff;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
            width: 640px;
            margin: 0 auto;
        }
        .position-ref {
            position: relative;
        }
        .help-block{
            color: red;
        }
    </style>
</head>
<body>
    <div class="flex-center position-ref full-height">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">&nbsp;</div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            @if(session('failed'))
                                <p class="help-block">
                                    {{ session('failed') }}
                                </p>
                            @endif
                            
                            {!! Form::open(['method' => 'post', 'route' => ['employee.auth']]) !!}
                                <div class="form-group">
                                    {!! Form::label('employee_no', 'Employee No.', ['class' => 'control-label']) !!}
                                    {!! Form::text('employee_no', old('employee_no'), ['class' => 'form-control']) !!}
                                    <p class="help-block"></p>
                                    @if($errors->has('employee_no'))
                                        <p class="help-block">
                                            {{ $errors->first('employee_no') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    <p class="help-block"></p>
                                    @if($errors->has('password'))
                                        <p class="help-block">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                    
                                </div>

                                <div class="form-group">
                                    {!! Form::submit('Login', ['class' => 'btn btn-default']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>   
                    </div>
                </div>
            </div>
        </div>   
    </div>
</body>
</html>
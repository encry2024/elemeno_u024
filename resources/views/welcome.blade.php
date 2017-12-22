<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to Payroll</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('quickadmin/css/bootstrap.min.css') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                font-family: 'Arial', sans-serif;
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
                width: 540px;
                margin: 0 auto;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                width: 100%;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .btn{
                width: 120px;
            }
            
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee</div>

                    <div class="panel-body">
                        <p>Employee Access</p>
                        <ul>
                            <li>Request for Overtime</li>
                            <li>File Leave</li>
                            <li>Summary of payslip</li>
                        </ul> 
                        <a class="btn btn-default" href="{{ url('/employee/index') }}">VIEW</a>
                    </div>
                </div>  

                <div class="panel panel-default">
                    <div class="panel-heading">Management</div>

                    <div class="panel-body">
                        <p>Management Access</p>
                        <a class="btn btn-default" href="{{ url('login') }}">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

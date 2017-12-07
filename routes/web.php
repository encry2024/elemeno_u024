<?php
Route::get('/', function () { return view('welcome'); });

Route::get('employee/index', 'Employee\HomeController@index');
Route::post('employee/auth', ['uses' => 'Employee\HomeController@auth', 'as' => 'employee.auth']);

Route::get('/home', function(){
    if(Auth::check())
    {
        switch(Auth::user()->role->id)
        {
            case 1:
                return redirect('/admin/home');
            break;
            case 2:
                return redirect('/admin/employee');
            break;
            case 3:
                return redirect('/employee/info');
            break;
        }
    }
});

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    Route::resource('employee', 'EmployeeController');
    Route::post('employee_mass_destroy', ['uses' => 'EmployeeController@massDestroy', 'as' => 'employee.mass_destroy']);
    Route::post('employee/search', ['uses' => 'EmployeeController@search', 'as' => 'employee.search']);

    Route::resource('department', 'EmployeeDepartmentController');
    Route::post('department_mass_destroy', ['uses' => 'EmployeeDepartmentController@massDestroy', 'as' => 'department.mass_destroy']);

    Route::resource('position', 'EmployeePositionController');
    Route::post('position_mass_destroy', ['uses' => 'EmployeePositionController@massDestroy', 'as' => 'position.mass_destroy']);

    Route::resource('time_entries', 'EmployeeTimeEntriesController');
    Route::post('time_entries_mass_destroy', ['uses' => 'EmployeeTimeEntriesController@massDestroy', 'as' => 'time_entries.mass_destroy']);

    Route::resource('attendance', 'EmployeeAttendanceController');
    Route::post('attendance/search', ['uses' => 'EmployeeAttendanceController@search', 'as' => 'attendance.search']);

    Route::resource('holiday', 'HolidayController');

    Route::resource('salary', 'PayRollController');
    Route::post('salary/run_payroll', ['uses' => 'PayRollController@runPayroll', 'as' => 'salary.run_payroll']);
    Route::get('salary/{id}/print', ['uses' => 'PayRollController@printPreview', 'as' => 'salary.print']);

    Route::resource('cash_advance', 'CashAdvanceController');
    Route::post('cash_advance/search', ['uses' => 'CashAdvanceController@search', 'as' => 'cash_advance.search']);
    Route::post('cash_advance_mass_destroy', ['uses' => 'CashAdvanceController@massDestroy', 'as' => 'cash_advance.mass_destroy']);

    Route::resource('bonus', 'BonusController');

    Route::resource('overtime', 'OvertimeController');
    Route::get('overtime/{id}/approve', ['uses' => 'OvertimeController@approve', 'as' => 'overtime.approve']);
    Route::get('overtime/{id}/deny', ['uses' => 'OvertimeController@deny', 'as' => 'overtime.deny']);

    Route::resource('leave', 'Admin\LeaveController');
    Route::get('leave/{id}/approve', ['uses' => 'Admin\LeaveController@approve', 'as' => 'leave.approve']);
    Route::get('leave/{id}/deny', ['uses' => 'Admin\LeaveController@deny', 'as' => 'leave.deny']);

    Route::resource('backpay', 'BackPayController');
    Route::get('backpay/{id}/approve', ['uses' => 'BackPayController@approve', 'as' => 'backpay.approve']);
    Route::get('backpay/{id}/deny', ['uses' => 'BackPayController@deny', 'as' => 'backpay.deny']);

    Route::resource('month13', 'Month13Controller');
    Route::post('month13_mass_destroy', ['uses' => 'Month13Controller@massDestroy', 'as' => 'month13.mass_destroy']);

    Route::resource('leaveconversion', 'LeaveConversionController');
    Route::post('leaveconversion/convert', ['uses' => 'LeaveConversionController@convert', 'as' => 'leaveconversion.convert']);
    Route::post('leaveconversion_mass_destroy', ['uses' => 'LeaveConversionController@massDestroy', 'as' => 'leaveconversion.mass_destroy']);

    Route::resource('reports', 'ReportController');
    Route::get('reports/contribution', ['uses' => 'ReportController@contribution', 'as' => 'reports.contribution']);

    Route::resource('logs', 'LogController');


    Route::get('loan/request', ['uses' => 'LoanController@request', 'as' => 'loan.request']);
    Route::get('loan/{id}/approve', ['uses' => 'LoanController@approve', 'as' => 'loan.approve']);
    Route::get('loan/{id}/deny', ['uses' => 'LoanController@deny', 'as' => 'loan.deny']);


    Route::get('allowance/{id}/delete', ['uses' => 'EmployeePositionController@delete', 'as' => 'allowance.delete']);
});


Route::group(['middleware' => ['auth'], 'prefix' => 'employee', 'as' => 'employee.'], function(){

    Route::resource('info', 'Employee\InfoController');

    Route::resource('overtime', 'Employee\OvertimeRequestController');

    Route::resource('leave', 'Employee\LeaveRequestController');

    Route::resource('loan', 'LoanController');

    Route::resource('summary', 'Employee\SummaryController');

});
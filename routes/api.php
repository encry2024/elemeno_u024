<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {
	Route::get('employee/{employee}/log', function(App\Employee $employee) {
		if(isset($employee)) {
			$employee_log = App\EmployeeTimeEntries::whereEmployeeId($employee->id)->orderBy('id', 'desc')->first();

			if(isset($employee_log)) {
				if(is_null($employee_log->time_out)) {
					$employee_log->time_out = date('H:i:s');

					if($employee_log->save()) {
						return 'Payroll System Response: ' . $employee->fname . ' ' . $employee->mname . ' ' . $employee->lname . ' has logged out';
					}
				} else {
					$employee_login = new App\EmployeeTimeEntries();
					$employee_login->employee_id = $employee->id;
					$employee_login->date = date('Y-m-d');
					$employee_login->time_in = date('H:i:s');

					if($employee_login->save()) {
						return 'Payroll System Response: ' . $employee->fname . ' ' . $employee->mname . ' ' . $employee->lname . ' has logged in';
					}
				}
			} else {
				$employee_login = new App\EmployeeTimeEntries();
				$employee_login->employee_id = $employee->id;
				$employee_login->date = date('Y-m-d');
				$employee_login->time_in = date('H:i:s');

				if($employee_login->save()) {
					return 'Payroll System Response: ' . $employee->fname . ' ' . $employee->mname . ' ' . $employee->lname . ' has logged in';
				}
			}
		} else {
			return 'Employee does not exist in Payroll System...';
		}
	});
});

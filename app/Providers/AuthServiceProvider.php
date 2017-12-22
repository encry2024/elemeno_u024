<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = \Auth::user();
        
        // Auth gates for: Dashboard
        Gate::define('dashboard_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [1]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Employee record management
        Gate::define('employee_record_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Employee
        Gate::define('employee_access', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('employee_create', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('employee_edit', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('employee_view', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('employee_delete', function ($user){
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Department

        Gate::define('department_access', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_create', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_edit', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_view', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('department_delete', function ($user){
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Position

        Gate::define('position_access', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_create', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_edit', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_view', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('position_delete', function ($user){
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Attendance record management
        Gate::define('attendance_record_management_access', function ($user){
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Time management
        Gate::define('time_entries_access', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('time_entries_create', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('time_entries_edit', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('time_entries_view', function ($user){
            return in_array($user->role_id, [1, 2]);
        });
        Gate::define('time_entries_delete', function ($user){
            return in_array($user->role_id, [1]);
        });

        // Auth gates for: Attendance Report
        Gate::define('attendance_report_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        // Auth gates for: Salary Record Management
        Gate::define('salary_record_management_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        //Auth gates for: Salary Computation
        Gate::define('computation_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('computation_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('computation_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('computation_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        //Auth gates for: Cash Advance
        Gate::define('cash_advance_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('cash_advance_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('cash_advance_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('cash_advance_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('cash_advance_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Bonus
        Gate::define('bonus_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('bonus_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('bonus_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('bonus_view', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('bonus_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Loan
        Gate::define('loan_access', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        Gate::define('loan_create', function ($user) {
            return in_array($user->role_id, [1, 2, 3]);
        });

        Gate::define('loan_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('loan_view', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Report
        Gate::define('report_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('report_search', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Holiday
        Gate::define('holiday_access', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('holiday_edit', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('holiday_create', function ($user) {
            return in_array($user->role_id, [1, 2]);
        });

        Gate::define('holiday_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Overtime Request
        Gate::define('overtime_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('overtime_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Backpay
        Gate::define('backpay_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('backpay_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('backpay_paid', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Backpay
        Gate::define('13month_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('13month_create', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('13month_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('13month_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        //Auth Gate for: Leave Convertion
        Gate::define('leaveconversion_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('leaveconversion_create', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('leaveconversion_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('leaveconversion_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });


        //Auth Gate for: leave
        Gate::define('leave_access', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('leave_edit', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('leave_view', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('leave_delete', function ($user) {
            return in_array($user->role_id, [1]);
        });

        Gate::define('log_access', function ($user) {
            return in_array($user->role_id, [1]);
        });


        //Employee can access
        Gate::define('employee_page_access', function($user) {
            return in_array($user->role_id, [2, 3]);
        });

    }
}

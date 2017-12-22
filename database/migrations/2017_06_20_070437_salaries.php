<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Salaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('overtime_requests')){
            Schema::create('overtime_requests', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->date('date');
                $table->time('time_rendered');
                $table->enum('status', ['Pending', 'Approved', 'Denied']);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('holidays')){
            Schema::create('holidays', function(Blueprint $table) {
                $table->increments('id');
                $table->date('date')->unique();
                $table->enum('type', ['Regular Holiday', 'Special Holiday']);
                $table->string('description');
            });
        }

        if(! Schema::hasTable('bonuses')){
            Schema::create('bonuses', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->string('type');
                $table->decimal('amount', 10, 2);
                $table->date('date');
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('cash_advances')){
            Schema::create('cash_advances', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->decimal('amount', 10, 2);
                $table->string('status');
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('loans')){
            Schema::create('loans', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->date('date');
                $table->decimal('amount', 10, 2);
                $table->integer('months');
                $table->decimal('monthly_payment');
                $table->string('status');
            });
        }

        if(! Schema::hasTable('salaries')) {
            Schema::create('salaries', function (Blueprint $table) {
                $table->increments('id');
                $table->string('employee_id')->unsinged();;
                $table->date('date');
                $table->integer('days');
                $table->string('date_range');
                $table->decimal('basic', 10, 2);
                $table->decimal('holiday', 10, 2);
                $table->decimal('cola', 10, 2);
                $table->decimal('overtime_pay', 10, 2);
                $table->decimal('overtime_pay_night', 10, 2);
                $table->decimal('bonus', 10, 2);
                $table->decimal('allowance', 10, 2);
                $table->decimal('gross', 10, 2);
                $table->decimal('tax', 10, 2);
                $table->decimal('cash_advance', 10, 2);
                $table->decimal('loan', 10, 2);
                $table->decimal('late', 10, 2);
                $table->decimal('total_deductions', 10, 2);
                $table->decimal('net_pay', 10, 2);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('contributions')){
            Schema::create('contributions', function (Blueprint $table) {
                $table->increments('id');
                $table->date('date');
                $table->decimal('sss_employer', 10, 2);
                $table->decimal('sss_employee', 10, 2);
                $table->decimal('sss_total', 10, 2);
                $table->decimal('philc_employer', 10, 2);
                $table->decimal('philc_employee', 10, 2);
                $table->decimal('philc_total', 10, 2);
                $table->decimal('hdmf', 10, 2);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('contribution_salary')){
            Schema::create('contribution_salary', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('contribution_id');
                $table->integer('salary_id');
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('backpays')){
            Schema::create('backpays', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->date('date');
                $table->enum('status', ['Pending', 'Paid']);
                $table->decimal('amount', 10, 2);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('month13')){
            Schema::create('month13', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->date('date');
                $table->decimal('amount', 10, 2);
                $table->decimal('tax', 10, 2);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('leaves')){
            Schema::create('leaves', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->date('date');
                $table->integer('days')->unsigned();
                $table->string('reason');
                $table->enum('status', ['Pending', 'Approved', 'Denied']);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('leave_conversions')){
            Schema::create('leave_conversions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsinged();
                $table->date('date');
                $table->integer('unused_leave')->unsigned();
                $table->decimal('amount', 10, 2);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('reports')){
            Schema::create('reports', function (Blueprint $table) {
                $table->increments('id');
                $table->date('date');
                $table->decimal('gross', 10, 2);
                $table->decimal('deduction', 10, 2);
                $table->decimal('netpay', 10, 2);
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('logs')){
            Schema::create('logs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsigned();
                $table->timestamp('date');
                $table->string('type');
                $table->timestamps();
            });
        }

        if(! Schema::hasTable('allowances')){
            Schema::create('allowances', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsigned();
                $table->enum('type', ['None', 'Transportation', 'Clothes', 'Meals', 'Refresentation', 'Communication']);
                $table->decimal('amount', 10, 2);
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('overtime_requests');
        Schema::dropIfExists('holidays');
        Schema::dropIfExists('bonuses');
        Schema::dropIfExists('cash_advances');
        Schema::dropIfExists('loans');
        Schema::dropIfExists('salaries');
        Schema::dropIfExists('contributions');
        Schema::dropIfExists('contribution_salary');
        Schema::dropIfExists('backpays');
        Schema::dropIfExists('month13');
        Schema::dropIfExists('leaves');
        Schema::dropIfExists('leave_conversions');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('allowances');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Employees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('employees')) {
            Schema::create('employees', function (Blueprint $table) {
                $table->increments('id');
                $table->string('employee_no')->unique();
                $table->string('fname');
                $table->string('mname');
                $table->string('lname');
                $table->string('address');
                $table->enum('status', ['Single', 'Married', 'Widowed', 'Widower', 'Divorced', 'Single Parent']);
                $table->date('dob');
                $table->string('pob');
                $table->string('no_of_dependents')->nullable();
                $table->string('sss')->nullable();
                $table->string('pag_ibig')->nullable();
                $table->string('philhealth')->nullable();
                $table->string('tin')->nullable();
                $table->string('contact_no');
                $table->string('contact_no2')->nullable();
                $table->string('email');
                $table->string('schedule');
                $table->enum('working_status', ['Regular', 'Project Based', 'Dismissed']);
                $table->string('leave_entitlement');
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
        Schema::dropIfExists('employees');
    }
}

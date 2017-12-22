<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimeEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(! Schema::hasTable('employee_time_entries')) {
            Schema::create('employee_time_entries', function (Blueprint $table) {
                $table->increments('id');
                $table->string('employee_id');
                $table->date('date');
                $table->time('time_in');
                $table->time('time_out');
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
        Schema::dropIfExists('employee_time_entries');
    }
}

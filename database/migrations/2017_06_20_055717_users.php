<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if(! Schema::hasTable('users')) {
          Schema::create('users', function (Blueprint $table) {
              $table->increments('id');
              $table->string('email');
              $table->string('password');
              $table->integer('role_id')->unsigned()->nullable();
              $table->foreign('role_id', '44755_593fb1a593bac')->references('id')->on('roles')->onDelete('cascade');
              $table->integer('employee_id')->unsigned();
              $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('users');
    }
}

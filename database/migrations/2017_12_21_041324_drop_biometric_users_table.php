<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropBiometricUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('biometric_users');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('biometric_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('biometric_id');
            $table->text('finger_data');
            $table->timestamps();
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropBiometricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('biometrics');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('biometrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sn', 50)->unique();
            $table->string('vc', 50)->unique();
            $table->string('ac', 50)->unique();
            $table->string('vkey', 50)->unique();
            $table->timestamps();
        });
    }
}

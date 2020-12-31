<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->nullable(false);
            $table->unsignedInteger('manufacturer_id')->nullable(false);
            $table->unsignedInteger('type_device_id')->nullable(false);
            $table->string('comment', 200)->nullable();

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            $table->foreign('type_device_id')->references('id')->on('type_devices');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_models');
    }
}

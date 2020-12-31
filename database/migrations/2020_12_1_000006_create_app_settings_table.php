<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppSettingsTable extends Migration
{
    /*
        Название
        Юридической название
        Телефоны
        Почта
        Адрес
        Валюта
        График работы
        

    */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('legal_name', 100);
            $table->text('phones');
            $table->string('email', 100);
            $table->string('address', 256);
            $table->string('currency', 3);
            $table->string('unitcode', 4);
            $table->string('repair_conditions', 3000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
}

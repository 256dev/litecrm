<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /*
        Имя
        Почта
        Телефоны(месенджеры)
        Тип пользователя(админ, менеджер, мастер)
        Дата начала работы
        Дата увольнения
        Квалификация
        Адрес
        Паспорт
        ИНН
        Комментарий
    */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('phones')->default('');
            $table->string('email')->unique();
            $table->unsignedInteger('role_id')->nullable(false);
            $table->dateTime('hired_date')->nullable(false);
            $table->dateTime('fired_date')->nullable();
            $table->string('qualification')->nullable()->default('');
            $table->string('address')->nullable()->default('');
            $table->string('passport')->nullable()->default('');
            $table->string('itin')->nullable()->default(null);
            $table->string('comment')->nullable()->default('');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable()->default('');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('role_id')->references('id')->on('roles');

        });
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

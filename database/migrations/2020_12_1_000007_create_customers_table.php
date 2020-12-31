<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 50)->nullable(false);
            $table->string('email', 100)->nullable();
            $table->string('passport', 20)->nullable();
            $table->string('address', 100)->nullable();
            $table->unsignedSmallInteger('all_orders')->default(0); 
            $table->unsignedSmallInteger('orders_in_process')->default(0); 
            $table->string('status', 10)->nullable();
            $table->string('comment_about', 200)->nullable();
            // $table->string('ads_campaign', 100)->nullable();
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
        Schema::dropIfExists('customers');
    }
}
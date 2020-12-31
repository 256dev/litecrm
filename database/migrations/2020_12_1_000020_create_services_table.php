<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('type_service_id')->nullable(false);
            $table->unsignedBigInteger('order_id')->nullable(false);
            $table->decimal('quantity', 6, 2)->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('type_service_id')->references('id')->on('type_services');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}

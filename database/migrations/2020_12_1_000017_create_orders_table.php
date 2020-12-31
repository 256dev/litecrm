<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number', 18)->nullable(false);
            $table->unsignedBigInteger('customer_id')->nullable(false);
            $table->unsignedInteger('inspector_id')->nullable(false);
            $table->unsignedInteger('engineer_id')->nullable(false);
            $table->unsignedBigInteger('device_id')->nullable(false);
            $table->dateTime('date_contract')->nullable(false);
            $table->unsignedSmallInteger('deadline')->default(1);
            $table->boolean('urgency')->default(false);
            $table->string('defect', 200)->nullable(false)->default('');               
            $table->string('equipment', 200)->nullable()->default('');
            $table->string('condition', 200)->nullable()->default('');
            $table->decimal('prepayment', 10, 2)->default(0);
            $table->decimal('agreed_price', 10, 2)->default(0);
            $table->decimal('price_repair_parts', 10, 2)->default(0);
            $table->decimal('price_work', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_price', 11, 2)->default(0);
            $table->unsignedBigInteger('last_history_id')->nullable();
            $table->string('order_comment', 200)->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('inspector_id')->references('id')->on('users');
            $table->foreign('engineer_id')->references('id')->on('users');
            $table->foreign('device_id')->references('id')->on('devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

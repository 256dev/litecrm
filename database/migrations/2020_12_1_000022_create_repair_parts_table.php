<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('type_repairparts_id')->nullable(false);
            $table->unsignedBigInteger('order_id')->nullable(false);
            $table->decimal('quantity', 6, 2)->default(0);
            $table->tinyInteger('selfpart')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
            
            $table->foreign('type_repairparts_id')->references('id')->on('type_repair_parts');
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
        Schema::dropIfExists('repair_parts');
    }
}

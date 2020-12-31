<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeRepairPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_repair_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->nullable(false);
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('quantity', 10, 2)->default(0);
            $table->tinyInteger('infinity')->default(0);
            $table->decimal('sales', 10, 2)->default(0);
            $table->tinyInteger('selfpart')->default(0);
            $table->tinyInteger('main')->default(0);
            $table->unsignedSmallInteger('priority')->default(15);
            $table->string('description', 200)->nullable();
            $table->string('comment', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_repair_parts');
    }
}

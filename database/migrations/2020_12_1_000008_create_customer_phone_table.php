<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPhoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_phones', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable(false);
            $table->string('phone', 13)->nullable(false);
            $table->boolean('telegram')->default(false);
            $table->boolean('viber')->default(false);
            $table->boolean('whatsapp')->default(false);

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->primary(['customer_id', 'phone']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_phones');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_order', function (Blueprint $table) {
            $table->increments('order_id', 11);	
            $table->string('order_shop', 40);
            $table->integer('customer_id')->unsigned();
            // $table->foreignId('customer_id')->constrained('mst_customer');
            $table->integer('total_price');
            $table->tinyInteger('payment_method');
            $table->integer('ship_charge')->nullable();
            $table->integer('tax')->nullable();
            $table->dateTime('order_date');
            $table->dateTime('shipment_date')->nullable();
            $table->dateTime('cancel_date')->nullable();
            $table->tinyInteger('order_status');
            $table->string('note_customer',255)->nullable();
            $table->string('error_code_api',20)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->foreign('customer_id')->references('customer_id')->on('mst_customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_order');
    }
};

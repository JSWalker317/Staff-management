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
        Schema::create('mst_order_detail', function (Blueprint $table) {
            $table->increments('order_id', 11)->unsigned();	

            $table->integer('detail_line');
            $table->integer('product_id')->unsigned();

            $table->integer('price_buy');
            $table->integer('quantity');
            $table->tinyInteger('shop_id')->unsigned();

            $table->integer('receiver_id');
            $table->timestamps();

            $table->foreign('order_id')->references('order_id')->on('mst_order');
            $table->foreign('product_id')->references('product_id')->on('mst_product');
            $table->foreign('shop_id')->references('shop_id')->on('mst_shop');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_order_detail');
    }
};

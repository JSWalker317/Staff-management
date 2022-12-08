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
        Schema::create('mst_product', function (Blueprint $table) {
            $table->string('product_id',20)->primary();	
            $table->string('product_name', 255);
            $table->string('product_image',255)->nullable();
            $table->decimal('product_price')->default(0);
            $table->tinyInteger('is_sales')->default(1)->comment('0 : Dừng bán hoặc dừng sản xuất  , 1: Có hàng bán');
            $table->string('description')->comment('0: Bình thường , 1 : Đã xóa')->nullable();
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
        Schema::dropIfExists('mst_product');
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->default(0)->comment('订单ID');
            $table->unsignedBigInteger('sku_id')->default(0)->comment('SKU ID');
            $table->unsignedInteger('quantity')->default(0)->comment('下单数量');
            $table->unsignedInteger('after_sale_quantity')->default(0)->comment('售后数量');
            $table->unsignedInteger('after_sale_amount')->default(0)->comment('售后金额');
            $table->unsignedInteger('tag_price')->default(0)->comment('吊牌价格');
            $table->unsignedInteger('tag_amount')->default(0)->comment('吊牌金额');
            $table->unsignedInteger('should_pay_amount')->default(0)->comment('应付金额');
            $table->unsignedInteger('real_pay_amount')->default(0)->comment('实付金额');
            $table->json('snap_shoot')->nullable()->comment('快照信息');

            $table->timestamps();

            $table->unique(['order_id', 'sku_id']);
            $table->index('sku_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_goods');
    }
}

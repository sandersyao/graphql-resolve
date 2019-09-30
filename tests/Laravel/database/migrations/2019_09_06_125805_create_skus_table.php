<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spu_id')->comment('商品SPU ID');
            $table->string('sn', 50)->unique()->comment('商品sn码');
            $table->string('name', 50)->comment('商品名称');
            $table->integer('inventory_count')->default(0)->comment('库存数量');
            $table->integer('inventory_count_lock')->default(0)->comment('库存数量 订单占用');
            $table->tinyInteger('is_online')->default(0)->comment('是否上架 0:下架 1:上架');
            $table->integer('sort')->comment('商品排序');
            $table->string('description')->comment('商品描述');
            $table->integer('tag_price')->unsigned()->default(0)->comment('吊牌价格 (单位：分)');
            $table->bigInteger('create_admin_id')->comment('创建者ID');
            $table->bigInteger('update_admin_id')->comment('修改者ID');
            $table->timestamps();
            $table->softDeletes();

            $table->index('spu_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skus');
    }
}

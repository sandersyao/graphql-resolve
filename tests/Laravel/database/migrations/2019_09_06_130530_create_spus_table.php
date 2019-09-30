<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->comment('SPU名称');
            $table->string('sn', 20)->unique()->comment('SPU编号');
            $table->integer('sort')->comment('推荐顺序');
            $table->text('description')->comment('商品描述');
            $table->tinyInteger('is_online')->default(0)->comment('是否在线状态 0:下架 1:上架');
            $table->bigInteger('create_admin_id')->comment('创建者ID');
            $table->bigInteger('update_admin_id')->comment('修改者ID');
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spus');
    }
}

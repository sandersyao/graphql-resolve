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
            $table->string('order_sn', 100)->default('')->comment('订单编号');
            $table->unsignedBigInteger('user_id')->default(0)->comment('用户ID');
            $table->unsignedTinyInteger('order_status')->default(0)->comment('订单状态：1待支付、2已付款，待发货、3发货中、4等待收货、5已完成、6取消');
            $table->unsignedInteger('total_quantity')->default(0)->comment('总下单数量');
            $table->unsignedInteger('total_tag_amount')->default(0)->comment('总吊牌金额');
            $table->unsignedInteger('total_should_pay_amount')->default(0)->comment('总应付金额');
            $table->unsignedInteger('total_real_pay_amount')->default(0)->comment('总实付金额');
            $table->timestamp('pay_time')->nullable()->comment('付款时间');
            $table->json('pay_exception')->nullable()->comment('支付异常');
            $table->string('bank_type', 20)->nullable()->comment('付款银行，参考微信支付开发文档->支付结果通知');
            $table->integer('submit_deliver_admin_id')->default(0)->comment('提交发货人ID');
            $table->string('submit_deliver_remark', 5000)->default('')->comment('提交发货备注');
            $table->timestamp('submit_deliver_time')->nullable()->comment('提交发货时间');
            $table->integer('deliver_admin_id')->default(0)->comment('发货人ID');
            $table->timestamp('deliver_time')->nullable()->comment('发货时间');
            $table->timestamp('finish_time')->nullable()->comment('完成时间');
            $table->integer('receipt_admin_id')->default(0)->comment('收货操作人ID');
            $table->string('receipt_type', 10)->default('')->comment('收货类型：快递自动收货、手动收货');
            $table->string('receipt_remark', 5000)->default('')->comment('确认收货备注');
            $table->timestamp('cancel_time')->nullable()->comment('取消时间');
            $table->string('cancel_type', 10)->default('')->comment('取消类型：系统自动取消、手动取消');
            $table->string('consignee', 60)->default('')->comment('收件人');
            $table->string('phone', 60)->default('')->comment('联系电话');
            $table->string('address')->default('')->comment('收件地址');
            $table->string('shop_name')->default('')->comment('店铺名称');
            $table->string('express_number', 20)->default('')->comment('快递单号');
            $table->string('express_type', 20)->default('')->comment('快递公司代号');
            $table->string('gift_card_consignee', 60)->default('')->comment('礼品卡收件人姓名');
            $table->string('gift_card_bless_word', 255)->default('')->comment('礼品卡祝福语');
            $table->string('gift_card_sender', 60)->default('')->comment('礼品卡寄件人');

            $table->unsignedInteger('user_rank_id')->nullable()->comment('下单时的会员等级');
            $table->float('rank_discount', 10, 2)->nullable()->comment('下单时的会员等级享受的折扣');
            $table->integer('user_points')->nullable()->comment('下单时的用户积分');

            $table->unsignedTinyInteger('invoice_type')->nullable()->comment('发票类型: 1个人/2企业');
            $table->json('invoice_data')->nullable()->comment('发票数据');
            $table->string('invoice_file_url')->nullable()->comment('发票文件下载地址');
            $table->unsignedTinyInteger('is_invoiced')->nullable()->default(0)->comment('是否已开发票: 0未开/1已开');
            $table->string('referer', 20)->nullable()->comment('订单来源');

            $table->text('utm_source');
            $table->text('utm_medium');
            $table->text('utm_campaign');
            $table->text('utm_content');
            $table->text('utm_term');
            $table->text('latest_utm_source');
            $table->text('latest_utm_medium');
            $table->text('latest_utm_campaign');
            $table->text('latest_utm_content');
            $table->text('latest_utm_term');

            $table->timestamps();
            $table->softDeletes();

            $table->unique('order_sn');
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

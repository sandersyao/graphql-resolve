<?php

namespace GraphQLResolve\Tests\Laravel\Models;

use GraphQLResolve\Tests\Laravel\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    /**
     * 订单状态
     */
    const OS_WAIT_PAY       = 1;    //待支付
    const OS_WAIT_DELIVER   = 2;    //已付款，待发货
    const OS_DELIVER        = 3;    //发货中
    const OS_WAIT_RECEIPT   = 4;    //等待收货
    const OS_FINISHED       = 5;    //已完成
    const OS_CANCELED       = 6;    //取消
    const ORDER_STATUS_MAP  = [
        self::OS_WAIT_PAY       => '待支付',
        self::OS_WAIT_DELIVER   => '已付款，待发货',
        self::OS_DELIVER        => '发货中',
        self::OS_WAIT_RECEIPT   => '等待收货',
        self::OS_FINISHED       => '已完成',
        self::OS_CANCELED       => '取消',
    ];

    /**
     * 收货类型
     */
    const RT_EXPRESS = 'express'; //快递完成收货
    const RT_CONFIRM = 'confirm'; //确认完成收货

    /**
     * 订单取消类型
     */
    const CC_SYSTEM     = 'system'; // 系统自动取消
    const CC_MANUAL     = 'manual'; // 用户手动取消
    const CC_TYPE_MAP   = [
        self::CC_SYSTEM => '系统自动取消',
        self::CC_MANUAL => '用户手动取消',
    ];

    /**
     * 数据是否已同步给恒诚
     */
    const IS_SYNCED     = 1;    // 数据已同步给恒诚
    const NOT_SYNCED    = 0;    // 数据未同步给恒诚

    /**
     * 发票类型
     */
    const INVOICE_PERSONAL      = 1;    // 个人发票
    const INVOICE_ENTERPRISE    = 2;    // 公司发票
    const INVOICE_MAP           = [
        self::INVOICE_PERSONAL      => '个人',
        self::INVOICE_ENTERPRISE    => '公司',
    ];

    /**
     * 订单是否已开发票
     */
    const IS_INVOICED   = 1;    // 已开发票
    const NOT_INVOICED  = 0;    // 未开发票

    /**
     * 下单来源
     */
    const REFERER_SPU   = 'spu';    // 通过 SPU 详情页立即购买 下单
    const REFERER_CART  = 'cart';   // 通过购物车 下单
    const REFERER_MAP   = [
        self::REFERER_SPU   => '商品页',
        self::REFERER_CART  => '购物车页',
    ];

    protected $guarded  = ['id'];

    protected $casts    = [
        'invoice_data'  => 'array',
        'pay_exception' => 'array',
    ];

    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function goods()
    {
        return  $this->hasMany(OrderGoods::class);
    }
}

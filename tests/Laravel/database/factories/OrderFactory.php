<?php

/** @var Factory $factory */

use GraphQLResolve\Tests\Laravel\Models\Order;
use GraphQLResolve\Tests\Laravel\Models\OrderGoods;
use GraphQLResolve\Tests\Laravel\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'order_sn'                  => $faker->uuid,
        'user_id'                   => User::query()->inRandomOrder()->get('id')->first()->id,
        'order_status'              => collect(collect(Order::ORDER_STATUS_MAP)->keys())->random(),
        'total_quantity'            => 0,
        'total_tag_amount'          => 0,
        'total_should_pay_amount'   => 0,
        'total_real_pay_amount'     => 0,
        'pay_time'                  => Carbon::now(),
        'pay_exception'             => null,
        'bank_type'                 => null,
        'submit_deliver_admin_id'   => 0,
        'submit_deliver_remark'     => '',
        'submit_deliver_time'       => Carbon::now(),
        'deliver_admin_id'          => 0,
        'deliver_time'              => Carbon::now(),
        'finish_time'               => Carbon::now(),
        'receipt_admin_id'          => 0,
        'receipt_type'              => Order::RT_EXPRESS,
        'receipt_remark'            => '',
        'cancel_time'               => Carbon::now(),
        'cancel_type'               => collect(collect(Order::CC_TYPE_MAP)->keys())->random(),
        'consignee'                 => $faker->name,
        'phone'                     => $faker->phoneNumber,
        'address'                   => $faker->address,
        'shop_name'                 => 'IPromise',
        'express_number'            => $faker->creditCardNumber,
        'express_type'              => 'SF',
        'gift_card_consignee'       => $faker->name,
        'gift_card_bless_word'      => $faker->sentence,
        'gift_card_sender'          => $faker->name,
        'user_rank_id'              => 1,       //TODO need user rank model for fill back
        'rank_discount'             => 0.95,    //TODO need user rank model for fill back
        'user_points'               => 1,       //TODO need modify user model add points field for fill back
        'invoice_type'              => collect(collect(Order::INVOICE_MAP)->keys())->random(),
        'invoice_data'              => [],
        'invoice_file_url'          => $faker->url,
        'is_invoiced'               => collect([Order::IS_INVOICED, Order::NOT_INVOICED])->random(),
        'referer'                   => collect(collect(Order::REFERER_MAP)->keys())->random(),
        'utm_source'                => $faker->word,
        'utm_medium'                => $faker->word,
        'utm_campaign'              => $faker->word,
        'utm_content'               => $faker->word,
        'utm_term'                  => $faker->word,
        'latest_utm_source'         => $faker->word,
        'latest_utm_medium'         => $faker->word,
        'latest_utm_campaign'       => $faker->word,
        'latest_utm_content'        => $faker->word,
        'latest_utm_term'           => $faker->word,
    ];
});
$factory->afterCreating(Order::class, function (Order $order, Faker $faker) {
    $order->goods()->saveMany(
        factory(OrderGoods::class, 1)->make()
    );
    $order->total_quantity          = $order->goods->sum('quantity');
    $order->total_tag_amount        = $order->goods->sum('tag_amount');
    $order->total_should_pay_amount = $order->goods->sum('should_pay_amount');
    $order->total_real_pay_amount   = $order->goods->sum('real_pay_amount');
    $order->save();
});

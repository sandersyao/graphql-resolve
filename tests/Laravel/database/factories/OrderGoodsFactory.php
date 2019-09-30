<?php

/** @var Factory $factory */

use GraphQLResolve\Tests\Laravel\Models\OrderGoods;
use GraphQLResolve\Tests\Laravel\Models\Sku;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(OrderGoods::class, function (Faker $faker) {
    $sku        = Sku::query()->inRandomOrder()->first();
    $quantity   = $faker->numberBetween(1,3);
    $discount   = .95;
    return [
        'sku_id'                => $sku->id,
        'quantity'              => $quantity,
        'after_sale_quantity'   => 0,
        'after_sale_amount'     => 0,
        'tag_price'             => $sku->tag_price,
        'tag_amount'            => $sku->tag_price * $quantity,
        'should_pay_amount'     => $sku->tag_price * $quantity * $discount,
        'real_pay_amount'       => $sku->tag_price * $quantity * $discount,
    ];
});

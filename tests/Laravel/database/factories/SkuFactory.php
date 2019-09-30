<?php

/** @var Factory $factory */

use GraphQLResolve\Tests\Laravel\Models\Sku;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Sku::class, function (Faker $faker) {
    return [
        'name'                  => $faker->word,
        'sn'                    => $faker->unique()->isbn13,
        'inventory_count'       => $faker->numberBetween(0, 100),
        'inventory_count_lock'  => $faker->numberBetween(0, 100),
        'is_online'             => collect([Sku::IS_ONLINE, Sku::NOT_ONLINE])->random(),
        'sort'                  => $faker->numberBetween(0, 100),
        'description'           => $faker->sentence,
        'tag_price'             => $faker->randomFloat(2, 1000, 10000),
        'create_admin_id'       => 0,
        'update_admin_id'       => 0,
    ];
});

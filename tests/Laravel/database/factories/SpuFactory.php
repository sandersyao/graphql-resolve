<?php

/** @var Factory $factory */

use GraphQLResolve\Tests\Laravel\Models\Sku;
use GraphQLResolve\Tests\Laravel\Models\Spu;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Spu::class, function (Faker $faker) {
    return [
        'name'              => $faker->word,
        'sn'                => $faker->unique()->ean8,
        'sort'              => $faker->numberBetween(0,2147483647),
        'description'       => $faker->sentence,
        'is_online'         => collect([Spu::IS_ONLINE, Spu::NOT_ONLINE])->random(),
        'create_admin_id'   => 0,
        'update_admin_id'   => 0,
    ];
});

$factory->afterCreating(Spu::class, function (Spu $spu, Faker $faker) {
    $spu->skus()->saveMany(factory(Sku::class, $faker->numberBetween(3, 20))->make());
    // TODO fill back tag relationship sync
});

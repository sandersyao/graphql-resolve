<?php

/** @var Factory $factory */

use GraphQLResolve\Tests\Laravel\Models\TagGroup;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define( TagGroup::class, function (Faker $faker) {
    return [
        'name'              => $faker->word,
        'description'       => $faker->sentence,
        'create_admin_id'   => 0,
        'update_admin_id'   => 0,
    ];
});

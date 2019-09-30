<?php

/** @var Factory $factory */

use GraphQLResolve\Tests\Laravel\Models\Tag;
use GraphQLResolve\Tests\Laravel\Models\TagGroup;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name'              => $faker->word,
        'description'       => $faker->sentence,
        'group_id'          => TagGroup::query()->inRandomOrder()->get('id')->first()->id,
        'create_admin_id'   => 0,
        'update_admin_id'   => 0,
    ];
});

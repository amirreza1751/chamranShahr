<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {

    return [
        'x' => $faker->word,
        'y' => $faker->word,
        'title' => $faker->word,
        'brief_description' => $faker->word,
        'owner_type' => $faker->word,
        'owner_id' => $faker->word,
        'type' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

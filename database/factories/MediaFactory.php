<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Media;
use Faker\Generator as Faker;

$factory->define(Media::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'caption' => $faker->word,
        'path' => $faker->word,
        'type' => $faker->randomDigitNotNull,
        'owner_type' => $faker->word,
        'owner_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

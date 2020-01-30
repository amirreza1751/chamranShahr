<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gender;
use Faker\Generator as Faker;

$factory->define(Gender::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'english_title' => $faker->word,
        'unique_code' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

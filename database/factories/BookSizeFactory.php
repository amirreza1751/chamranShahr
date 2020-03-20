<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookSize;
use Faker\Generator as Faker;

$factory->define(BookSize::class, function (Faker $faker) {

    return [
        'size_name' => $faker->word,
        'english_size_name' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

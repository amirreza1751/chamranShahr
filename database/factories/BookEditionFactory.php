<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookEdition;
use Faker\Generator as Faker;

$factory->define(BookEdition::class, function (Faker $faker) {

    return [
        'edition' => $faker->word,
        'english_edition' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

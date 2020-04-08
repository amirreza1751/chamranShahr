<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ExternalServiceType;
use Faker\Generator as Faker;

$factory->define(ExternalServiceType::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'version' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

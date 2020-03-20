<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdType;
use Faker\Generator as Faker;

$factory->define(AdType::class, function (Faker $faker) {

    return [
        'ad_type_title' => $faker->word,
        'english_ad_type_title' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

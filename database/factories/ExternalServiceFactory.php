<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ExternalService;
use Faker\Generator as Faker;

$factory->define(ExternalService::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'english_title' => $faker->word,
        'url' => $faker->word,
        'type_id' => $faker->randomDigitNotNull,
        'content_type' => $faker->word,
        'owner_type' => $faker->word,
        'owner_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

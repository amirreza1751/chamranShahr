<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ManageLevel;
use Faker\Generator as Faker;

$factory->define(ManageLevel::class, function (Faker $faker) {

    return [
        'management_title' => $faker->word,
        'english_management_title' => $faker->word,
        'manager_title' => $faker->word,
        'english_manager_title' => $faker->word,
        'level' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ManageHistory;
use Faker\Generator as Faker;

$factory->define(ManageHistory::class, function (Faker $faker) {

    return [
        'manager_id' => $faker->randomDigitNotNull,
        'managed_type' => $faker->word,
        'managed_id' => $faker->word,
        'begin_date' => $faker->date('Y-m-d H:i:s'),
        'end_date' => $faker->date('Y-m-d H:i:s'),
        'is_active' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

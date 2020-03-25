<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ManageHierarchy;
use Faker\Generator as Faker;

$factory->define(ManageHierarchy::class, function (Faker $faker) {

    return [
        'manage_type' => $faker->word,
        'manage_id' => $faker->word,
        'managed_by_type' => $faker->word,
        'managed_by_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

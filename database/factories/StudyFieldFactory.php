<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StudyField;
use Faker\Generator as Faker;

$factory->define(StudyField::class, function (Faker $faker) {

    return [
        'unique_code' => $faker->word,
        'faculty_unique_code' => $faker->word,
        'department_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

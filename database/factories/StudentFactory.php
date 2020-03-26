<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {

    return [
        'user_id' => $faker->randomDigitNotNull,
        'study_area_unique_code' => $faker->word,
        'study_level_unique_code' => $faker->word,
        'entrance_term_unique_code' => $faker->word,
        'study_status_unique_code' => $faker->word,
        'total_average' => $faker->randomDigitNotNull,
        'is_active' => $faker->word,
        'is_guest' => $faker->word,
        'is_iranian' => $faker->word,
        'in_dormitory' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

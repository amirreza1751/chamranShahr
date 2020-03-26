<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\StudyArea;
use Faker\Generator as Faker;

$factory->define(StudyArea::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'english_title' => $faker->word,
        'unique_code' => $faker->word,
        'is_active' => $faker->word,
        'study_level_unique_code' => $faker->word,
        'study_field_unique_code' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

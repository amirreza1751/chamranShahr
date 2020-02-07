<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Term;
use Faker\Generator as Faker;

$factory->define(Term::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'unique_code' => $faker->word,
        'term_code' => $faker->word,
        'begin_date' => $faker->date('Y-m-d H:i:s'),
        'end_date' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

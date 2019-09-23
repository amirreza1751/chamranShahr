<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Notice;
use Faker\Generator as Faker;

$factory->define(Notice::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'link' => $faker->word,
        'path' => $faker->text,
        'description' => $faker->text,
        'author' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\NotificationSample;
use Faker\Generator as Faker;

$factory->define(NotificationSample::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'brief_description' => $faker->word,
        'type' => $faker->word,
        'notifier_type' => $faker->word,
        'notifier_id' => $faker->word,
        'deadline' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

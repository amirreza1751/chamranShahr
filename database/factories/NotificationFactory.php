<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Notification;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'brief_description' => $faker->word,
        'type' => $faker->word,
        'notifiable_type' => $faker->word,
        'notifiable_id' => $faker->word,
        'notifier_type' => $faker->word,
        'notifier_id' => $faker->word,
        'deadline' => $faker->date('Y-m-d H:i:s'),
        'data' => $faker->text,
        'read_at' => $faker->date('Y-m-d H:i:s'),
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ad;
use Faker\Generator as Faker;

$factory->define(Ad::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'english_title' => $faker->word,
        'ad_location' => $faker->word,
        'english_ad_location' => $faker->word,
        'advertisable_type' => $faker->word,
        'advertisable_id' => $faker->word,
        'offered_price' => $faker->word,
        'phone_number' => $faker->word,
        'description' => $faker->text,
        'is_verified' => $faker->word,
        'is_special' => $faker->word,
        'category_id' => $faker->randomDigitNotNull,
        'ad_type_id' => $faker->randomDigitNotNull,
        'creator_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

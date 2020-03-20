<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'edition_id' => $faker->randomDigitNotNull,
        'publisher' => $faker->word,
        'publication_date' => $faker->date('Y-m-d H:i:s'),
        'book_length' => $faker->randomDigitNotNull,
        'language_id' => $faker->randomDigitNotNull,
        'isbn' => $faker->word,
        'author' => $faker->word,
        'translator' => $faker->word,
        'price' => $faker->word,
        'size_id' => $faker->randomDigitNotNull,
        'is_grayscale' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});

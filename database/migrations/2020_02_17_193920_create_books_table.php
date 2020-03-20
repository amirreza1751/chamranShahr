<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
//            $table->string('edition');
            $table->unsignedInteger('edition_id');
            $table->string('publisher');
            $table->dateTime('publication_date');
            $table->unsignedInteger('book_length'); /** number of pages */
//            $table->string('language');
            $table->unsignedInteger('language_id');
            $table->string('isbn');
            $table->string('author');
            $table->string('translator');
            $table->string('price');
//            $table->string('size');
            $table->unsignedInteger('size_id');
            $table->boolean('is_grayscale');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('books', function(Blueprint $table){
            $table->foreign('edition_id')->references('id')->on('book_editions');
            $table->foreign('language_id')->references('id')->on('book_languages');
            $table->foreign('size_id')->references('id')->on('book_sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}

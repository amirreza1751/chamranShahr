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
            $table->unsignedInteger('edition_id')->nullable();
            $table->string('publisher')->nullable();
            $table->date('publish_date')->nullable();
            $table->unsignedInteger('book_length')->nullable(); /** number of pages */
//            $table->string('language');
            $table->unsignedInteger('language_id')->nullable();
            $table->string('isbn')->nullable();
            $table->string('author')->nullable();
            $table->string('translator')->nullable();
            $table->string('price')->nullable();
//            $table->string('size');
            $table->unsignedInteger('size_id')->nullable();
            $table->boolean('is_grayscale')->nullable();
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

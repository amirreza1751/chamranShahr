<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->date('publication_date')->change();
            $table->renameColumn('publication_date', 'publish_date');
            $table->unsignedInteger('book_length')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedInteger('book_length')->change();
            $table->renameColumn('publish_date', 'publication_date');
            $table->dateTime('publish_date')->change();
        });
    }
}

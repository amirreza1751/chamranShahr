<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notices', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id');
            $table->morphs('owner');

            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notices', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['creator_id']);
            // Drop the columns
            $table->dropColumn('creator_id');
            $table->dropMorphs('owner');
        });
    }
}

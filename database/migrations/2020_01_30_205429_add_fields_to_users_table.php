<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender_unique_code')->default('gender0');
//            $table->string('gender_unique_code')->nullable();
            $table->foreign('gender_unique_code')->references('unique_code')->on('genders');

            $table->string('scu_id_to_update')->nullable();
            $table->string('national_id_to_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['gender_unique_code']);
            // Drop the column
            $table->dropColumn('gender_unique_code');

            // Drop the column
            $table->dropColumn('scu_id_to_update');
            // Drop the column
            $table->dropColumn('national_id_to_update');
        });
    }
}

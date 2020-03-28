<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->string('study_area_unique_code')->index(); // SAMA identifier of Course Study [ such as Software Engineering : 500 ]
            $table->string('study_level_unique_code')->index(); // SAMA identifier of Study Level [ such as Bachelor : 2 ]
            $table->string('entrance_term_unique_code')->index(); // SAMA identifier of Term [ such as 921 : 128 ]
            $table->string('study_status_unique_code')->index(); // SAMA identifier of Student Status [ such as Graduated : 2 ]
            $table->double('total_average')->nullable();
            $table->boolean('is_active'); // ~ isGraduated
            $table->boolean('is_guest');
            $table->boolean('is_iranian')->default(true);
            $table->boolean('in_dormitory')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('study_area_unique_code')->references('unique_code')->on('study_areas');
            $table->foreign('study_level_unique_code')->references('unique_code')->on('study_levels');
            $table->foreign('entrance_term_unique_code')->references('unique_code')->on('terms');
            $table->foreign('study_status_unique_code')->references('unique_code')->on('study_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}

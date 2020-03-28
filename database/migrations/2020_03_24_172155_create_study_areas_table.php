<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('english_title')->nullable();
            $table->string('unique_code')->index();
            $table->boolean('is_active');
            $table->string('study_level_unique_code')->index();
            $table->string('study_field_unique_code')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('study_level_unique_code')->references('unique_code')->on('study_levels');
            $table->foreign('study_field_unique_code')->references('unique_code')->on('study_fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_areas');
    }
}

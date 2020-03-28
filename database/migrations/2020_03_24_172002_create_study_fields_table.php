<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_code')->index();
            $table->string('faculty_unique_code')->index();
            $table->unsignedInteger('department_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('faculty_unique_code')->references('unique_code')->on('faculties');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_fields');
    }
}

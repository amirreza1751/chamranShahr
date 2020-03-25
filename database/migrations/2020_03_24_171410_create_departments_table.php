<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('english_title')->nullable();
            $table->text('description')->nullable();
            $table->string('path')->nullable();
            $table->unsignedInteger('manage_level_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('manage_level_id')->references('id')->on('manage_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}

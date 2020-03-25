<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('management_title');
            $table->string('english_management_title')->nullable();
            $table->string('manager_title');
            $table->string('english_manager_title')->nullable();
            $table->float('level');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_levels');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manages_history', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('manager_id');
            $table->morphs('managed');
            $table->dateTime('begin_date');
            $table->dateTime('end_date')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('manager_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manages_history');
    }
}

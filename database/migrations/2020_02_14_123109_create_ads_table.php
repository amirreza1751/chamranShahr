<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 200);
            $table->string('english_title', 200)->nullable();
            $table->string('ad_location')->nullable();
            $table->string('english_ad_location')->nullable();
            $table->morphs('advertisable');
            $table->string('offered_price');
            $table->string('phone_number');
            $table->text('description')->nullable();
            $table ->boolean('is_verified')->default(0);
            $table ->boolean('is_special')->default(0);
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('ad_type_id');
            $table->unsignedBigInteger('creator_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('ads', function(Blueprint $table){
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('ad_type_id')->references('id')->on('ad_types');
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
        Schema::dropIfExists('ads');
    }
}

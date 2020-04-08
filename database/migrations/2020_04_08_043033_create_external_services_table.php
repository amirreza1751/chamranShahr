<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('english_title')->nullable();
            $table->string('url', 400);

            /** this service which type will be;
             * for example: xml, web service or api */
            $table->unsignedInteger('type_id')->nullable();

            /** which Model information will retrieve and synchronize from this service;
             * for example: App\Models\Notice */
            $table->string('content_type');

            /** ;
             * for example: owner_type => App\Models\Notice, owner_id => 1 */
            $table->morphs('owner'); // which entity records will synchronize with retrieved information
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('type_id')->references('id')->on('external_service_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_services');
    }
}

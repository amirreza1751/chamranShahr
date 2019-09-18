<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('birthday')->nullable();
            $table->string('username')->unique();
            $table->string('scu_id')->unique()->nullable();
            $table->string('phone_number')->unique();
            $table->string('account')->unique()->nullable();
            $table->string('national_id')->unique()->nullable();
            $table->timestamp('last_login')->nullable();
            $table->integer('status')->nullable();  //  Enum : Status
            $table->double('cash')->default(0);
            $table->bigInteger('reputation')->default(0);
            $table->bigInteger('rebellious')->default(0);
            $table->unsignedInteger('level_id')->default(10);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar_path', 250)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::table('users', function($table) {
            $table->foreign('level_id')->references('id')->on('user_levels')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up():void
    {
        Schema::create('users', function (Blueprint $table) {


            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->text('password');
            $table->string('phone')->nullable();
            $table->string('google_id')->nullable();
            // $table->enum('service_type', ['whatsapp', 'email','admin'])->default('whatsapp');
            $table->unsignedBigInteger('region_id')->default(1);
            $table->string('utype')->default('USR')->comment('ADM For Admin and USR For User or Customer');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');

        });
         // Apply indexes
         Schema::table('users', function (Blueprint $table) {
            $table->index('region_id');
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

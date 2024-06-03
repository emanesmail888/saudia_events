<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_regions', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        // Apply indexes
        Schema::table('user_regions', function (Blueprint $table) {
            $table->index('region_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_regions');
    }
}

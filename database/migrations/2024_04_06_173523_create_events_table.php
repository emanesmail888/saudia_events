<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up():void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->text('event_image')->nullable();
            $table->text('event_details');
            $table->string('event_start_price')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('location')->nullable();
            $table->string('url')->nullable();
            $table->text('conditions')->nullable();
            $table->string('organizedBy')->nullable();
            $table->string('zone_late')->nullable();
            $table->string('zone_long')->nullable();
            $table->string('event_type')->nullable();
            $table->string('duration')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete(('cascade'));
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete(('cascade'));
            $table->foreign('region_id')->references('id')->on('regions')->onDelete(('cascade'));
            $table->foreign('city_id')->references('id')->on('cities')->onDelete(('cascade'));

        });

         // Apply indexes
         Schema::table('events', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('subcategory_id');
            $table->index('region_id');
            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}

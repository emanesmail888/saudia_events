<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supscriptions', function (Blueprint $table) {
            // $table->id();
            $table->string('payment_id')->primary();
            $table->string('registrationId');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->datetime('starts_at');
            $table->datetime('ends_at');
            $table->decimal('total');
            $table->decimal('amount');
            $table->string('checkout_id');
            $table->string('payment_status');
            $table->string('paymentType');
            $table->string('currency');
            $table->string('descriptor');
            $table->string('recurringType')->nullable();
            $table->string('code');
            $table->string('description');
            $table->string('clearingInstituteName');
            $table->string('bin')->nullable();
            $table->string('lastDigits')->nullable();
            $table->string('holder')->nullable();
            $table->string('expiryMonth')->nullable();
            $table->string('expiryYear')->nullable();
            $table->string('bank')->nullable();
            $table->string('type')->nullable();
            $table->string('level')->nullable();
            $table->string('country')->nullable();
            $table->string('maxPanLength')->nullable();
            $table->string('binType')->nullable();
            $table->string('regulatedFlag')->nullable();
            $table->string('ip')->nullable();
            $table->string('ipCountry')->nullable();
            $table->text('value')->nullable();
            $table->string('eci')->nullable();
            $table->string('SHOPPER_EndToEndIdentity')->nullable();
            $table->string('CTPE_DESCRIPTOR_TEMPLATE')->nullable();
            $table->string('score');
            $table->string('buildNumber');
            $table->string('timestamp');
            $table->string('ndc');
            $table->json('data')->nullable();
            $table->json('trackable_data');
            $table->string('standingInstruction_source');
            $table->string('standingInstruction_type');
            $table->string('standingInstruction_mode');
            $table->string('brand')->nullable();
            $table->enum('status', ['active', 'cancelled', 'expired','inactive'])->default('inactive');
           

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });

         // Apply indexes
         Schema::table('supscriptions', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supscriptions');
    }
}

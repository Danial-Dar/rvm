<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sw_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('friendly_name', 25)->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->string('area_code', 25)->nullable()->index();
            $table->string('resource_id', 1000)->nullable();
            $table->string('rate_center', 50)->nullable();
            $table->string('region', 25)->nullable();
            $table->string('iso_country', 25)->nullable();
            $table->string('capabilities', 250)->nullable();
            $table->timestamps();
            $table->text('purchase_response')->nullable();
            $table->string('purchase_response_id')->nullable();
            $table->string('status')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->integer('number_of_calls')->default(0);

            $table->index(['area_code', 'phone_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sw_numbers');
    }
};

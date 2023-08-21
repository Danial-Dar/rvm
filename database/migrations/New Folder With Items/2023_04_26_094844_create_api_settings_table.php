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
        Schema::create('api_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('end_point');
            $table->text('carrier_address');
            $table->timestamps();
            $table->string('prefix')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('call_price', 8, 3)->nullable();
            $table->string('transfer_dest')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_settings');
    }
};

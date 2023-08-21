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
        Schema::create('ivr_incoming_call_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('campaign_contact_id')->nullable();
            $table->text('from_number')->nullable();
            $table->text('to_number')->nullable();
            $table->text('disposition')->nullable();
            $table->timestamps();
            $table->text('area_code')->nullable();
            $table->text('location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ivr_incoming_call_logs');
    }
};

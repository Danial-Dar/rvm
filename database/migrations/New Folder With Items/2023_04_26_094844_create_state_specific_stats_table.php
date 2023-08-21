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
        Schema::create('state_specific_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('area_code');
            $table->string('location_code');
            $table->string('incoming_call_log_count');
            $table->string('ivr_call_log_count');
            $table->string('campaign_contact_count');
            $table->string('dnc_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_specific_stats');
    }
};

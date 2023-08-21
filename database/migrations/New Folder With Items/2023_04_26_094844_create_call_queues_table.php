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
        Schema::create('call_queues', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('redis_key_id')->nullable();
            $table->bigInteger('campaign_id')->nullable();
            $table->timestamp('initiate_at')->nullable();
            $table->bigInteger('chunk_count')->nullable();
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
        Schema::dropIfExists('call_queues');
    }
};

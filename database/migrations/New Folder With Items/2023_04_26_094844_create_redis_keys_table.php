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
        Schema::create('redis_keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->nullable();
            $table->string('process_identifier')->nullable();
            $table->timestamps();
            $table->bigInteger('campaign_id')->nullable();
            $table->bigInteger('last_campaign_contact_id')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->bigInteger('chunk_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redis_keys');
    }
};

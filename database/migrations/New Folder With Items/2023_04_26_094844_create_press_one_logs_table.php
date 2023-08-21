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
        Schema::create('press_one_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('campaign_contact_id')->nullable()->comment('transaction_id');
            $table->string('number')->nullable();
            $table->string('raw_number')->nullable();
            $table->integer('keypress')->nullable();
            $table->boolean('is_opt_in')->nullable();
            $table->text('request_data')->nullable();
            $table->text('response_data')->nullable();
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
        Schema::dropIfExists('press_one_logs');
    }
};

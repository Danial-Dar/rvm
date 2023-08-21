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
        Schema::create('balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->text('description')->nullable();
            $table->integer('start_id')->nullable();
            $table->integer('end_id')->nullable();
            $table->timestamps();
            $table->decimal('amount');
            $table->string('minutes')->nullable();
            $table->enum('type', ['PAYMENT', 'RVM', 'BOT', 'PRESS-1', 'PHONE', 'INCOMING', 'CALLER_ID_REPUTATION', 'INBOUND_SMS', 'MONTHLY_CHARGE', 'OUT_BOUND_SMS', 'SMS_CAMPAIGN'])->default('RVM');
            $table->float('quantity', 0, 0)->default(0);
            $table->enum('main_type', ['VOICE', 'INCOMING', 'PHONE', 'SMS'])->default('VOICE');
            $table->integer('campaign_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
    }
};

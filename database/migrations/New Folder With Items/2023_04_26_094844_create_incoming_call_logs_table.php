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
        Schema::create('incoming_call_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CallSid')->nullable()->index('incoming_call_logs_CallSid_index');
            $table->string('AccountSid')->nullable()->index('incoming_call_logs_AccountSid_index');
            $table->string('From', 200)->nullable();
            $table->string('To', 200)->nullable();
            $table->string('Called', 30)->nullable();
            $table->string('CallStatus', 25)->nullable();
            $table->string('ApiVersion', 25)->nullable();
            $table->string('Direction', 25)->nullable();
            $table->bigInteger('campaign_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('campaign_contact_id')->nullable();
            $table->string('response', 1000)->nullable();
            $table->timestamps();
            $table->integer('duration')->nullable();
            $table->decimal('sw_call_price', 8, 3)->nullable();
            $table->decimal('unit_price', 8, 3)->nullable();
            $table->decimal('call_price', 8, 3)->nullable();
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->string('forward_to', 30)->nullable();
            $table->string('duration_human')->nullable();
            $table->string('area_code')->nullable();
            $table->string('location')->nullable();
            $table->text('type')->nullable();
            $table->boolean('is_billed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incoming_call_logs');
    }
};

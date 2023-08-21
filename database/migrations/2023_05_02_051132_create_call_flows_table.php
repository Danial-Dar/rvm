<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_flows', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('calls')->nullable();
            $table->boolean('record_calls')->default(false);
            $table->string('recording_disclaimer')->nullable();
            $table->boolean('forward_sms_messages')->default(false);
            $table->string('forward_sms_email')->nullable();
            $table->boolean('whisper_message')->default(false);
            $table->string('call_whisper_text')->nullable();
            $table->boolean('send_missed_call_notification')->default(false);
            $table->string('send_missed_call_email')->nullable();
            $table->string('send_missed_call_notification_message')->nullable();
            $table->boolean('send_missed_call_notification_include_caller_number')->default(false);
            $table->boolean('email_call_details')->default(false);
            $table->boolean('include_link_call_recording')->default(false);
            $table->boolean('send_email_call_duration')->default(false);
            $table->string('email_notification_recipients')->nullable();
            $table->boolean('press_1_to_connect')->default(false);
            $table->string('text_to_speech')->nullable();
            $table->string('mp3_file_path')->nullable();
            $table->boolean('tracking_number_caller_id')->default(false);
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
        Schema::dropIfExists('call_flows');
    }
}

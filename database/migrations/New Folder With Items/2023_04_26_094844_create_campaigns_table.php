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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('caller_id');
            $table->integer('recording_id')->nullable();
            $table->string('contact_list_id')->nullable();
            $table->bigInteger('user_id');
            $table->string('start_date');
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('alpha_number')->nullable();
            $table->string('drops_per_hour')->nullable();
            $table->text('jobs')->nullable();
            $table->string('campaign_type')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->integer('bot_id')->nullable();
            $table->string('transfer_to_number')->nullable();
            $table->string('opt_in_number')->nullable();
            $table->string('opt_out_number')->nullable();
            $table->bigInteger('recording_output_id')->nullable();
            $table->string('caller_filename')->nullable();
            $table->string('alpha_filename')->nullable();
            $table->string('random')->nullable();
            $table->boolean('is_random')->default(false);
            $table->string('ci_forward_number')->nullable();
            $table->string('raw_ci_forward_number')->nullable();
            $table->string('vm_forward_number')->nullable();
            $table->string('raw_vm_forward_number')->nullable();
            $table->bigInteger('recording_optin_id')->nullable();
            $table->string('raw_transfer_to_number')->nullable();
            $table->integer('reset_count')->nullable();
            $table->bigInteger('optout_recording_id')->nullable();
            $table->bigInteger('voicemail_id')->nullable();
            $table->string('transfer_to')->nullable();
            $table->text('run_type')->nullable()->default('success');
            $table->bigInteger('voice_mail_recording_id')->nullable();
            $table->boolean('voice_mail_enabled')->default(false);
            $table->integer('team_id')->nullable();
            $table->integer('campaign_script_id')->nullable();
            $table->integer('lead_list_id')->nullable();
            $table->integer('dial_speed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaigns');
    }
};

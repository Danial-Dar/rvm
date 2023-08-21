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
        Schema::create('sms_campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('company_id');
            $table->string('caller_id')->nullable();
            $table->string('campaign_type')->nullable();
            $table->string('campaign_name')->nullable();
            $table->string('forward_to_sms_number')->nullable();
            $table->string('raw_forward_to_sms_number')->nullable();
            $table->string('domain_url')->nullable();
            $table->string('sms_contact_list_id')->nullable();
            $table->text('message')->nullable();
            $table->boolean('allow_long_message')->nullable()->default(false);
            $table->string('character_count')->nullable();
            $table->text('variations')->nullable();
            $table->string('start_date')->nullable();
            $table->string('status')->nullable();
            $table->string('jobs')->nullable();
            $table->integer('reset_count')->nullable();
            $table->string('receive_response')->nullable();
            $table->string('drops_per_hour')->nullable();
            $table->timestamps();
            $table->string('sw_campaign_id')->nullable();
            $table->string('sms_use_case')->nullable();
            $table->text('description')->nullable();
            $table->text('message_two')->nullable();
            $table->text('message_flow')->nullable();
            $table->text('opt_in_message')->nullable();
            $table->text('opt_out_message')->nullable();
            $table->text('help_message')->nullable();
            $table->string('number_pooling_per_campaign')->nullable();
            $table->boolean('direct_lending')->default(false);
            $table->boolean('embedded_link')->default(false);
            $table->boolean('embedded_phone')->default(false);
            $table->boolean('age_gated_content')->default(false);
            $table->boolean('lead_generation')->default(false);
            $table->boolean('terms_and_conditions')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_campaigns');
    }
};

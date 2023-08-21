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
        Schema::create('my_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('number');
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->bigInteger('company_id')->nullable();
            $table->string('type')->nullable();
            $table->string('raw_number')->nullable();
            $table->string('forward_to_number')->nullable();
            $table->string('raw_forward_to_number')->nullable();
            $table->text('purchase_response')->nullable();
            $table->string('purchase_response_id')->nullable();
            $table->boolean('is_group')->default(false);
            $table->string('tags')->nullable();
            $table->boolean('ivr_enabled')->nullable()->default(false);
            $table->integer('recording_id')->nullable();
            $table->string('continue_digit')->nullable();
            $table->string('optout_digit')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('opt_in_number')->nullable();
            $table->integer('opt_in_digit')->nullable();
            $table->integer('opt_out_digit')->nullable();
            $table->boolean('dnc_on_ivr')->default(false);
            $table->string('number_type')->nullable();
            $table->string('sip_endpoint')->nullable();
            $table->string('platform')->default('call_48');
            $table->string('sw_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_numbers');
    }
};

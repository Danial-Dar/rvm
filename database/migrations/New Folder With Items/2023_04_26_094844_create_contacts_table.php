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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->index();
            $table->bigInteger('contact_list_id')->index();
            $table->timestamps();
            $table->string('status')->nullable();
            $table->string('raw_number')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('additional1')->nullable();
            $table->string('additional2')->nullable();
            $table->string('additional3')->nullable();
            $table->string('robokiller_status')->nullable();
            $table->json('robokiller_response')->nullable();
            $table->string('nomorobo_status')->nullable();
            $table->json('nomorobo_response')->nullable();
            $table->string('ftc_status')->nullable();
            $table->json('ftc_response')->nullable();
            $table->string('internal_flag')->default('N');
            $table->float('reputation_score', 0, 0)->default(0);
            $table->boolean('reputation_checked')->default(false);
            $table->boolean('is_repute_billed')->default(false);
            $table->date('reputation_date')->nullable();
            $table->string('type')->nullable();
            $table->string('cir_state')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};

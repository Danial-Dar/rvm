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
        Schema::create('reputation_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('contact_list_id')->nullable();
            $table->string('cir_state')->nullable();
            $table->string('number')->nullable();
            $table->string('raw_number')->nullable();
            $table->string('robokiller_status')->nullable();
            $table->json('robokiller_response')->nullable();
            $table->string('nomorobo_status')->nullable();
            $table->json('nomorobo_response')->nullable();
            $table->string('ftc_status')->nullable();
            $table->json('ftc_response')->nullable();
            $table->string('internal_flag')->default('N');
            $table->float('reputation_score', 0, 0)->default(0);
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
        Schema::dropIfExists('reputation_histories');
    }
};

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
        Schema::create('qa_phrase', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('title');
            $table->integer('min_count');
            $table->string('speaker');
            $table->string('flag_type');
            $table->boolean('is_reviewable')->default(false);
            $table->boolean('is_non_scrolable')->default(false);
            $table->boolean('is_force_review')->default(false);
            $table->string('first_x');
            $table->string('last_x');
            $table->string('time');
            $table->timestamps();
            $table->integer('scorecard_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qa_phrase');
    }
};

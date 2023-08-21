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
        Schema::create('qa_audio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('agent_id');
            $table->string('status')->default('pending');
            $table->string('filename')->nullable();
            $table->integer('length')->nullable();
            $table->string('job')->default('pending');
            $table->timestamps();
            $table->text('json_data')->nullable();
            $table->json('banned')->nullable();
            $table->json('req_found')->nullable();
            $table->json('req_not_found')->nullable();
            $table->json('context')->nullable();
            $table->integer('banned_count')->nullable();
            $table->integer('req_found_count')->nullable();
            $table->integer('req_not_found_count')->nullable();
            $table->integer('context_count')->nullable();
            $table->integer('silence')->nullable();
            $table->float('score', 0, 0)->nullable();
            $table->string('reviewer')->nullable();
            $table->boolean('valid')->default(false);
            $table->boolean('bad_calls')->default(false);
            $table->string('phone_number')->nullable();
            $table->boolean('is_reviewed')->default(false);
            $table->integer('scorecard_id')->nullable();
            $table->json('positive')->nullable();
            $table->integer('positive_count')->nullable();
            $table->json('negative')->nullable();
            $table->integer('negative_count')->nullable();
            $table->json('nsfw')->nullable();
            $table->integer('nsfw_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qa_audio');
    }
};

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
        Schema::create('contact_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->bigInteger('user_id');
            $table->string('path');
            $table->integer('total_contacts');
            $table->softDeletes();
            $table->timestamps();
            $table->string('filename')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->text('jobs')->nullable();
            $table->string('job_status')->nullable();
            $table->integer('success')->nullable();
            $table->integer('failed')->nullable();
            $table->string('selected_phone_column')->nullable();
            $table->enum('reputation_check_status', ['inprocess', 'complete', 'failed', 'unchecked'])->default('unchecked');
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_lists');
    }
};

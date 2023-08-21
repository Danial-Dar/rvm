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
        Schema::create('agent_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from_number', 16)->nullable();
            $table->string('to_number', 16)->nullable();
            $table->string('duration')->nullable()->default('0');
            $table->string('time')->nullable()->default('0');
            $table->text('description')->nullable();
            $table->string('date')->nullable();
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
        Schema::dropIfExists('agent_logs');
    }
};

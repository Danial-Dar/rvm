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
        Schema::create('internal_app_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->string('raw_number');
            $table->string('name');
            $table->string('status');
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
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
        Schema::dropIfExists('internal_app_numbers');
    }
};

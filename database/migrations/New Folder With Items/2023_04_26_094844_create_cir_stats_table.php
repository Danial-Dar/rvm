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
        Schema::create('cir_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->integer('number_monitored')->nullable();
            $table->integer('number_good')->nullable();
            $table->integer('number_fair')->nullable();
            $table->integer('number_bad')->nullable();
            $table->integer('number_terible')->nullable();
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
        Schema::dropIfExists('cir_stats');
    }
};

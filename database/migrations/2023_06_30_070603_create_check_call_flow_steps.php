<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckCallFlowStep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_call_flow_steps', function (Blueprint $table) {
            $table->id();
            $table->integer('call_flow_id')->index();
            $table->integer('step')->index();
            $table->string('to_number');
            $table->string('from_number');
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
        Schema::dropIfExists('check_call_flow_step');
    }
}

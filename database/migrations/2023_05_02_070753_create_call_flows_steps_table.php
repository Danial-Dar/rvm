<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallFlowsStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_flows_steps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('call_flow_id');
            $table->integer('step');
            $table->string('call_flow_type');
            $table->json('call_flow_type_fields');
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
        Schema::dropIfExists('call_flows_steps');
    }
}

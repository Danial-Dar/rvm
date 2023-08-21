<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallFlowsHasNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_flows_has_numbers', function (Blueprint $table) {
            $table->integer('call_flow_id')->unsigned();

            $table->integer('call_flow_number_id')->unsigned();

            $table->foreign('call_flow_id')->references('id')->on('call_flows')->onDelete('cascade');

            $table->foreign('call_flow_number_id')->references('id')->on('call_flow_numbers')->onDelete('cascade');});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_flows_has_numbers');
    }
}

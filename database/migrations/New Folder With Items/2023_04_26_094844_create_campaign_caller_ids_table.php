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
        Schema::create('campaign_caller_ids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('campaign_id');
            $table->bigInteger('my_number_id');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->string('type')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->boolean('is_group')->default(false);
            $table->string('group_id')->nullable();
            $table->string('caller_number_type')->nullable();
            $table->string('alpha_number_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_caller_ids');
    }
};

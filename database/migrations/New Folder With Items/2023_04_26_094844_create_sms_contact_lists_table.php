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
        Schema::create('sms_contact_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->string('total_contacts')->nullable();
            $table->string('filename')->nullable();
            $table->string('status');
            $table->string('success')->nullable();
            $table->string('failed')->nullable();
            $table->text('jobs')->nullable();
            $table->string('job_status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_contact_lists');
    }
};

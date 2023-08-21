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
        Schema::create('dnc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->string('user_type')->nullable();
            $table->string('raw_number')->nullable()->index('index_raw_number');
            $table->bigInteger('company_id')->nullable();
            $table->string('dnc_type', 25)->nullable();
            $table->string('upload_type')->nullable()->default('CSV Upload');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dnc');
    }
};

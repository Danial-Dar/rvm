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
        Schema::create('press1_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ddi', 30);
            $table->string('cli', 30);
            $table->string('status', 30);
            $table->string('tid', 60)->nullable();
            $table->timestamp('date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('press1_status');
    }
};

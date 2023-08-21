<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLergTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lerg', function (Blueprint $table) {
            $table->id();
            $table->string('NPA');
            $table->string('NXX');
            $table->string('Block');
            $table->string('LATA');
            $table->string('OCN');
            $table->string('Ratecenter');
            $table->string('State');
            $table->string('category');
            $table->string('Company_Name');
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
        Schema::dropIfExists('lerg');
    }
}

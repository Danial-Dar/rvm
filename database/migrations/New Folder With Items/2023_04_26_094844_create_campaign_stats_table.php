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
        Schema::create('campaign_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('campaign_id')->nullable()->index();
            $table->integer('contact_count')->nullable();
            $table->integer('sent_count')->nullable();
            $table->integer('initiated_count')->nullable();
            $table->integer('success_count')->nullable();
            $table->integer('failed_count')->nullable();
            $table->integer('optin_count')->nullable();
            $table->integer('optout_count')->nullable();
            $table->integer('price_sum')->nullable();
            $table->timestamp('last_ran')->nullable();
            $table->timestamps();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->integer('dnc_count')->nullable();
            $table->decimal('total_amount', 9)->nullable();
            $table->decimal('pending_amount', 9)->nullable();
            $table->integer('prev_price_sum')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_stats');
    }
};

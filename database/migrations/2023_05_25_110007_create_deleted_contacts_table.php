<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->index();
            $table->bigInteger('campaign_id');
            $table->bigInteger('contact_list_id');
            $table->string('status');
            $table->timestamp('created_at')->nullable()->index();
            $table->timestamp('updated_at')->nullable();
            $table->bigInteger('user_id')->nullable()->index();
            $table->bigInteger('company_id')->nullable();
            $table->decimal('price', 8, 3)->nullable();
            $table->boolean('is_processing')->default(false);
            $table->string('caller_id_number')->nullable()->index();
            $table->string('alpha_number')->nullable()->index();
            $table->string('ci_forward_number')->nullable();
            $table->string('random_number')->nullable();
            $table->boolean('is_random')->nullable()->default(false);
            $table->string('vm_forward_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deleted_contacts');
    }
}

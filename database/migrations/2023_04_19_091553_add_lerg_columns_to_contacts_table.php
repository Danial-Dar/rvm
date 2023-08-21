<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLergColumnsToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('lerg_rate_center')->nullable();
            $table->string('lerg_state')->nullable();
            $table->string('lerg_category')->nullable();
            $table->string('lerg_company_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('lerg_rate_center');
            $table->dropColumn('lerg_state');
            $table->dropColumn('lerg_category');
            $table->dropColumn('lerg_company_name');
        });
    }
}

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
        Schema::table('phrase_has_components', function (Blueprint $table) {
            $table->foreign(['component_id'], 'phrase_has_components_component_id_fkey')->references(['id'])->on('qa_components')->onDelete('CASCADE');
            $table->foreign(['phrase_id'], 'phrase_has_components_phrase_id_fkey')->references(['id'])->on('qa_phrase')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('phrase_has_components', function (Blueprint $table) {
            $table->dropForeign('phrase_has_components_component_id_fkey');
            $table->dropForeign('phrase_has_components_phrase_id_fkey');
        });
    }
};

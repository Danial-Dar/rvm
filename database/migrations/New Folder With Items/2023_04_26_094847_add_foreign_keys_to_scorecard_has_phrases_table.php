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
        Schema::table('scorecard_has_phrases', function (Blueprint $table) {
            $table->foreign(['phrase_id'], 'scorecard_has_phrases_phrase_id_fkey')->references(['id'])->on('qa_phrase')->onDelete('CASCADE');
            $table->foreign(['scorecard_id'], 'scorecard_has_phrases_scorecard_id_fkey')->references(['id'])->on('scorecards')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scorecard_has_phrases', function (Blueprint $table) {
            $table->dropForeign('scorecard_has_phrases_phrase_id_fkey');
            $table->dropForeign('scorecard_has_phrases_scorecard_id_fkey');
        });
    }
};

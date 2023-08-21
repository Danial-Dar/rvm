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
        Schema::table('call_has_notes', function (Blueprint $table) {
            $table->foreign(['audio_id'], 'call_has_notes_audio_id_fkey')->references(['id'])->on('qa_audio')->onDelete('CASCADE');
            $table->foreign(['note_id'], 'call_has_notes_note_id_fkey')->references(['id'])->on('qa_notes')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('call_has_notes', function (Blueprint $table) {
            $table->dropForeign('call_has_notes_audio_id_fkey');
            $table->dropForeign('call_has_notes_note_id_fkey');
        });
    }
};

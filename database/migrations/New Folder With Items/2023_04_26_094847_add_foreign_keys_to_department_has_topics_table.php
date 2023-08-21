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
        Schema::table('department_has_topics', function (Blueprint $table) {
            $table->foreign(['department_id'], 'department_has_topics_department_id_fkey')->references(['id'])->on('qa_departments')->onDelete('CASCADE');
            $table->foreign(['topic_id'], 'department_has_topics_topic_id_fkey')->references(['id'])->on('qa_topics')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('department_has_topics', function (Blueprint $table) {
            $table->dropForeign('department_has_topics_department_id_fkey');
            $table->dropForeign('department_has_topics_topic_id_fkey');
        });
    }
};

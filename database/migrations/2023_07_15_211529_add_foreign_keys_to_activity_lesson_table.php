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
        Schema::table('activity_lesson', function (Blueprint $table) {
            $table->foreign(['activity_id'], 'activity_lesson_ibfk_1')->references(['id'])->on('activities')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign(['lesson_id'], 'activity_lesson_ibfk_2')->references(['id'])->on('lessons')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity_lesson', function (Blueprint $table) {
            $table->dropForeign('activity_lesson_ibfk_1');
            $table->dropForeign('activity_lesson_ibfk_2');
        });
    }
};

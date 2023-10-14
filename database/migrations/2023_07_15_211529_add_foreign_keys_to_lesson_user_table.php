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
        Schema::table('lesson_user', function (Blueprint $table) {
            $table->foreign(['lesson_id'], 'lesson_user_ibfk_1')->references(['id'])->on('lessons')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign(['user_id'], 'lesson_user_ibfk_2')->references(['id'])->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lesson_user', function (Blueprint $table) {
            $table->dropForeign('lesson_user_ibfk_1');
            $table->dropForeign('lesson_user_ibfk_2');
        });
    }
};

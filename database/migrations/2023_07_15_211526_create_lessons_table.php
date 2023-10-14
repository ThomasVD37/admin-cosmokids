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
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id')->comment('id de l’utilisateur');
            $table->string('title', 128)->comment('titre du cours');
            $table->string('slug', 128)->unique('slug')->comment('slug du cours');
            $table->text('content')->comment('contenu du cours');
            $table->string('image', 128)->comment('url ou slug de l’image');
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
        Schema::dropIfExists('lessons');
    }
};

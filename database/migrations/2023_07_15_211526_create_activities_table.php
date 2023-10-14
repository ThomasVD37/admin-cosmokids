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
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id')->comment('id de l’activité');
            $table->string('title', 128)->comment('titre de l’activité');
            $table->string('slug', 128)->unique('slug')->comment('slug de l’activité');
            $table->string('image')->comment('image pour les liens des cours');
            $table->text('description')->comment('description de l’activité');
            $table->text('rules')->comment('règle de l’activité');
            $table->unsignedSmallInteger('duration')->comment('La durée de l’activité (en seconde)');
            $table->timestamps();
            $table->unsignedInteger('type_id')->index('type_id')->comment('Relation avec la table type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};

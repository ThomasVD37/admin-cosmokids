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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('id de l’utilisateur');
            $table->string('email', 128)->unique('email')->comment('email de l’utilisateur');
            $table->string('password')->comment('mot de passe de l’utilisateur');
            $table->string('pseudo', 64)->unique('pseudo')->comment('pseudo de l’utilisateur');
            $table->string('profile_image', 128)->nullable()->comment('url ou slug de l’image (facultatif)');
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
        Schema::dropIfExists('users');
    }
};

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
            $table->increments('id');
            $table->string('name', 128)->nullable();;
            $table->string('pseudo', 64)->unique('pseudo');
            $table->string('email', 128)->unique('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('profile_image', 128)->nullable()->comment('url ou slug de l’image (facultatif)');
            $table->rememberToken();
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

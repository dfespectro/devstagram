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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('imagen');
            //->constrained()->onDelete('cascade') si se elimina el usuarion con esa id eliminara todo en esta tabla tambien
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); //esta es una convencion y laravel detecta de inmediato con quien se relaciona en este caso
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
        Schema::dropIfExists('posts');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gusto_preferencia_users', function (Blueprint $table) {
            $table->id('id_gusto_preferencia_users');
            $table->unsignedBigInteger('id_usuario');
            $table->string('plato_postre',200)->nullable();
            $table->string('galletas_golosinas',200)->nullable();
            $table->string('ocio_pasatiempos',200)->nullable();
            $table->string('artistas_banda',200)->nullable();
            $table->string('genero_musical',200)->nullable();
            $table->string('pelicula_serie',200)->nullable();
            $table->string('colores_favorito',200)->nullable();
            $table->string('redes_sociales',200)->nullable();
            $table->string('deporte_favorito',200)->nullable();
            $table->integer('tiene_mascota')->nullable();
            $table->string('mascota',200)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'gpuse_fk_id_usu')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gusto_preferencia_users');
    }
};

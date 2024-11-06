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
        Schema::create('conoci_idiomas', function (Blueprint $table) {
            $table->id('id_conoci_idiomas');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('nom_conoci_idiomas');
            $table->unsignedBigInteger('lect_conoci_idiomas');
            $table->unsignedBigInteger('escrit_conoci_idiomas');
            $table->unsignedBigInteger('conver_conoci_idiomas');
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'cidi_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('nom_conoci_idiomas', 'cidi_fk_id_idi')->references('id_idioma')->on('idioma');
            $table->foreign('lect_conoci_idiomas', 'cidi_fk_id_lec')->references('id_nivel_instruccion')->on('nivel_instruccion');
            $table->foreign('escrit_conoci_idiomas', 'cidi_fk_id_esc')->references('id_nivel_instruccion')->on('nivel_instruccion');
            $table->foreign('conver_conoci_idiomas', 'cidi_fk_id_con')->references('id_nivel_instruccion')->on('nivel_instruccion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conoci_idiomas');
    }
};

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
        Schema::create('solicitud_puesto', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->string('base',10)->nullable();
            $table->unsignedBigInteger('id_puesto');
            $table->unsignedBigInteger('id_puesto_aspirado');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('grado_instruccion');
            $table->integer('observacion')->nullable();
            $table->integer('estado_s')->nullable();
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act');
            $table->integer('user_act');
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_puesto', 'spue_fk_id_pue')->references('id_puesto')->on('puesto');
            $table->foreign('id_puesto_aspirado', 'spue_fk_id_pasp')->references('id_puesto')->on('puesto');
            $table->foreign('id_usuario', 'spue_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('grado_instruccion', 'spue_fk_gins')->references('id_grado_instruccion')->on('grado_instruccion');
            $table->index(['id_puesto'], 'spue_idx_id_pue');
            $table->index(['id_puesto_aspirado'], 'spue_idx_id_pasp');
            $table->index(['id_usuario'], 'spue_idx_id_usu');
            $table->index(['grado_instruccion'], 'spue_idx_gins');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_puesto');
    }
};

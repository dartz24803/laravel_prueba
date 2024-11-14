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
        Schema::create('users_historico_puesto', function (Blueprint $table) {
            $table->id('id_historico_puesto');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('id_direccion')->nullable();
            $table->integer('id_gerencia')->nullable();
            $table->integer('id_sub_gerencia')->nullable();
            $table->integer('id_area')->nullable();
            $table->unsignedBigInteger('id_puesto');
            $table->unsignedBigInteger('id_centro_labor');
            $table->date('fec_inicio')->nullable();
            $table->integer('con_fec_fin')->nullable();
            $table->date('fec_fin')->nullable();
            $table->integer('id_tipo_cambio')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'uhpue_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_puesto', 'uhpue_fk_id_pue')->references('id_puesto')->on('puesto');
            $table->foreign('id_centro_labor', 'uhpue_fk_id_clab')->references('id_ubicacion')->on('ubicacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_historico_puesto');
    }
};

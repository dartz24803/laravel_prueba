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
        Schema::create('historico_estado_colaborador', function (Blueprint $table) {
            $table->id('id_historico_estado_colaborador');
            $table->unsignedBigInteger('id_historico_colaborador');
            $table->unsignedBigInteger('id_usuario');
            $table->date('fec_inicio')->nullable();
            $table->integer('estado_inicio_colaborador')->nullable();
            $table->date('fec_fin')->nullable();
            $table->integer('estado_fin_colaborador')->nullable();
            $table->integer('id_motivo_cese')->nullable();
            $table->text('observacion')->nullable();
            $table->text('archivo_cese')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_historico_colaborador', 'hecol_fk_id_hcol')->references('id_historico_colaborador')->on('historico_colaborador');
            $table->foreign('id_usuario', 'hecol_fk_id_usu')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_estado_colaborador');
    }
};

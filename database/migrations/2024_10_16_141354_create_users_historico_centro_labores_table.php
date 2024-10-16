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
        Schema::create('users_historico_centro_labores', function (Blueprint $table) {
            $table->id('id_historico_centro_labores');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_ubicacion');
            $table->string('centro_labores',10)->nullable();
            $table->integer('con_fec_fin')->nullable();
            $table->date('fec_inicio')->nullable();
            $table->date('fec_fin')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario','uhclab_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_ubicacion','uhclab_fk_id_ubi')->references('id_ubicacion')->on('ubicacion');
            $table->index(['id_usuario'], 'uhclab_idx_id_usu');
            $table->index(['id_ubicacion'], 'uhclab_idx_id_ubi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_historico_centro_labores');
    }
};

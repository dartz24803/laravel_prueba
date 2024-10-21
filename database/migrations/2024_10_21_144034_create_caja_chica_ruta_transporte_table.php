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
        Schema::create('caja_chica_ruta_transporte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_caja_chica_ruta');
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_caja_chica_ruta','ccrtra_fk_id_ccrut')->references('id')->on('caja_chica_ruta');
            $table->foreign('id_usuario','ccrtra_fk_id_usu')->references('id_usuario')->on('users');
            $table->index(['id_caja_chica_ruta'], 'ccrtra_idx_id_ccrut');
            $table->index(['id_usuario'], 'ccrtra_idx_id_usu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica_ruta_transporte');
    }
};

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
        Schema::create('detalle_examen_entrenamiento_tmp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_pregunta');
            $table->foreign('id_usuario', 'deetmp_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_pregunta', 'deetmp_fk_id_pre')->references('id')->on('pregunta');
            $table->index(['id_usuario'], 'deetmp_idx_id_usu');
            $table->index(['id_pregunta'], 'deetmp_idx_id_pre');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_examen_entrenamiento_tmp');
    }
};

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
        Schema::create('detalle_examen_entrenamiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_examen');
            $table->unsignedBigInteger('id_pregunta');
            $table->string('respuesta',1000)->nullable();
            $table->foreign('id_examen', 'deent_fk_id_exa')->references('id')->on('examen_entrenamiento');
            $table->foreign('id_pregunta', 'deent_fk_id_pre')->references('id')->on('pregunta');
            $table->index(['id_examen'], 'deent_idx_id_exa');
            $table->index(['id_pregunta'], 'deent_idx_id_pre');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_examen_entrenamiento');
    }
};

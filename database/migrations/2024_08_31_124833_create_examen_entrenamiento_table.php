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
        Schema::create('examen_entrenamiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_entrenamiento');
            $table->date('fecha')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->time('hora_fin_real')->nullable();
            $table->decimal('nota',10,2)->nullable();
            $table->dateTime('fecha_revision')->nullable();
            $table->integer('usuario_revision')->nullable();
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act');
            $table->integer('user_act');
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_entrenamiento', 'eent_fk_id_ent')->references('id')->on('entrenamiento');
            $table->index(['id_entrenamiento'], 'eent_idx_id_ent');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_entrenamiento');
    }
};

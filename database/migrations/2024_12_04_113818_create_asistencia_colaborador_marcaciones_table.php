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
        Schema::create('asistencia_colaborador_marcaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_asistencia_inconsistencia');
            $table->integer('tipo_marcacion')->nullable();
            $table->integer('visible')->nullable();
            $table->time('marcacion')->nullable();
            $table->text('obs_marcacion')->nullable();
            $table->integer('id_asistencia_colaborador')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_asistencia_inconsistencia', 'acmar_fk_id_ainc')->references('id_asistencia_inconsistencia')->on('asistencia_colaborador_inconsistencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_colaborador_marcaciones');
    }
};

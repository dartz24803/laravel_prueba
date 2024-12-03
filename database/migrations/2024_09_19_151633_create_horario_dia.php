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
        Schema::create('horario_dia', function (Blueprint $table) {
            $table->id('id_horario_dia');
            $table->unsignedBigInteger('id_horario');
            $table->unsignedBigInteger('id_turno');
            $table->integer('con_descanso')->nullable();
            $table->integer('dia')->nullable();
            $table->string('nom_dia', 10)->nullable();
            $table->time('hora_entrada')->nullable();
            $table->time('hora_entrada_desde')->nullable();
            $table->time('hora_entrada_hasta')->nullable();
            $table->time('hora_salida')->nullable();
            $table->time('hora_salida_desde')->nullable();
            $table->time('hora_salida_hasta')->nullable();
            $table->time('hora_descanso_e')->nullable();
            $table->time('hora_descanso_e_desde')->nullable();
            $table->time('hora_descanso_e_hasta')->nullable();
            $table->time('hora_descanso_s')->nullable();
            $table->time('hora_descanso_s_desde')->nullable();
            $table->time('hora_descanso_s_hasta')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_horario', 'hdia_fk_id_hor')->references('id_horario')->on('horario');
            $table->foreign('id_turno', 'hdia_fk_id_tur')->references('id_turno')->on('turno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_dia');
    }
};

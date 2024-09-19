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
            $table->integer('con_descanso');
            $table->integer('dia');
            $table->string('nom_dia', 10);
            $table->time('hora_entrada');
            $table->time('hora_entrada_desde');
            $table->time('hora_entrada_hasta');
            $table->time('hora_salida');
            $table->time('hora_salida_desde');
            $table->time('hora_salida_hasta');
            $table->time('hora_descanso_e')->nullable();
            $table->time('hora_descanso_e_desde')->nullable();
            $table->time('hora_descanso_e_hasta')->nullable();
            $table->time('hora_descanso_s')->nullable();
            $table->time('hora_descanso_s_desde')->nullable();
            $table->time('hora_descanso_s_hasta')->nullable();
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();

            // Definición de las llaves foráneas
            $table->foreign('id_horario', 'table_horario_dia_fk_id_horario')->references('id_horario')->on('horario');
            $table->foreign('id_turno', 'table_horario_dia_fk_id_turno')->references('id_turno')->on('turno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_horario_dia');
    }
};

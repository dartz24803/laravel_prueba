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
        Schema::create('asistencia_colaborador_inconsistencia', function (Blueprint $table) {
            $table->id('id_asistencia_inconsistencia');
            $table->unsignedBigInteger('id_usuario');
            $table->string('centro_labores',10)->nullable();
            $table->unsignedBigInteger('id_area');
            $table->date('fecha')->nullable();
            $table->integer('id_horario')->nullable();
            $table->integer('id_turno')->nullable();
            $table->string('nom_horario')->nullable();
            $table->integer('con_descanso')->nullable();
            $table->integer('dia')->nullable();
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
            $table->text('observacion')->nullable();
            $table->integer('flag_ausencia')->nullable();
            $table->integer('tipo_inconsistencia')->nullable();
            $table->integer('id_asistencia_colaborador')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'acinc_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_area', 'acinc_fk_id_are')->references('id_area')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia_colaborador_inconsistencia');
    }
};

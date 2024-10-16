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
        Schema::create('solicitudes_user', function (Blueprint $table) {
            $table->id('id_solicitudes_user');
            $table->BigInteger('id_usuario');
            $table->integer('id_solicitudes');
            $table->string('cod_solicitud', 15);
            $table->string('cod_base', 5)->nullable();
            $table->BigInteger('id_gerencia');
            $table->string('anio', 4);
            $table->date('fec_desde');
            $table->date('fec_hasta');
            $table->double('dif_dias', 10, 1);
            $table->date('fec_solicitud');
            $table->time('hora_salida')->nullable();
            $table->time('hora_retorno')->nullable();
            $table->time('horar_salida')->nullable();
            $table->time('horar_retorno')->nullable();
            $table->integer('user_horar_salida')->nullable();
            $table->integer('user_horar_entrada')->nullable();
            $table->integer('id_motivo');
            $table->string('destino', 200)->nullable();
            $table->text('tramite')->nullable();
            $table->string('especificacion_destino', 200)->nullable();
            $table->string('especificacion_tramite', 200)->nullable();
            $table->text('motivo')->nullable();
            $table->integer('estado_solicitud');
            $table->integer('user_aprob')->nullable();
            $table->dateTime('fec_apro')->nullable();
            $table->integer('sin_ingreso')->nullable();
            $table->integer('sin_retorno')->nullable();
            $table->integer('mediodia')->nullable();
            $table->text('observacion')->nullable();
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();

            $table->foreign('id_usuario', 'solicitudes_user_fk_id_usuario')->references('id_usuario')->on('usuario');
            $table->foreign('id_gerencia', 'solicitudes_user_fk_id_gerencia')->references('id_gerencia')->on('gerencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_user');
    }
};

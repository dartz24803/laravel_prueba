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
        Schema::create('calendario_logistico', function (Blueprint $table) {
            $table->id('id_calendario');
            $table->dateTime('fec_de')->nullable();
            $table->dateTime('fec_hasta')->nullable();
            $table->dateTime('de_real')->nullable();
            $table->dateTime('hasta_real')->nullable();
            $table->time('hora_real_llegada')->nullable();
            $table->time('hora_ingreso_insta')->nullable();
            $table->time('hora_descargo_merca')->nullable();
            $table->time('hora_salida')->nullable();
            $table->string('titulo',100)->nullable();
            $table->string('base',5)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('id_proveedor',10)->nullable();
            $table->integer('infosap')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->text('invitados')->nullable();
            $table->integer('invitacion')->nullable();
            $table->unsignedBigInteger('id_tipo_calendario');
            $table->integer('estado_reporte')->nullable();
            $table->integer('estado_interno')->nullable();
            $table->integer('cant_prendas')->nullable();
            $table->dateTime('fec_real_llegada')->nullable();
            $table->dateTime('fec_ingreso_instalaciones')->nullable();
            $table->dateTime('fec_descarga_merca')->nullable();
            $table->dateTime('fec_hora_salida')->nullable();
            $table->integer('flag')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'clog_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_tipo_calendario', 'clog_fk_id_tcal')->references('id_tipo_calendario')->on('tipo_calendario_logistico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendario_logistico');
    }
};

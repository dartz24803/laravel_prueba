<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReclutamientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclutamiento', function (Blueprint $table) {
            $table->id('id_reclutamiento');
            $table->string('cod_reclutamiento', 30);
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_puesto');
            $table->unsignedBigInteger('id_solicitante');
            $table->unsignedBigInteger('id_evaluador');
            $table->integer('vacantes');
            $table->string('cod_base', 11);
            $table->unsignedBigInteger('id_modalidad_laboral');
            $table->integer('tipo_sueldo');
            $table->double('sueldo', 10, 2);
            $table->double('desde', 10, 2);
            $table->double('a', 10, 2);
            $table->unsignedBigInteger('id_asignado');
            $table->integer('prioridad');
            $table->date('fec_cierre');
            $table->date('fec_termino')->nullable();
            $table->date('fec_cierre_r')->nullable();
            $table->text('observacion')->nullable();
            $table->integer('estado_reclutamiento');
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act');
            $table->integer('user_act');
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();

            $table->foreign('id_area', 'reclutamiento_fk_id_area')->references('id_area')->on('area');
            $table->foreign('id_puesto', 'reclutamiento_fk_id_puesto')->references('id_puesto')->on('puesto');
            $table->foreign('id_solicitante', 'reclutamiento_fk_id_solicitante')->references('id_usuario')->on('users');
            $table->foreign('id_evaluador', 'reclutamiento_fk_id_evaluador')->references('id_usuario')->on('users');
            $table->foreign('id_modalidad_laboral', 'reclutamiento_fk_id_modalidad_laboral')->references('id_modalidad_laboral')->on('modalidad_laboral');
            $table->foreign('id_asignado', 'reclutamiento_fk_id_asignado')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reclutamiento');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReclutamientoDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclutamiento_detalle', function (Blueprint $table) {
            $table->id('id_reclutamiento_detalle');
            $table->unsignedBigInteger('id_reclutamiento');
            $table->unsignedBigInteger('id_evaluador');
            $table->unsignedBigInteger('id_modalidad_laboral');
            $table->integer('tipo_sueldo');
            $table->integer('prioridad');
            $table->double('sueldo', 10, 2);
            $table->double('desde', 10, 2);
            $table->double('a', 10, 2);
            $table->integer('id_asignado');
            $table->text('observacion')->nullable();
            $table->date('fec_enproceso');
            $table->date('fec_cierre');
            $table->date('fec_cierre_r')->nullable();
            $table->integer('estado_reclutamiento');
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act');
            $table->integer('user_act');
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();

            $table->foreign('id_reclutamiento', 'reclutamiento_detalle_fk_id_reclutamiento')->references('id_reclutamiento')->on('reclutamiento');
            $table->foreign('id_evaluador', 'reclutamiento_detalle_fk_id_evaluador')->references('id_usuario')->on('users');
            $table->foreign('id_modalidad_laboral', 'reclutamiento_detalle_fk_id_modalidad_laboral')->references('id_modalidad_laboral')->on('modalidad_laboral');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reclutamiento_detalle');
    }
}

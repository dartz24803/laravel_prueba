<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReclutamientoReclutadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reclutamiento_reclutado', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('id_reclutamiento');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act');
            $table->integer('user_act');
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();

            $table->foreign('id_reclutamiento', 'reclutamiento_reclutado_fk_id_reclutamiento')->references('id_reclutamiento')->on('reclutamiento');
            $table->foreign('id_usuario', 'reclutamiento_reclutado_fk_id_usuario')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reclutamiento_reclutado');
    }
}

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
        Schema::create('asignacion_visita', function (Blueprint $table) {
            $table->id('id_asignacion_visita');
            $table->string('cod_asignacion',300)->nullable();
            $table->integer('id_inspector')->nullable();
            $table->integer('id_puesto_inspector')->nullable();
            $table->date('fecha')->nullable();
            $table->string('punto_partida',50)->nullable();
            $table->string('punto_llegada',50)->nullable();
            $table->integer('tipo_punto_partida')->nullable();
            $table->integer('tipo_punto_llegada')->nullable();
            $table->string('id_modelo')->nullable();
            $table->integer('id_proceso')->nullable();
            $table->text('observacion_otros')->nullable();
            $table->integer('id_tipo_transporte')->nullable();
            $table->decimal('costo',10,2)->nullable();
            $table->text('inspector_acompaniante')->nullable();
            $table->text('observacion')->nullable();
            $table->dateTime('fec_ini_visita')->nullable();
            $table->dateTime('fec_fin_visita')->nullable();
            $table->integer('ch_alm')->nullable();
            $table->time('ini_alm')->nullable();
            $table->time('fin_alm')->nullable();
            $table->integer('estado_registro')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_visita');
    }
};

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
        Schema::create('asignacion_jefatura', function (Blueprint $table) {
            $table->id('id_asignacion_jefatura');
            $table->bigInteger('id_puesto_permitido')->unsigned();
            $table->bigInteger('id_puesto_jefe')->unsigned();
            $table->integer('estado');
            $table->integer('user_reg');
            $table->datetime('fec_reg');
            $table->integer('user_act');
            $table->datetime('fec_act')->nullable();
            $table->integer('user_eli');
            $table->datetime('fec_eli')->nullable();

            $table->foreign('id_puesto_permitido', 'asignacion_jefatura_fk_id_puesto_permitido')->references('id_puesto')->on('puesto');
            $table->foreign('id_puesto_jefe', 'asignacion_jefatura_fk_id_puesto_jefe')->references('id_puesto')->on('puesto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_jefatura');
    }
};

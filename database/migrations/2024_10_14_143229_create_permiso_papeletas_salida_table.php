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
        Schema::create('permiso_papeletas_salida', function (Blueprint $table) {
            $table->id('id_permiso_papeletas_salida');
            $table->unsignedBigInteger('id_puesto_permitido');
            $table->unsignedBigInteger('id_puesto_jefe');
            $table->integer('registro_masivo');
            $table->integer('estado');
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            
            $table->foreign('id_puesto_permitido', 'pps_fk_id_puesto_permitido')->references('id_puesto')->on('puesto');
            $table->foreign('id_puesto_jefe', 'pps_fk_id_puesto_jefe')->references('id_puesto')->on('puesto');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permiso_papeletas_salida');
    }
};

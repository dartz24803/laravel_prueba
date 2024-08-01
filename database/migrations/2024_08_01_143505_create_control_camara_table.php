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
        Schema::create('control_camara', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_sede');
            $table->date('fecha')->nullable();
            $table->time('hora_programada')->nullable();
            $table->time('hora_registro')->nullable();
            $table->unsignedBigInteger('id_tienda');
            $table->unsignedBigInteger('id_ocurrencia');
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario','ccam_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_sede','ccam_fk_id_sed')->references('id_sede')->on('sedes');
            $table->foreign('id_tienda','ccam_fk_id_tie')->references('id_tienda')->on('tiendas');
            $table->foreign('id_ocurrencia','ccam_fk_id_ocu')->references('id_ocurrencias_camaras')->on('ocurrencias_camaras');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_camara');
    }
};

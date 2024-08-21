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
        Schema::create('seguridad_asistencia', function (Blueprint $table) {
            $table->id('id_seguridad_asistencia');
            $table->unsignedBigInteger('id_usuario');
            $table->string('base',5)->nullable();
            $table->string('cod_sede',5)->nullable();
            $table->string('cod_sedes',5)->nullable();
            $table->date('fecha')->nullable();
            $table->time('h_ingreso')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->time('h_salida')->nullable();
            $table->text('observacion')->nullable();
            $table->string('imagen',100)->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_usuario','sasi_fk_id_usu')->references('id_usuario')->on('users');
            $table->index(['fecha', 'estado'], 'idx_fec_est');
            $table->index(['fecha_salida', 'estado'], 'idx_fsal_est');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguridad_asistencia');
    }
};

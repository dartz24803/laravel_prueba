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
        Schema::create('horarios_cuadro_control', function (Blueprint $table) {
            $table->id('id_horarios_cuadro_control');
            $table->string('cod_base', 11)->nullable();
            $table->unsignedBigInteger('id_puesto')->nullable();
            $table->string('puesto', 255)->nullable();
            $table->string('dia', 11)->nullable();
            $table->integer('t_refrigerio_h')->nullable();
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->time('ini_refri')->nullable();
            $table->time('fin_refri')->nullable();
            $table->time('ini_refri2')->nullable();
            $table->time('fin_refri2')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_puesto')->references('id_puesto')->on('puesto');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios_cuadro_control');
    }
};

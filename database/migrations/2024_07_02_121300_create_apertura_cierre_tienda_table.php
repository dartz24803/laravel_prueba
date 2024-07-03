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
        Schema::create('apertura_cierre_tienda', function (Blueprint $table) {
            $table->id('id_apertura_cierre');
            $table->date('fecha')->nullable();
            $table->string('cod_base',20)->nullable();
            $table->time('ingreso')->nullable();
            $table->time('ingreso_horario')->nullable();
            $table->text('obs_ingreso')->nullable();
            $table->string('archivo_ingreso')->nullable();
            $table->time('apertura')->nullable();
            $table->time('apertura_horario')->nullable();
            $table->text('obs_apertura')->nullable();
            $table->string('archivo_apertura')->nullable();
            $table->time('cierre')->nullable();
            $table->time('cierre_horario')->nullable();
            $table->text('obs_cierre')->nullable();
            $table->string('archivo_cierre')->nullable();
            $table->time('salida')->nullable();
            $table->time('salida_horario')->nullable();
            $table->text('obs_salida')->nullable();
            $table->string('archivo_salida')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apertura_cierre_tienda');
    }
};

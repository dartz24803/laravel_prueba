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
        Schema::create('enfermedad_usuario', function (Blueprint $table) {
            $table->id('id_enfermedad_usuario');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('id_respuestae')->nullable();
            $table->string('nom_enfermedad',50)->nullable();
            $table->string('dia_diagnostico',2)->nullable();
            $table->string('mes_diagnostico',2)->nullable();
            $table->string('anio_diagnostico',4)->nullable();
            $table->date('fec_diagnostico')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'eusu_fk_id_usu')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfermedad_usuario');
    }
};

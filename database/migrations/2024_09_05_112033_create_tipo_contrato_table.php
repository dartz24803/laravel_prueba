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
        Schema::create('tipo_contrato', function (Blueprint $table) {
            $table->id('id_tipo_contrato');
            $table->unsignedBigInteger('id_situacion_laboral');
            $table->string('nom_tipo_contrato', 255);
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_situacion_laboral', 'tipo_contrato_fk_id_situacion_laboral')->references('id_situacion_laboral')->on('situacion_laboral');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_contrato');
    }
};

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
        Schema::create('saludo_cumpleanio_historial', function (Blueprint $table) {
            $table->id('id_historial');
            $table->integer('id_cumpleaniero');
            $table->unsignedBigInteger('id_usuario');
            $table->date('fecha_cumple');
            $table->text('mensaje')->nullable();
            $table->integer('estado_registro');
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario','saludo_cumpleanio_historial_fk_id_usuario')->references('id_usuario')->on('users');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saludo_cumpleanio_historial');
    }
};
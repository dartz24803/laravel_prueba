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
        Schema::create('users_historico_horario', function (Blueprint $table) {
            $table->id('id_historico_horario');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_horario');
            $table->integer('con_fec_fin')->nullable();
            $table->date('fec_inicio')->nullable();
            $table->date('fec_fin')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'uhhor_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_horario', 'uhhor_fk_id_hor')->references('id_horario')->on('horario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_historico_horario');
    }
};

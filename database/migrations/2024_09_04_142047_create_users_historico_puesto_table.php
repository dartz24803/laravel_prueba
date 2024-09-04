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
        Schema::create('users_historico_puesto', function (Blueprint $table) {
            $table->id('id_historico_puesto');
            //$table->unsignedBigInteger('id_usuario');
            //$table->unsignedBigInteger('id_direccion');
            //$table->unsignedBigInteger('id_gerencia');
            //$table->unsignedBigInteger('id_sub_gerencia');
            //$table->unsignedBigInteger('id_area');
            //$table->unsignedBigInteger('id_puesto');
            $table->integer('id_usuario')->nullable();
            $table->integer('id_direccion')->nullable();
            $table->integer('id_gerencia')->nullable();
            $table->integer('id_sub_gerencia')->nullable();
            $table->integer('id_area')->nullable();
            $table->integer('id_puesto')->nullable();
            $table->date('fec_inicio')->nullable();
            $table->integer('con_fec_fin')->nullable();
            $table->date('fec_fin')->nullable();
            $table->integer('id_tipo_cambio')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_historico_puesto');
    }
};

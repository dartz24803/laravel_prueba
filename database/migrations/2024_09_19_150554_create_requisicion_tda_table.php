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
        Schema::create('requisicion_tda', function (Blueprint $table) {
            $table->id('id_requisicion');
            $table->string('cod_requisicion',30)->nullable();
            $table->date('fecha')->nullable();
            $table->string('base',10)->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->integer('estado_registro')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_aprob')->nullable();
            $table->integer('user_aprob')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'rtda_fk_id_usu')->references('id_usuario')->on('users');
            $table->index(['id_usuario'], 'rtda_idx_id_usu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisicion_tda');
    }
};

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
        Schema::create('competencia_puesto', function (Blueprint $table) {
            $table->id('id_competencia_puesto');
            $table->unsignedBigInteger('id_puesto');
            $table->unsignedBigInteger('id_competencia');
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_puesto','com_fk_id_pue')->references('id_puesto')->on('puesto');
            $table->foreign('id_competencia','com_fk_id_com')->references('id_competencia')->on('competencia');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencia_puesto');
    }
};

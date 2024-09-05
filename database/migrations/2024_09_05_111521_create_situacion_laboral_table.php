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
        Schema::create('situacion_laboral', function (Blueprint $table) {
            $table->id('id_situacion_laboral');
            $table->string('cod_situacion_laboral', 10);
            $table->string('nom_situacion_laboral', 50);
            $table->integer('ficha')->nullable();
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
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
        Schema::dropIfExists('situacion_laboral');
    }
};

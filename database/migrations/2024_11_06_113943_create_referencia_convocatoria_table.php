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
        Schema::create('referencia_convocatoria', function (Blueprint $table) {
            $table->id('id_referencia_convocatoria');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_referencia_laboral');
            $table->string('otros',150)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'rcon_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_referencia_laboral', 'rcon_fk_id_rlab')->references('id_referencia_laboral')->on('referencia_laboral');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencia_convocatoria');
    }
};

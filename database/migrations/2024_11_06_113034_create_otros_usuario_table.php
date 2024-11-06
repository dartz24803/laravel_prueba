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
        Schema::create('otros_usuario', function (Blueprint $table) {
            $table->id('id_otros_usuario');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_grupo_sanguineo');
            $table->string('cert_covid')->nullable();
            $table->string('cert_vacu_covid')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'ousu_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_grupo_sanguineo', 'ousu_fk_id_gsan')->references('id_grupo_sanguineo')->on('grupo_sanguineo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otros_usuario');
    }
};

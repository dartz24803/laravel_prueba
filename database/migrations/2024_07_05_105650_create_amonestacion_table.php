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
        Schema::create('amonestacion', function (Blueprint $table) {
            $table->id('id_amonestacion');
            $table->string('cod_amonestacion', 30)->nullable();
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('id_solicitante');
            $table->unsignedBigInteger('id_colaborador');
            $table->integer('id_revisor')->nullable();
            $table->string('tipo', 255)->nullable();
            $table->unsignedBigInteger('id_gravedad_amonestacion');
            $table->string('motivo', 250)->nullable();
            $table->text('detalle')->nullable();
            $table->dateTime('fec_aprobacion')->nullable();
            $table->text('documento')->nullable();
            $table->integer('estado_amonestacion')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_solicitante','amo_fk_id_sol')->references('id_usuario')->on('users');
            $table->foreign('id_colaborador','amo_fk_id_col')->references('id_usuario')->on('users');
            $table->foreign('id_gravedad_amonestacion','amo_fk_id_gamo')->references('id_gravedad_amonestacion')->on('gravedad_amonestacion');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amonestacion');
    }
};

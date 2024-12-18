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
        Schema::create('asignacion_visita_transporte', function (Blueprint $table) {
            $table->id('id_asignacion_visita_transporte');
            $table->unsignedBigInteger('id_asignacion_visita');
            $table->integer('id_tipo_transporte')->nullable();
            $table->decimal('costo',10,2)->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_asignacion_visita', 'avtra_fk_id_avis')->references('id_asignacion_visita')->on('asignacion_visita');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_visita_transporte');
    }
};

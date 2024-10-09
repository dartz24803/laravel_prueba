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
        Schema::create('mercaderia_fotografia', function (Blueprint $table) {
            $table->id('id_mercaderia');
            $table->string('codigo', 50)->nullable();
            $table->string('usuario', 50)->nullable();
            $table->string('estilo', 150)->nullable();
            $table->string('descripcion', 150)->nullable();
            $table->string('color', 150)->nullable();
            $table->string('talla', 20)->nullable();
            $table->integer('cantidad');
            $table->string('ubicacion', 250)->nullable();
            $table->text('observacion')->nullable();
            $table->text('observacion_validaf');
            $table->char('mes', 2);
            $table->char('anio', 4);
            $table->integer('foto');
            $table->integer('estado_requerimiento');
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->integer('user_validaf');
            $table->dateTime('fec_validaf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mercaderia_fotografia');
    }
};

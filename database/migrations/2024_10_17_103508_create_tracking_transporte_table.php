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
        Schema::create('tracking_transporte', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_base');
            $table->string('semana',2)->nullable();
            $table->integer('transporte')->nullable();
            $table->integer('tiempo_llegada')->nullable();
            $table->integer('recepcion')->nullable();
            $table->string('receptor')->nullable();
            $table->integer('tipo_pago')->nullable();
            $table->string('nombre_transporte',1000)->nullable();
            $table->decimal('importe_transporte',10,2)->nullable();
            $table->string('factura_transporte',20)->nullable();
            $table->string('archivo_transporte')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->integer('usuario')->nullable();
            $table->foreign('id_base','ttra_fk_id_bas')->references('id_base')->on('base');
            $table->index(['id_base'], 'ttra_idx_id_bas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_transporte');
    }
};

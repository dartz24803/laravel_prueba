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
        Schema::create('nhextorno', function (Blueprint $table) {
            $table->id('id_nhextorno');
            $table->unsignedBigInteger('id_cartera');
            $table->foreign('id_cartera')->references('id_cartera')->on('cartera');
            $table->string('nro_referencia', 11);
            $table->string('tarjeta', 20);
            $table->date('fecha_venta');
            $table->string('moneda', 11);
            $table->decimal('importe_original', 18, 2);
            $table->decimal('importe_devuelto', 18, 2);
            $table->string('codigo_autorizacion', 11);
            $table->date('fecha_devolucion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhextorno');
    }
};

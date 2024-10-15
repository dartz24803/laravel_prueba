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
        Schema::create('caja_chica_ruta_tmp', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario')->nullable();
            $table->integer('personas')->nullable();
            $table->string('punto_salida')->nullable();
            $table->string('punto_llegada')->nullable();
            $table->integer('transporte')->nullable();
            $table->string('motivo',1000)->nullable();
            $table->decimal('costo',10,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica_ruta_tmp');
    }
};

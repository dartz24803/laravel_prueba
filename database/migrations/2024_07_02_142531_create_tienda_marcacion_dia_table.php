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
        Schema::create('tienda_marcacion_dia', function (Blueprint $table) {
            $table->id('id_tienda_marcacion_dia');
            $table->unsignedBigInteger('id_tienda_marcacion');
            $table->integer('dia')->nullable();
            $table->string('nom_dia',10)->nullable();
            $table->time('hora_ingreso')->nullable();
            $table->time('hora_apertura')->nullable();
            $table->time('hora_cierre')->nullable();
            $table->time('hora_salida')->nullable();
            $table->foreign('id_tienda_marcacion','tie_fk_id_tie')->references('id_tienda_marcacion')->on('tienda_marcacion');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tienda_marcacion_dia');
    }
};

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
        Schema::create('tracking_guia_remision_detalle', function (Blueprint $table) {
            $table->id();
            $table->string('n_guia_remision', 20)->nullable();
            $table->string('sku', 20)->nullable();
            $table->string('color', 200)->nullable();
            $table->string('estilo', 200)->nullable();
            $table->string('talla', 20)->nullable();
            $table->string('descripcion', 1000)->nullable();
            $table->integer('cantidad')->default(0)->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_guia_remision_detalle');
    }
};

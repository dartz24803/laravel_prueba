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
            $table->string('n_guia_remision', 20);
            $table->string('color', 200);
            $table->string('estilo', 200);
            $table->string('talla', 20);
            $table->string('descripcion', 1000);
            $table->integer('cantidad');
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

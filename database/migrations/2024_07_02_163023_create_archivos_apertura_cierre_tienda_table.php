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
        Schema::create('archivos_apertura_cierre_tienda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_apertura_cierre');
            $table->integer('tipo_apertura')->nullable();
            $table->string('archivo');
            $table->foreign('id_apertura_cierre','aactie_fk_id_ape')->references('id_apertura_cierre')->on('apertura_cierre_tienda');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_apertura_cierre_tienda');
    }
};

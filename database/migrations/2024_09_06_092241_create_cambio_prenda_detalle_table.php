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
        Schema::create('cambio_prenda_detalle', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('id_cambio_prenda');
            $table->string('n_codi_arti',20)->nullable();
            $table->integer('n_cant_vent')->nullable();
            $table->string('c_arti_desc')->nullable();
            $table->string('color',50)->nullable();
            $table->string('talla',20)->nullable();
            $table->foreign('id_cambio_prenda', 'cpdet_fk_id_cpre')->references('id_cambio_prenda')->on('cambio_prenda');
            $table->index(['id_cambio_prenda'], 'cpdet_idx_id_cpre');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cambio_prenda_detalle');
    }
};

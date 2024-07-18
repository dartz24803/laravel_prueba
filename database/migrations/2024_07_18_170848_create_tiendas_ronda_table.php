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
        Schema::create('tiendas_ronda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tienda');
            $table->unsignedBigInteger('id_ronda');
            $table->dateTime('fecha')->nullable();
            $table->integer('usuario')->nullable();
            $table->foreign('id_tienda','tron_id_tie')->references('id_tienda')->on('tiendas');
            $table->foreign('id_ronda','tron_id_ron')->references('id')->on('control_camara_ronda');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiendas_ronda');
    }
};

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
        Schema::create('detalle_ocurrencias_camaras', function (Blueprint $table) {
            $table->id('id_detalle_ocurrencias_camaras');
            $table->unsignedBigInteger('id_ocurrencia');
            $table->unsignedBigInteger('id_control_camara');
            $table->foreign('id_control_camara','detalle_ocurrencias_camaras_fk_id_control_camara')->references('id')->on('control_camara');
            $table->foreign('id_ocurrencia','detalle_ocurrencias_camaras_fk_id_ocurrencia')->references('id')->on('control_camara');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ocurrencias_camaras');
    }
};

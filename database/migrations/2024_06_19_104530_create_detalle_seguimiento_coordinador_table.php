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
        Schema::create('detalle_seguimiento_coordinador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_seguimiento_coordinador');
            $table->unsignedBigInteger('id_contenido');
            $table->integer('valor');
            $table->foreign('id_seguimiento_coordinador', 'det_seg_coo_fk_id_seg_coo')->references('id')->on('seguimiento_coordinador');
            $table->foreign('id_contenido', 'det_seg_coo_fk_id_con')->references('id')->on('contenido_seguimiento_coordinador');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_seguimiento_coordinador');
    }
};

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
        Schema::create('archivos_seguimiento_coordinador', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_seguimiento_coordinador');
            $table->string('archivo', 100);
            $table->foreign('id_seguimiento_coordinador', 'arc_seg_coo_fk_id_seg_coo')->references('id')->on('seguimiento_coordinador');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_seguimiento_coordinador');
    }
};

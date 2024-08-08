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
            $table->id('id_detalle_ocurrencias_camaras'); // Auto-increment primary key
            $table->integer('id_ocurrencia')->unsigned();
            $table->integer('id_control_camara')->unsigned();
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

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
        Schema::create('detalle_supervision_tienda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_supervision_tienda');
            $table->unsignedBigInteger('id_contenido');
            $table->integer('valor');
            $table->foreign('id_supervision_tienda')->references('id')->on('supervision_tienda');
            $table->foreign('id_contenido')->references('id')->on('contenido_supervision_tienda');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_supervision_tienda');
    }
};

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
        Schema::create('archivos_supervision_tienda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_supervision_tienda');
            $table->string('archivo', 100);
            $table->foreign('id_supervision_tienda')->references('id')->on('supervision_tienda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_supervision_tienda');
    }
};

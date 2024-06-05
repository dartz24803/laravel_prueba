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
        Schema::create('tracking_archivo_temporal', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->integer('tipo');
            $table->string('archivo', 100);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_archivo_temporal');
    }
};

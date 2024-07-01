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
        Schema::create('tracking_evaluacion_temporal', function (Blueprint $table) { 
            $table->id();
            $table->integer('id_usuario')->nullable();
            $table->integer('id_devolucion')->nullable();
            $table->integer('aprobacion')->nullable();
            $table->text('sustento_respuesta')->nullable();
            $table->text('forma_proceder')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_evaluacion_temporal');
    }
};

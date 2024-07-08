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
        Schema::create('tracking_temporal', function (Blueprint $table) {
            $table->string('n_requerimiento',10)->nullable();
            $table->string('n_guia_remision',50)->nullable();
            $table->string('semana',2)->nullable();
            $table->integer('id_origen_desde')->nullable();
            $table->string('desde',50)->nullable();
            $table->integer('id_origen_hacia')->nullable();
            $table->string('hacia',50)->nullable();
            $table->integer('bultos')->nullable();
            //$table->id();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_temporal');
    }
};

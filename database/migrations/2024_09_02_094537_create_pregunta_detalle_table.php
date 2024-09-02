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
        Schema::create('pregunta_detalle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pregunta');
            $table->string('opcion',1000)->nullable();
            $table->integer('respuesta')->nullable();
            $table->foreign('id_pregunta', 'pdet_fk_id_pre')->references('id')->on('pregunta');
            $table->index(['id_pregunta'], 'pdet_idx_id_pre');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregunta_detalle');
    }
};

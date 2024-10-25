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
        Schema::create('tracking_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_base');
            $table->string('anio',4)->nullable();
            $table->string('semana',2)->nullable();
            $table->string('guia_remision')->nullable();
            $table->foreign('id_base', 'tpag_fk_id_bas')->references('id_base')->on('base');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_pago');
    }
};

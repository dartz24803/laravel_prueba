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
        Schema::create('tracking_detalle_estado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_detalle');
            $table->unsignedBigInteger('id_estado');
            $table->dateTime('fecha')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_detalle','tdest_fk_id_det')->references('id')->on('tracking_detalle_proceso');
            $table->foreign('id_estado','tdest_fk_id_est')->references('id')->on('tracking_estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_detalle_estado');
    }
};

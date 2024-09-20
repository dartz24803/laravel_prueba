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
        Schema::create('requisicion_tda_detalle', function (Blueprint $table) {
            $table->id('id_requisicion_detalle');
            $table->unsignedBigInteger('id_requisicion');
            $table->integer('stock')->nullable();
            $table->integer('cantidad')->nullable();
            $table->unsignedBigInteger('id_producto');
            $table->decimal('precio',10,2)->nullable();
            $table->decimal('total',10,2)->nullable();
            $table->string('archivo',100)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_requisicion', 'rtdet_fk_id_req')->references('id_requisicion')->on('requisicion_tda');
            $table->foreign('id_producto', 'rtdet_fk_id_pro')->references('id_producto')->on('producto_caja');
            $table->index(['id_requisicion'], 'rtdet_idx_id_req');
            $table->index(['id_producto'], 'rtdet_idx_id_pro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisicion_tda_detalle');
    }
};

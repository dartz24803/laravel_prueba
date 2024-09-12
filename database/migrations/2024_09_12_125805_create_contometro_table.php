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
        Schema::create('contometro', function (Blueprint $table) {
            $table->id('id_contometro');
            $table->unsignedBigInteger('id_insumo');
            $table->unsignedBigInteger('id_proveedor');
            $table->integer('cantidad')->nullable();
            $table->date('fecha_contometro')->nullable();
            $table->string('n_factura',25)->nullable();
            $table->string('factura')->nullable();
            $table->string('n_guia',25)->nullable();
            $table->string('guia')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_insumo', 'con_fk_id_ins')->references('id_insumo')->on('insumo');
            $table->foreign('id_proveedor', 'con_fk_id_pro')->references('id_proveedor')->on('proveedor');
            $table->index(['id_insumo'], 'con_idx_id_ins');
            $table->index(['id_proveedor'], 'con_idx_id_pro');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contometro');
    }
};

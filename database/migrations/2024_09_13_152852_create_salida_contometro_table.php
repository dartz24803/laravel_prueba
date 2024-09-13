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
        Schema::create('salida_contometro', function (Blueprint $table) {
            $table->id('id_salida_contometro');
            $table->unsignedBigInteger('id_insumo');
            $table->integer('cantidad_salida')->nullable();
            $table->string('cod_base',10)->nullable();
            $table->integer('flag_acceso')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->integer('id_usuario')->nullable();
            $table->integer('estado')->nullable();
            $table->datetime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->datetime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->datetime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_insumo', 'scon_fk_id_ins')->references('id_insumo')->on('insumo');
            $table->index(['id_insumo'], 'scon_idx_id_ins');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salida_contometro');
    }
};

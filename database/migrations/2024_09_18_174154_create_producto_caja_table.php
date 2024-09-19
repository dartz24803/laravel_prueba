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
        Schema::create('producto_caja', function (Blueprint $table) {
            $table->id('id_producto');
            $table->unsignedBigInteger('id_marca');
            $table->integer('id_modelo')->nullable();
            $table->unsignedBigInteger('id_unidad');
            $table->integer('id_color')->nullable();
            $table->integer('id_categoria')->nullable();
            $table->string('nom_producto')->nullable();
            $table->integer('estado_registro')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_marca', 'pcaj_fk_id_mar')->references('id_marca')->on('marca');
            $table->foreign('id_unidad', 'pcaj_fk_id_uni')->references('id_unidad')->on('unidad');
            $table->index(['id_marca'], 'pcaj_idx_id_mar');
            $table->index(['id_unidad'], 'pcaj_idx_id_uni');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_caja');
    }
};

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
        Schema::create('cambio_prenda', function (Blueprint $table) {
            $table->id('id_cambio_prenda');
            $table->integer('tipo_boleta')->nullable();
            $table->string('cod_cambio',20)->nullable();
            //$table->unsignedBigInteger('base');
            $table->unsignedBigInteger('id_usuario');
            $table->string('base',20)->nullable();
            $table->string('tipo_comprobante',2)->nullable();
            $table->string('serie',20)->nullable();
            $table->string('n_documento',20)->nullable();
            $table->string('nuevo_num_comprobante',100)->nullable();
            $table->string('nuevo_num_serie',50)->nullable();
            $table->unsignedBigInteger('id_motivo');
            $table->string('otro',250)->nullable();
            $table->string('nom_cliente',250)->nullable();
            $table->string('telefono',10)->nullable();
            $table->string('vendedor',250)->nullable();
            $table->string('num_caja',20)->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->integer('estado_cambio')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            //$table->foreign('base', 'cpre_fk_id_bas')->references('id_ubicacion')->on('ubicacion');
            $table->foreign('id_motivo', 'cpre_fk_id_mot')->references('id_motivo')->on('motivo_cprenda');
            $table->foreign('id_usuario', 'cpre_fk_id_usu')->references('id_usuario')->on('users');
            //$table->index(['base'], 'cpre_idx_id_bas');
            $table->index(['id_motivo'], 'cpre_idx_id_mot');
            $table->index(['id_usuario'], 'cpre_idx_id_usu');
            $table->index(['fec_reg'], 'cpre_idx_freg');
            $table->index(['base'], 'cpre_idx_bas');
            $table->index(['tipo_boleta'], 'cpre_idx_tbol');
            $table->index(['estado_cambio'], 'cpre_idx_ecam');
            $table->index(['estado'], 'cpre_idx_est');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cambio_prenda');
    }
};

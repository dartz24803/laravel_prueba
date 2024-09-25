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
        Schema::create('caja_chica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ubicacion');
            $table->unsignedBigInteger('id_categoria');
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('id_sub_categoria');
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_tipo_moneda');
            $table->decimal('total',10,2)->nullable();
            $table->string('ruc',20)->nullable();
            $table->string('razon_social')->nullable();
            $table->integer('ruta')->nullable();
            $table->integer('id_tipo_comprobante')->nullable();
            $table->string('n_comprobante',30)->nullable();
            $table->string('punto_partida')->nullable();
            $table->string('punto_llegada')->nullable();
            $table->string('comprobante',100)->nullable();
            $table->integer('id_pago')->nullable();
            $table->integer('id_tipo_pago')->nullable();
            $table->integer('cuenta_1')->nullable();
            $table->integer('cuenta_2')->nullable();
            $table->integer('estado_c')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_ubicacion', 'cchi_fk_id_ubi')->references('id_ubicacion')->on('ubicacion');
            $table->foreign('id_categoria', 'cchi_fk_id_cat')->references('id_categoria')->on('categoria');
            $table->foreign('id_sub_categoria', 'cchi_fk_id_scat')->references('id')->on('sub_categoria');
            $table->foreign('id_empresa', 'cchi_fk_id_emp')->references('id_empresa')->on('empresas');
            $table->foreign('id_tipo_moneda', 'cchi_fk_id_tmon')->references('id_moneda')->on('tipo_moneda');
            $table->index(['id_ubicacion'], 'cchi_idx_id_ubi');
            $table->index(['id_categoria'], 'cchi_idx_id_cat');
            $table->index(['id_sub_categoria'], 'cchi_idx_id_scat');
            $table->index(['id_empresa'], 'cchi_idx_id_emp');
            $table->index(['id_tipo_moneda'], 'cchi_idx_id_tmon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica');
    }
};

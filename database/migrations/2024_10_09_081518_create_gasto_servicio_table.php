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
        Schema::create('gasto_servicio', function (Blueprint $table) {
            $table->id('id_gasto_servicio');
            $table->string('cod_base',5)->nullable();
            $table->unsignedBigInteger('id_servicio');
            $table->integer('id_lugar_servicio')->nullable();
            $table->unsignedBigInteger('id_proveedor_servicio');
            $table->string('suministro',50)->nullable();
            $table->string('mes',2)->nullable();
            $table->string('anio',4)->nullable();
            $table->string('documento_serie',15)->nullable();
            $table->string('documento_numero',15)->nullable();
            $table->integer('lant_dato')->nullable();
            $table->date('lant_fecha')->nullable();
            $table->integer('lact_dato')->nullable();
            $table->date('lact_fecha')->nullable();
            $table->date('fec_emision')->nullable();
            $table->date('fec_vencimiento')->nullable();
            $table->decimal('importe',10,2)->nullable();
            $table->string('documento')->nullable();
            $table->date('fec_pago')->nullable();
            $table->string('comprobante')->nullable();
            $table->decimal('comision',10,2)->nullable();
            $table->string('num_operacion',15)->nullable();
            $table->string('autogenerado',15)->nullable();
            $table->integer('estado_servicio')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_servicio', 'gser_fk_id_ser')->references('id_servicio')->on('servicio');
            $table->foreign('id_proveedor_servicio', 'gser_fk_id_pser')->references('id_proveedor_servicio')->on('proveedor_servicio');
            $table->index(['id_servicio'], 'gser_idx_id_ser');
            $table->index(['id_proveedor_servicio'],' gser_idx_id_pser');
            $table->index(['mes'], 'gser_idx_mes');
            $table->index(['anio'], 'gser_idx_ani');
            $table->index(['cod_base'], 'gser_idx_cbas');
            $table->index(['estado_servicio'], 'gser_idx_eser');
            $table->index(['id_lugar_servicio'], 'gser_idx_id_lser');
            $table->index(['estado'], 'gser_idx_est');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gasto_servicio');
    }
};

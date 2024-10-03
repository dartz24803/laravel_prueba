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
        Schema::create('letras_cobrar', function (Blueprint $table) {
            $table->id('id_letra_cobrar');
            $table->string('cod_registro',30)->nullable(); //NO sirve
            $table->date('fec_emision')->nullable();
            $table->date('fec_vencimiento')->nullable();
            $table->integer('id_tipo_documento')->nullable();
            $table->string('num_doc',50)->nullable();
            $table->string('tipo_doc_cliente',50)->nullable();
            $table->string('num_doc_cliente',50)->nullable();
            $table->integer('id_tipo_comprobante')->nullable();
            $table->string('num_comprobante',50)->nullable();
            $table->unsignedBigInteger('id_moneda');
            $table->decimal('monto',10,2)->nullable();
            $table->unsignedBigInteger('id_empresa');
            $table->date('fec_pago')->nullable();
            $table->string('noperacion',50)->nullable();
            $table->string('num_unico',50)->nullable();
            $table->string('num_cuenta',50)->nullable();
            $table->string('banco',100)->nullable();
            $table->string('documento')->nullable();
            $table->string('comprobante_pago')->nullable();
            $table->integer('estado_registro')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_empresa', 'lcob_fk_id_emp')->references('id_empresa')->on('empresas');
            $table->foreign('id_moneda', 'lcob_fk_id_mon')->references('id_moneda')->on('tipo_moneda');
            $table->index(['id_empresa'], 'lcob_idx_id_emp');
            $table->index(['id_moneda'],' lcob_idx_id_mon');
            $table->index(['fec_emision'], 'lcob_idx_femi');
            $table->index(['fec_vencimiento'], 'lcob_idx_fven');
            $table->index(['tipo_doc_cliente','num_doc_cliente'], 'lcob_idx_id_cli');
            $table->index(['estado_registro'], 'lcob_idx_ereg');
            $table->index(['estado'], 'lcob_idx_est');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letras_cobrar');
    }
};

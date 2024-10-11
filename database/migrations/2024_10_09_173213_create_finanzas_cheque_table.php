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
        Schema::create('finanzas_cheque', function (Blueprint $table) {
            $table->id('id_cheque');
            $table->string('cod_cheque',20)->nullable(); //NO sirve
            $table->unsignedBigInteger('id_empresa');
            $table->unsignedBigInteger('id_banco');
            $table->string('n_cheque',20)->nullable();
            $table->integer('id_tipo')->nullable();
            $table->date('fec_emision')->nullable();
            $table->date('fec_vencimiento')->nullable();
            $table->integer('id_proveedor')->nullable();
            $table->string('tipo_doc',50)->nullable();
            $table->string('num_doc',50)->nullable();
            $table->string('razon_social')->nullable();
            $table->integer('concepto')->nullable();
            $table->unsignedBigInteger('id_moneda');
            $table->decimal('importe',10,2)->nullable();
            $table->integer('estado_cheque')->nullable();
            $table->dateTime('fec_autorizado')->nullable();
            $table->dateTime('fec_pend_cobro')->nullable();
            $table->date('fec_cobro')->nullable();
            $table->string('noperacion',50)->nullable();
            $table->string('motivo_anulado',150)->nullable();
            $table->string('img_cheque')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_empresa', 'fche_fk_id_emp')->references('id_empresa')->on('empresas');
            $table->foreign('id_banco', 'fche_fk_id_ban')->references('id_banco')->on('banco');
            $table->foreign('id_moneda', 'fche_fk_id_mon')->references('id_moneda')->on('tipo_moneda');
            $table->index(['id_empresa'], 'fche_idx_id_emp');
            $table->index(['id_banco'], 'fche_idx_id_ban');
            $table->index(['id_moneda'],' fche_idx_id_mon');
            $table->index(['fec_emision'], 'fche_idx_femi');
            $table->index(['fec_vencimiento'], 'fche_idx_fven');
            $table->index(['estado_cheque'], 'fche_idx_eche');
            $table->index(['estado'], 'fche_idx_est');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finanzas_cheque');
    }
};

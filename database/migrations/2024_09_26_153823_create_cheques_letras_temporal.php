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
        Schema::create('cheques_letras_temporal', function (Blueprint $table) {
            $table->id('id_temporal');
            $table->text('num_doc')->nullable();
            $table->text('fec_emision')->nullable();
            $table->text('fec_vencimiento')->nullable();
            $table->date('fec_emision_ok')->nullable();
            $table->date('fec_vencimiento_ok')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('importe')->nullable();
            $table->decimal('importe_ok',10,2)->nullable();
            $table->text('n_comprobante')->nullable();
            $table->text('ruc_empresa')->nullable();
            $table->text('tipo_doc')->nullable();
            $table->text('tipo_doc_aceptante')->nullable();
            $table->text('num_doc_aceptante')->nullable();
            $table->text('tipo_comprobante')->nullable();
            $table->text('tipo_moneda')->nullable();
            $table->text('nom_empresa')->nullable();
            $table->text('nom_aceptante')->nullable();
            $table->integer('id_empresa')->nullable();
            $table->integer('id_tipo_documento')->nullable();
            $table->integer('id_tipo_comprobante')->nullable();
            $table->string('num_comprobante')->nullable();
            $table->integer('id_moneda')->nullable();
            $table->text('obs')->nullable();
            $table->integer('ok')->nullable();
            $table->integer('id')->nullable(); //NO sirve
            $table->integer('estado')->nullable(); //NO sirve
            $table->dateTime('fec_reg')->nullable(); //NO sirve
            $table->integer('user_reg')->nullable(); //Cambiar por id_usuario y relacionar con users
            $table->dateTime('fec_act')->nullable(); //NO sirve
            $table->integer('user_act')->nullable(); //NO sirve
            $table->dateTime('fec_eli')->nullable(); //NO sirve
            $table->integer('user_eli')->nullable(); //NO sirve
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques_letras_temporal');
    }
};

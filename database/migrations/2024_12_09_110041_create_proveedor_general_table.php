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
        Schema::create('proveedor_general', function (Blueprint $table) {
            $table->id('id_proveedor');
            $table->integer('id_proveedor_mae')->nullable();
            $table->integer('tipo_proveedor')->nullable();
            $table->string('codigo_proveedor',20)->nullable();
            $table->string('nombre_proveedor',250)->nullable();
            $table->string('ruc_proveedor',20)->nullable();
            $table->string('direccion_proveedor',250)->nullable();
            $table->string('departamento',100)->nullable();
            $table->string('provincia',100)->nullable();
            $table->string('distrito',100)->nullable();
            $table->string('ubigeo',6)->nullable();
            $table->integer('telefono_proveedor')->nullable();
            $table->integer('celular_proveedor')->nullable();
            $table->string('email_proveedor',30)->nullable();
            $table->string('web_proveedor',250)->nullable();
            $table->string('contacto_proveedor',250)->nullable();
            $table->string('proveedor_codigo',150)->nullable();
            $table->string('proveedor_password',150)->nullable();
            $table->integer('id_area')->nullable();
            $table->integer('id_banco')->nullable();
            $table->string('num_cuenta',15)->nullable();
            $table->string('id_departamento',10)->nullable();
            $table->string('id_provincia',10)->nullable();
            $table->string('id_distrito',10)->nullable();
            $table->text('referencia_proveedor')->nullable();
            $table->integer('id_tipo_servicio')->nullable();
            $table->string('coordsltd')->nullable();
            $table->string('coordslgt')->nullable();
            $table->string('responsable')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor_general');
    }
};

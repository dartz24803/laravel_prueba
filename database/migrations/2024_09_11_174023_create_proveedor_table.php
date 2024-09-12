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
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('id_proveedor');
            $table->unsignedBigInteger('tipo');
            $table->string('nombre_proveedor',250)->nullable();
            $table->string('ruc_proveedor',20)->nullable();
            $table->string('direccion_proveedor',250)->nullable();
            $table->string('telefono_proveedor',20)->nullable();
            $table->string('celular_proveedor',20)->nullable();
            $table->string('email_proveedor',100)->nullable();
            $table->string('web_proveedor',250)->nullable();
            $table->string('contacto_proveedor',250)->nullable();
            $table->string('proveedor_codigo',150)->nullable();
            $table->string('proveedor_password',150)->nullable();
            $table->integer('id_area')->nullable();
            $table->integer('id_banco')->nullable();
            $table->string('num_cuenta',15)->nullable();
            $table->integer('estado')->nullable();
            $table->datetime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->datetime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->datetime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->index(['tipo'], 'pro_idx_tip');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};

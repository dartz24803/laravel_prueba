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
        Schema::create('datos_servicio', function (Blueprint $table) {
            $table->id('id_datos_servicio');
            $table->string('cod_base',5)->nullable();
            $table->unsignedBigInteger('id_servicio');
            $table->integer('id_proveedor_servicio')->nullable();
            $table->integer('id_lugar_servicio')->nullable();
            $table->string('contrato_servicio',150)->nullable();
            $table->string('medidor',25)->nullable();
            $table->string('suministro',50)->nullable();
            $table->string('ruta',15)->nullable();
            $table->string('cliente',150)->nullable();
            $table->string('doc_cliente',15)->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_servicio','dser_fk_id_ser')->references('id_servicio')->on('servicio');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_servicio');
    }
};

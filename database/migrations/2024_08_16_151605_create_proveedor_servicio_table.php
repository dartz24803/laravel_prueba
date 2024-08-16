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
        Schema::create('proveedor_servicio', function (Blueprint $table) {
            $table->id('id_proveedor_servicio');
            $table->string('cod_proveedor_servicio',10)->nullable();
            $table->string('nom_proveedor_servicio',150)->nullable();
            $table->string('ruc_proveedor_servicio',11)->nullable();
            $table->string('dir_proveedor_servicio',50)->nullable();
            $table->string('tel_proveedor_servicio',50)->nullable();
            $table->string('contacto_proveedor_servicio',50)->nullable();
            $table->string('telefono_contacto',11)->nullable();
            $table->string('cod_base',5)->nullable();
            $table->unsignedBigInteger('id_servicio');
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_servicio','pser_fk_id_ser')->references('id_servicio')->on('servicio');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor_servicio');
    }
};

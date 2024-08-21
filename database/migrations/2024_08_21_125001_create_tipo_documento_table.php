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
        Schema::create('tipo_documento', function (Blueprint $table) {
            $table->id('id_tipo_documento');
            $table->string('cod_tipo_documento',10)->nullable();
            $table->string('cod_sunat',1)->nullable();
            $table->string('nom_tipo_documento',50)->nullable();
            $table->string('numero',4)->nullable();
            $table->string('desc_abreviada',100)->nullable();
            $table->string('observacion',250)->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_documento');
    }
};

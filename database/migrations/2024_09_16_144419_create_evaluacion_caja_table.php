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
        Schema::create('evaluacion_caja', function (Blueprint $table) {
            $table->id('id_evaluacion');
            $table->string('base',10)->nullable();
            $table->string('c_usua_caja',100)->nullable();
            $table->string('c_usua_nomb',100)->nullable();
            $table->time('h_ini')->nullable();
            $table->time('h_fin')->nullable();
            $table->string('c_codi_caja',11)->nullable();
            $table->time('tiempo')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_caja');
    }
};

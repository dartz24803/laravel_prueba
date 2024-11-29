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
        Schema::create('error_picking', function (Blueprint $table) {
            $table->id();
            $table->string('semana',10)->nullable();
            $table->string('pertenece',10)->nullable();
            $table->string('encontrado',10)->nullable();
            $table->integer('id_area')->nullable();
            $table->string('estilo',100)->nullable();
            $table->string('color',100)->nullable();
            $table->integer('id_talla')->nullable();
            $table->string('prendas_devueltas',10)->nullable();
            $table->integer('id_tipo_error')->nullable();
            $table->integer('id_responsable')->nullable();
            $table->integer('solucion')->nullable();
            $table->string('observacion',2000)->nullable();
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
        Schema::dropIfExists('error_picking');
    }
};

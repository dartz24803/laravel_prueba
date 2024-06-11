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
        Schema::create('puesto', function (Blueprint $table) {
            $table->id('id_puesto');
            $table->integer('id_direccion')->default(0)->nullable();
            $table->integer('id_gerencia')->default(0)->nullable();
            $table->integer('id_departamento')->default(0)->nullable();
            $table->integer('id_area')->default(0)->nullable();
            $table->string('nom_puesto', 200)->nullable();
            $table->text('proposito')->nullable();
            $table->integer('id_nivel')->default(0)->nullable();
            $table->integer('id_sede_laboral')->default(0)->nullable();
            $table->string('perfil_infosap', 5)->nullable();
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
        Schema::dropIfExists('puesto');
    }
};

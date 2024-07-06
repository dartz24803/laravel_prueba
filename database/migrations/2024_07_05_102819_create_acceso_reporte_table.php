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
        Schema::create('acceso_reporte', function (Blueprint $table) {
            $table->increments('id_acceso_reporte');
            $table->string('codigo', '50')->nullable();
            $table->string('nom_reporte', '250')->nullable();
            $table->text('id_area')->nullable();
            $table->text('iframe')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('acceso', 250)->nullable();
            $table->text('acceso_area')->nullable();
            $table->text('acceso_nivel')->nullable();
            $table->text('acceso_gerencia')->nullable();
            $table->text('acceso_base')->nullable();
            $table->integer('acceso_todo')->nullable();
            $table->text('div_puesto', '100')->nullable();
            $table->integer('div_base')->nullable();
            $table->integer('div_area')->nullable();
            $table->integer('div_nivel')->nullable();
            $table->integer('div_gerencia')->nullable();

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
        Schema::dropIfExists('acceso_reporte');
    }
};

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
        Schema::create('cargo', function (Blueprint $table) {
            $table->id('id_cargo');
            $table->unsignedBigInteger('id_direccion');
            $table->unsignedBigInteger('id_gerencia');
            $table->unsignedBigInteger('id_departamento');
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_puesto');
            $table->string('nom_cargo',200)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_direccion','car_fk_id_dir')->references('id_direccion')->on('direccion');
            $table->foreign('id_gerencia','car_fk_id_ger')->references('id_gerencia')->on('gerencia');
            $table->foreign('id_departamento','car_fk_id_dep')->references('id_sub_gerencia')->on('sub_gerencia');
            $table->foreign('id_area','car_fk_id_are')->references('id_area')->on('area');
            $table->foreign('id_puesto','car_fk_id_pue')->references('id_puesto')->on('puesto');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo');
    }
};
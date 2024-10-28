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
            $table->unsignedBigInteger('id_direccion');
            $table->string('nom_puesto',200)->nullable();
            $table->unsignedBigInteger('id_gerencia');
            $table->unsignedBigInteger('id_departamento');
            $table->unsignedBigInteger('id_area');
            $table->string('proposito',250)->nullable();
            $table->unsignedBigInteger('id_nivel');
            $table->unsignedBigInteger('id_sede_laboral');
            $table->string('perfil_infosap',5)->nullable();
            $table->integer('evaluador')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_direccion','pue_fk_id_dir')->references('id_direccion')->on('direccion');
            $table->foreign('id_gerencia','pue_fk_id_ger')->references('id_gerencia')->on('gerencia');
            $table->foreign('id_departamento','pue_fk_id_dep')->references('id_sub_gerencia')->on('sub_gerencia');
            $table->foreign('id_area','pue_fk_id_are')->references('id_area')->on('area');
            $table->foreign('id_nivel','pue_fk_id_niv')->references('id_nivel')->on('nivel_jerarquico');
            $table->foreign('id_sede_laboral','pue_fk_id_sed')->references('id')->on('sede_laboral');
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
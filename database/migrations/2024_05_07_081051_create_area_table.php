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
        Schema::create('area', function (Blueprint $table) {
            $table->id('id_area');
            $table->unsignedBigInteger('id_direccion');
            $table->unsignedBigInteger('id_gerencia');
            $table->unsignedBigInteger('id_departamento');
            $table->string('cod_area', 10)->nullable();
            $table->string('nom_area', 50)->nullable();
            $table->string('puestos', 255)->nullable();
            $table->string('orden', 2)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_direccion','are_fk_id_dir')->references('id_direccion')->on('direccion');
            $table->foreign('id_gerencia','are_fk_id_ger')->references('id_gerencia')->on('gerencia');
            $table->foreign('id_departamento','are_fk_id_dep')->references('id_sub_gerencia')->on('sub_gerencia');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area');
    }
};
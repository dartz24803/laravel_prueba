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
        Schema::create('gerencia', function (Blueprint $table) {
            $table->id('id_gerencia');
            $table->unsignedBigInteger('id_direccion');
            $table->string('cod_gerencia',10)->nullable();
            $table->string('nom_gerencia',50)->nullable();
            $table->integer('digitos_cuenta')->default(0)->nullable();
            $table->integer('digitos_cci')->default(0)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_direccion','ger_fk_id_dir')->references('id_direccion')->on('direccion');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerencia');
    }
};

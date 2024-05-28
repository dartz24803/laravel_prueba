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
        Schema::create('base', function (Blueprint $table) {
            $table->id('id_base');
            $table->string('cod_base', 10)->nullable();
            $table->string('nom_base', 50)->nullable();
            $table->integer('id_empresa')->nullable()->default(0);
            $table->string('id_departamento', 2)->nullable();
            $table->string('id_provincia', 4)->nullable();
            $table->string('id_distrito', 6)->nullable();
            $table->string('direccion', 200)->nullable();
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
        Schema::dropIfExists('base');
    }
};
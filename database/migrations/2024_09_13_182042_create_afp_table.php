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
        Schema::create('afp', function (Blueprint $table) {
            $table->id('id_afp');
            $table->unsignedBigInteger('id_sistema_pensionario');
            $table->string('cod_afp', 30);
            $table->string('nom_afp', 150);
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_sistema_pensionario', 'afp_fk_id_spen')->references('id_sistema_pensionario')->on('sistema_pensionario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('afp');
    }
};

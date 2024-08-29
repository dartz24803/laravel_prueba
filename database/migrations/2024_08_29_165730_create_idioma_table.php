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
        Schema::create('idioma', function (Blueprint $table) {
            $table->id('id_idioma');
            $table->string('cod_idioma', 10);
            $table->string('nom_idioma', 50);
            $table->integer('estado');
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
        Schema::dropIfExists('idioma');
    }
};

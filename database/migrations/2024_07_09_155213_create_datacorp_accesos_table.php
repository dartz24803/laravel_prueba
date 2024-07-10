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
        Schema::create('datacorp_accesos', function (Blueprint $table) {
            $table->id();
            $table->integer('area')->nullable();
            $table->integer('puesto')->nullable();
            $table->string('carpeta_acceso', 100)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable(); 
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('puesto')->references('id_puesto')->on('puesto');
            $table->foreign('area')->references('id_area')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datacorp_accesos');
    }
};

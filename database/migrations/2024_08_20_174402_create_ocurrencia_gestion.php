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
        Schema::create('ocurrencia_gestion', function (Blueprint $table) {
            $table->id('id_gestion'); 
            $table->string('nom_gestion', 50); 
            $table->integer('estado'); 
            $table->dateTime('fec_reg');
            $table->integer('user_reg'); 
            $table->dateTime('fec_act')->nullable(); 
            $table->integer('user_act')->nullable(); 
            $table->dateTime('fec_eli')->nullable(); 
            $table->integer('user_eli')->nullable(); 
            $table->integer('digitos'); 

            // $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocurrencia_gestion');
    }
};

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
        Schema::create('pregunta', function (Blueprint $table) {
            $table->id();
            $table->integer('id_puesto')->nullable();
            $table->integer('id_tipo')->nullable();
            $table->string('descripcion',500)->nullable();
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act');
            $table->integer('user_act');
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
        Schema::dropIfExists('pregunta');
    }
};
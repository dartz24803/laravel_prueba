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
        Schema::create('contenido_seguimiento_coordinador', function (Blueprint $table) {
            $table->id();
            $table->string('base', 20)->nullable();
            $table->integer('id_area')->default(0)->nullable();
            $table->integer('id_periocidad')->default(0)->nullable();
            $table->integer('nom_dia_1')->default(0)->nullable();
            $table->integer('nom_dia_2')->default(0)->nullable();
            $table->integer('nom_dia_3')->default(0)->nullable();
            $table->integer('dia_1')->default(0)->nullable();
            $table->integer('dia_2')->default(0)->nullable();
            $table->integer('dia')->default(0)->nullable();
            $table->integer('mes')->default(0)->nullable();
            $table->string('descripcion', 500)->nullable();
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
        Schema::dropIfExists('contenido_seguimiento_coordinador');
    }
};

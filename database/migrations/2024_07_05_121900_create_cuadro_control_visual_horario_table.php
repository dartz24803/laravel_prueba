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
        Schema::create('cuadro_control_visual_horario', function (Blueprint $table) {
            $table->increments('id_cuadro_control_visual_horario');
            $table->integer('id_usuario')->nullable();
            $table->integer('horario')->nullable();
            $table->integer('dia')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuadro_control_visual_horario');
    }
};

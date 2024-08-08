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
            $table->id('id_cuadro_control_visual_horario');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('horario')->nullable();
            $table->integer('dia')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->foreign('id_usuario','ccvhor_fk_id_usu')->references('id_usuario')->on('users');
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

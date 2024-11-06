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
        Schema::create('ropa_usuario', function (Blueprint $table) {
            $table->id('id_ropa_usuario');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('polo')->nullable();
            $table->integer('camisa')->nullable();
            $table->integer('pantalon')->nullable();
            $table->integer('zapato')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'rusu_fk_id_usu')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ropa_usuario');
    }
};

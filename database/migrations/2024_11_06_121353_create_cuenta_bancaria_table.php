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
        Schema::create('cuenta_bancaria', function (Blueprint $table) {
            $table->id('id_cuenta_bancaria');
            $table->unsignedBigInteger('id_usuario');
            $table->integer('id_banco')->nullable();
            $table->integer('cuenta_bancaria')->nullable();
            $table->string('num_cuenta_bancaria',25)->nullable();
            $table->string('num_codigo_interbancario',30)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'cban_fk_id_usu')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuenta_bancaria');
    }
};

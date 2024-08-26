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
        Schema::create('error', function (Blueprint $table) {
            $table->id('id_error');
            $table->string('nom_error',50)->nullable();
            $table->unsignedBigInteger('id_tipo_error')->nullable();
            $table->integer('monto')->nullable();
            $table->integer('automatico')->nullable();
            $table->integer('archivo')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_tipo_error','err_fk_id_terr')->references('id_tipo_error')->on('tipo_error');
            $table->index(['id_tipo_error'], 'idx_id_terr');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error');
    }
};

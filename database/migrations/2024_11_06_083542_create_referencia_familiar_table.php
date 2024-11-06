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
        Schema::create('referencia_familiar', function (Blueprint $table) {
            $table->id('id_referencia_familiar');
            $table->unsignedBigInteger('id_usuario');
            $table->text('nom_familiar')->nullable();
            $table->unsignedBigInteger('id_parentesco');
            $table->string('dia_nac',2)->nullable();
            $table->string('mes_nac',2)->nullable();
            $table->string('anio_nac',4)->nullable();
            $table->date('fec_nac')->nullable();
            $table->string('celular1',15)->nullable();
            $table->string('celular2',15)->nullable();
            $table->string('fijo',15)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'rfam_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_parentesco', 'rfam_fk_id_par')->references('id_parentesco')->on('parentesco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencia_familiar');
    }
};

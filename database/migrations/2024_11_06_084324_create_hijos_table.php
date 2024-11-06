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
        Schema::create('hijos', function (Blueprint $table) {
            $table->id('id_hijos');
            $table->unsignedBigInteger('id_usuario');
            $table->text('nom_hijo')->nullable();
            $table->unsignedBigInteger('id_genero');
            $table->string('dia_nac',2)->nullable();
            $table->string('mes_nac',2)->nullable();
            $table->string('anio_nac',4)->nullable();
            $table->date('fec_nac')->nullable();
            $table->string('num_doc',15)->nullable();
            $table->integer('id_biologico')->nullable();
            $table->string('documento')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'hij_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_genero', 'hij_fk_id_gen')->references('id_genero')->on('genero');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hijos');
    }
};

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
        Schema::create('contacto_emergencia', function (Blueprint $table) {
            $table->id('id_contacto_emergencia');
            $table->unsignedBigInteger('id_usuario');
            $table->text('nom_contacto')->nullable();
            $table->unsignedBigInteger('id_parentesco');
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
            $table->foreign('id_usuario', 'ceme_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_parentesco', 'ceme_fk_id_par')->references('id_parentesco')->on('parentesco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacto_emergencia');
    }
};

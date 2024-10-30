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
        Schema::create('domicilio_users', function (Blueprint $table) {
            $table->id('id_domicilio_users');
            $table->unsignedBigInteger('id_usuario');
            $table->string('id_departamento',2)->nullable(); //NO SIRVE, solo queda distrito
            $table->string('id_provincia',4)->nullable(); //NO SIRVE, solo queda distrito
            $table->string('id_distrito',6);
            $table->integer('id_tipo_via')->nullable();
            $table->string('nom_via',100)->nullable();
            $table->string('num_via',10)->nullable();
            $table->string('kilometro',5)->nullable();
            $table->string('manzana',5)->nullable();
            $table->string('lote',5)->nullable();
            $table->string('interior',5)->nullable();
            $table->string('departamento',5)->nullable();
            $table->string('piso',2)->nullable();
            $table->integer('id_zona')->nullable();
            $table->string('nom_zona',150)->nullable();
            $table->string('referencia',200)->nullable();
            $table->integer('id_tipo_vivienda')->nullable();
            $table->decimal('lat',10,6)->nullable();
            $table->decimal('lng',10,6)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'dusr_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_distrito', 'dusr_fk_id_dis')->references('id_distrito')->on('distrito');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicilio_users');
    }
};

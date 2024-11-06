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
        Schema::create('experiencia_laboral', function (Blueprint $table) {
            $table->id('id_experiencia_laboral');
            $table->unsignedBigInteger('id_usuario');
            $table->string('empresa',150)->nullable();
            $table->string('cargo',150)->nullable();
            $table->string('dia_ini',2)->nullable();
            $table->string('mes_ini',2)->nullable();
            $table->string('anio_ini',4)->nullable();
            $table->date('fec_ini')->nullable();
            $table->integer('actualidad')->nullable();
            $table->string('dia_fin',2)->nullable();
            $table->string('mes_fin',2)->nullable();
            $table->string('anio_fin',4)->nullable();
            $table->date('fec_fin')->nullable();
            $table->string('motivo_salida',150)->nullable();
            $table->decimal('remuneracion',10,2)->nullable();
            $table->string('nom_referencia_labores',150)->nullable();
            $table->string('num_contacto',15)->nullable();
            $table->string('certificado')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'elab_fk_id_usu')->references('id_usuario')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiencia_laboral');
    }
};

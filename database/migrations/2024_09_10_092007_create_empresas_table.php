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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('cod_empresa', 10)->nullable();
            $table->string('nom_empresa', 150)->nullable();
            $table->string('ruc_empresa', 11)->nullable();
            $table->unsignedBigInteger('id_banco')->nullable();
            $table->string('num_cuenta', 20)->nullable();
            $table->string('email_empresa', 150)->nullable();
            $table->string('representante_empresa', 150)->nullable();
            $table->unsignedBigInteger('id_tipo_documento')->nullable();
            $table->string('num_documento', 15)->nullable();
            $table->string('num_partida', 10)->nullable();
            $table->string('id_departamento', 2)->nullable();
            $table->string('id_distrito', 6)->nullable();
            $table->string('id_provincia', 4);
            $table->string('direccion', 200)->nullable();
            $table->char('activo', 1);
            $table->unsignedBigInteger('id_regimen')->nullable();
            $table->integer('telefono_empresa');
            $table->date('inicio_actividad')->nullable();
            $table->integer('dias_laborales');
            $table->integer('hora_dia');
            $table->integer('aporte_senati');
            $table->text('firma');
            $table->text('logo');
            $table->text('pie');
            $table->integer('estado')->nullable();
            $table->datetime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->datetime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->datetime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};

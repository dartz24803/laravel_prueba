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
        Schema::create('historico_colaborador', function (Blueprint $table) {
            $table->id('id_historico_colaborador');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_situacion_laboral');
            $table->date('fec_inicio')->nullable();
            $table->date('fec_vencimiento')->nullable();
            $table->date('fec_fin')->nullable();
            $table->integer('motivo_fin')->nullable();
            $table->integer('id_empresa')->nullable();
            $table->integer('id_regimen')->nullable();
            $table->integer('id_tipo_contrato')->nullable();
            $table->decimal('sueldo',10,2)->nullable();
            $table->decimal('bono',10,2)->nullable();
            $table->string('observacion')->nullable();
            $table->decimal('movilidad',10,2)->nullable();
            $table->decimal('refrigerio',10,2)->nullable();
            $table->decimal('asignacion_educac',10,2)->nullable();
            $table->decimal('vale_alimento',10,2)->nullable();
            $table->decimal('otra_remun',10,2)->nullable();
            $table->decimal('remun_exoner',10,2)->nullable();
            $table->decimal('hora_mes',10,2)->nullable();
            $table->integer('estado_intermedio')->nullable();
            $table->integer('id_motivo_cese')->nullable();
            $table->text('archivo_cese')->nullable();
            $table->integer('flag_cesado')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_usuario', 'hcol_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_situacion_laboral', 'hcol_fk_id_slab')->references('id_situacion_laboral')->on('situacion_laboral');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_colaborador');
    }
};

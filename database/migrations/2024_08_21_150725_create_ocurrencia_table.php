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
        Schema::create('ocurrencia', function (Blueprint $table) {
            $table->id('id_ocurrencia');
            $table->unsignedBigInteger('id_usuario');
            $table->string('cod_base',5)->nullable();
            $table->string('cod_ocurrencia',20)->nullable();
            $table->date('fec_ocurrencia')->nullable();
            $table->time('hora_ocurrencia')->nullable();
            $table->unsignedBigInteger('id_tipo');
            $table->integer('id_zona')->nullable();
            $table->integer('id_estilo')->nullable();
            $table->integer('id_conclusion')->nullable();
            $table->unsignedBigInteger('id_gestion');
            $table->decimal('monto',10,2)->nullable();
            $table->integer('cantidad')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('accion_inmediata')->nullable();
            $table->integer('revisado')->nullable();
            $table->dateTime('fec_revisado')->nullable();
            $table->integer('user_revisado')->nullable();
            $table->time('hora')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_usuario','ocu_fk_id_usu')->references('id_usuario')->on('users');
            $table->foreign('id_tipo','ocu_fk_id_tip')->references('id_tipo_ocurrencia')->on('tipo_ocurrencia');
            $table->foreign('id_gestion','ocu_fk_id_ges')->references('id_gestion')->on('ocurrencia_gestion');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocurrencia');
    }
};

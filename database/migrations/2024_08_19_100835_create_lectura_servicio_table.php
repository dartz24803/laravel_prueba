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
        Schema::create('lectura_servicio', function (Blueprint $table) {
            $table->id();
            $table->string('cod_base',5)->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora_ing')->nullable();
            $table->decimal('lect_ing',10,3)->nullable();
            $table->string('img_ing',100)->nullable();
            $table->time('hora_sal')->nullable();
            $table->decimal('lect_sal',10,3)->nullable();
            $table->string('img_sal',100)->nullable();
            $table->unsignedBigInteger('id_servicio');
            $table->unsignedBigInteger('id_datos_servicio');
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_servicio','lser_fk_id_ser')->references('id_servicio')->on('servicio');
            $table->foreign('id_datos_servicio','lser_fk_id_dser')->references('id_datos_servicio')->on('datos_servicio');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectura_servicio');
    }
};

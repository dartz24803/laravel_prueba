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
        Schema::create('tracking_devolucion', function (Blueprint $table) { 
            $table->id();
            $table->unsignedBigInteger('id_tracking');
            $table->unsignedBigInteger('id_producto');
            $table->text('tipo_falla')->nullable();
            $table->integer('cantidad')->nullable();
            $table->integer('aprobacion')->nullable();
            $table->text('sustento_respuesta')->nullable();
            $table->text('forma_proceder')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_tracking','tra_fk_id_tra')->references('id')->on('tracking');
            $table->foreign('id_producto','tra_fk_id_pro')->references('id')->on('tracking_guia_remision_detalle');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_devolucion');
    }
};

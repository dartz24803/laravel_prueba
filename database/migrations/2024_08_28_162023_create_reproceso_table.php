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
        Schema::create('reproceso', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_documento');
            $table->string('documento', 100);
            $table->unsignedBigInteger('usuario');
            $table->string('descripcion', 1000);
            $table->integer('cantidad');
            $table->string('proveedor', 1000);
            $table->integer('estado_r');
            $table->integer('estado');
            $table->dateTime('fec_reg');
            $table->integer('user_reg');
            $table->dateTime('fec_act');
            $table->integer('user_act');
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('usuario', 'reproceso_fk_usuario')->references('id')->on('usuario_reproceso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reproceso');
    }
};

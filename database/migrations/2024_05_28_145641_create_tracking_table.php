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
        Schema::create('tracking', function (Blueprint $table) {
            $table->id();
            $table->string('n_requerimiento', 10)->nullable();
            $table->string('n_guia_remision', 20)->nullable();
            $table->string('semana', 2)->nullable();
            $table->integer('id_origen_desde')->nullable()->default(0);
            $table->string('desde', 50)->nullable();
            $table->integer('id_origen_hacia')->nullable()->default(0);
            $table->string('hacia', 50)->nullable();
            $table->string('guia_transporte', 20)->nullable();
            $table->decimal('peso', 10, 2)->nullable()->default(0);
            $table->integer('paquetes')->nullable()->default(0);
            $table->integer('sobres')->nullable()->default(0);
            $table->integer('fardos')->nullable()->default(0);
            $table->integer('bultos')->nullable()->default(0);
            $table->integer('caja')->nullable()->default(0);
            $table->integer('transporte')->nullable()->default(0);
            $table->string('nombre_transporte', 1000)->nullable();
            $table->decimal('importe_transporte', 10, 2)->nullable()->default(0);
            $table->string('factura_transporte', 20)->nullable();
            $table->string('observacion_inspf', 1000)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking');
    }
};
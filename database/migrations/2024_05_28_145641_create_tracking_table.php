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
            $table->string('n_requerimiento', 10);
            $table->string('n_guia_remision', 20);
            $table->string('semana', 2);
            $table->integer('id_origen_desde');
            $table->string('desde', 50);
            $table->integer('id_origen_hacia');
            $table->string('hacia', 50);
            $table->string('guia_transporte', 20);
            $table->decimal('peso', 10, 2);

            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            $table->integer('id_origen_hacia');
            
            $table->timestamps();
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

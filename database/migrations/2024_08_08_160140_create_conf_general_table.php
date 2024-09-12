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
        Schema::create('conf_general', function (Blueprint $table) {
            $table->string('codigo_primario');
            $table->string('codigo_secundario');
            $table->string('valor')->nullable();
            $table->string('descripcion')->nullable();
            // Definir claves primarias compuestas
            $table->primary(['codigo_primario', 'codigo_secundario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conf_general');
    }
};

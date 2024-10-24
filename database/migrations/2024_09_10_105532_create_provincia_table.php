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
        Schema::create('provincia', function (Blueprint $table) {
            $table->string('id_provincia', 4)->primary();
            $table->string('nombre_provincia', 45);
            $table->string('id_departamento', 2);
            $table->integer('estado');
            $table->foreign('id_departamento')->references('id_departamento', 'provincia_fk_id_departamento')->on('departamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provincia');
    }
};

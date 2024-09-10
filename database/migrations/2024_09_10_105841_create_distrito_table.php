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
        Schema::create('distrito', function (Blueprint $table) {
            $table->string('id_distrito', 6)->primary();
            $table->string('nombre_distrito', 45);
            $table->string('id_provincia', 4);
            $table->string('id_departamento', 2);
            $table->integer('estado');

            $table->foreign('id_provincia', 'distrito_fk_id_provincia')->references('id_provincia')->on('provincia');
            $table->foreign('id_departamento', 'distrito_fk_id_id_departamento')->references('id_departamento')->on('departamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distrito');
    }
};

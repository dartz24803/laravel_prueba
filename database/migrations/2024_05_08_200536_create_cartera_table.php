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
        Schema::create('cartera', function (Blueprint $table) {
            $table->id('id_cartera');
            $table->string('codigo', 11);
            $table->string('ruc', 11);
            $table->string('razon_social', 100);
            $table->string('nombre_comercial', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartera');
    }
};

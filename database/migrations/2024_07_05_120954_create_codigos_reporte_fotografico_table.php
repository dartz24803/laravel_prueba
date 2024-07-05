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
        Schema::create('codigos_reporte_fotografico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 100)->nullable();
            $table->string('tipo', 100)->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigos_reporte_fotografico');
    }
};

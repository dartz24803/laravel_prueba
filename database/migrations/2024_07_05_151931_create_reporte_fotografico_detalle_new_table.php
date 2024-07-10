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
        Schema::create('reporte_fotografico_detalle_new', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_reporte_fotografico_adm')->nullable();
            $table->integer('id_area')->nullable();
            $table->foreign('id_area')->references('id_area')->on('area');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_fotografico_detalle_new');
    }
};

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
        Schema::create('reporte_fotografico_archivo_temporal_new', function (Blueprint $table) {
            $table->id();
            $table->string('ruta', 100)->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario','rfatnew_fk_id_usu')->references('id_usuario')->on('users');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_fotografico_archivo_temporal_new');
    }
};

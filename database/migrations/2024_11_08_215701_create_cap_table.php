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
        Schema::create('cap', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->unsignedBigInteger('id_ubicacion');
            $table->unsignedBigInteger('id_puesto');
            $table->decimal('aprobado',10,2)->nullable();
            $table->decimal('asistencia',10,2)->nullable();
            $table->decimal('libre',10,2)->nullable();
            $table->decimal('falta',10,2)->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->foreign('id_ubicacion', 'cap_fk_id_ubi')->references('id_ubicacion')->on('ubicacion');
            $table->foreign('id_puesto', 'cap_fk_id_pue')->references('id_puesto')->on('puesto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cap');
    }
};

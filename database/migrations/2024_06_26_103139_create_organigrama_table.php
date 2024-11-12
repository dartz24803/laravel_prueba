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
        Schema::create('organigrama', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_puesto');
            $table->integer('id_usuario')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->unsignedBigInteger('usuario');
            $table->foreign('id_puesto','org_fk_id_pue')->references('id_puesto')->on('puesto');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organigrama');
    }
};

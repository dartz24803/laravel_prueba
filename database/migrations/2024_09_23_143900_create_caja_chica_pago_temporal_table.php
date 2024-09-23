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
        Schema::create('caja_chica_pago_temporal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->date('fecha')->nullable();
            $table->decimal('monto',10,2)->nullable();
            $table->foreign('id_usuario', 'ccptem_fk_id_usu')->references('id_usuario')->on('users');
            $table->index(['id_usuario'], 'ccptem_idx_id_usu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica_pago_temporal');
    }
};

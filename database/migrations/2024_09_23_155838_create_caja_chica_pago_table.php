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
        Schema::create('caja_chica_pago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_caja_chica');
            $table->date('fecha')->nullable();
            $table->decimal('monto',10,2)->nullable();
            $table->foreign('id_caja_chica', 'ccpag_fk_id_cchi')->references('id')->on('caja_chica');
            $table->index(['id_caja_chica'], 'ccpag_idx_id_cchi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica_pago');
    }
};

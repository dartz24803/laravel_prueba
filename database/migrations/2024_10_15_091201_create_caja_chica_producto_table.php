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
        Schema::create('caja_chica_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_caja_chica');
            $table->integer('cantidad')->nullable();
            $table->string('producto',1000)->nullable();
            $table->decimal('precio',10,2)->nullable();
            $table->foreign('id_caja_chica', 'ccpro_fk_id_cchi')->references('id')->on('caja_chica');
            $table->index(['id_caja_chica'], 'ccpro_idx_id_cchi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica_producto');
    }
};

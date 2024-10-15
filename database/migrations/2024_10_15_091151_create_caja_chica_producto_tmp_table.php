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
        Schema::create('caja_chica_producto_tmp', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario')->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('producto',1000)->nullable();
            $table->decimal('precio',10,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_chica_producto_tmp');
    }
};

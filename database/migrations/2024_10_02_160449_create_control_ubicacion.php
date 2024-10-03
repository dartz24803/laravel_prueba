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
        Schema::create('control_ubicacion', function (Blueprint $table) {
            $table->id('id_control_ubicacion');
            $table->string('cod_control', 50)->nullable();
            $table->string('id_nicho', 200)->collation('utf8mb3_bin');
            $table->string('estilo', 250)->nullable()->collation('utf8mb3_bin');
            $table->date('fecha')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_ubicacion');
    }
};

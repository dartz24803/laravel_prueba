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
        Schema::create('zona_p', function (Blueprint $table) {
            $table->id('id_zona');
            $table->string('numero', 15)->nullable();
            $table->string('descripcion', 80)->nullable();
            $table->integer('estado')->nullable();
            $table->datetime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->datetime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->datetime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_p');
    }
};

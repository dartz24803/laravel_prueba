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
        Schema::create('tramite', function (Blueprint $table) {
            $table->id('id_tramite');
            $table->unsignedBigInteger('id_destino');
            $table->string('nom_tramite', 50);
            $table->string('cantidad_uso', 10);
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();

            // Foreign key
            $table->foreign('id_destino', 'tramite_fk_id_destino')->references('id_destino')->on('destino');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tramite');
    }
};

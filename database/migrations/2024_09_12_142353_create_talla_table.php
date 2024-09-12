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
        Schema::create('talla', function (Blueprint $table) {
            $table->id('id_talla'); // Equivalente a int(11) AI PK
            $table->string('cod_talla', 10)->nullable();
            $table->string('nom_talla', 50)->nullable();
            $table->integer('estado')->nullable();
            $table->datetime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->datetime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->datetime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->unsignedBigInteger('id_accesorio')->nullable();

            // Definir la clave foránea
            $table->foreign('id_accesorio', 'talla_fk_id_accesorio')->references('id_accesorio')->on('accesorio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talla');
    }
};

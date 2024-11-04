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
        Schema::create('slide', function (Blueprint $table) {
            $table->id('id_slide');
            $table->unsignedBigInteger('id_area');
            $table->string('base', 10)->nullable();
            $table->integer('orden')->nullable();
            $table->string('nom_slide', 50)->nullable();
            $table->string('titulo', 50)->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('entrada_slide', 3, 1)->nullable();
            $table->decimal('salida_slide', 3, 1)->nullable();
            $table->integer('duracion')->nullable();
            $table->integer('tipo_slide')->nullable();
            $table->text('archivoslide')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_area','sli_fk_id_are')->references('id_area')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slide');
    }
};

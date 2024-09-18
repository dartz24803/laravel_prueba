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
        Schema::create('sub_categoria', function (Blueprint $table) { 
            $table->id('id');
            $table->unsignedBigInteger('id_categoria');
            $table->string('nombre')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_categoria', 'scat_fk_id_cat')->references('id_categoria')->on('categoria');
            $table->index(['id_categoria'], 'scat_idx_id_cat');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categoria');
    }
};

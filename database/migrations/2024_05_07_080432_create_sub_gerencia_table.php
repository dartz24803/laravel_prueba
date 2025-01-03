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
        Schema::create('sub_gerencia', function (Blueprint $table) {
            $table->id('id_sub_gerencia');
            $table->unsignedBigInteger('id_gerencia');
            $table->string('nom_sub_gerencia', 100)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_gerencia','sger_fk_id_ger')->references('id_gerencia')->on('gerencia');
            $table->index(['id_gerencia'], 'sger_idx_id_ger');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_gerencia');
    }
};

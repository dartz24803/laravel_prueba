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
        Schema::create('eval_rrhh_postulante', function (Blueprint $table) {
            $table->id('id_eval_rrhh_postulante');
            $table->unsignedBigInteger('id_postulante');
            $table->integer('resultado')->nullable();
            $table->string('eval_sicologica')->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->foreign('id_postulante', 'erpos_fk_id_pos')->references('id_postulante')->on('postulante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eval_rrhh_postulante');
    }
};

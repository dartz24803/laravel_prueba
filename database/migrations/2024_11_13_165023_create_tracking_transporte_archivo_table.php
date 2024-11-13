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
        Schema::create('tracking_transporte_archivo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tracking_transporte');
            $table->string('archivo')->nullable();
            $table->foreign('id_tracking_transporte', 'ttarc_fk_id_ttra')->references('id')->on('tracking_transporte');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_transporte_archivo');
    }
};

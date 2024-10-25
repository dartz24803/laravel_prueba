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
        Schema::create('tracking_estado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_proceso');
            $table->string('descripcion', 100)->nullable();
            $table->foreign('id_proceso','test_fk_id_pro')->references('id')->on('tracking_proceso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_estado');
    }
};

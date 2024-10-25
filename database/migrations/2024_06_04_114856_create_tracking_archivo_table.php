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
        Schema::create('tracking_archivo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tracking');
            $table->integer('tipo')->nullable();
            $table->integer('id_producto')->nullable();
            $table->string('archivo', 100)->nullable();
            $table->foreign('id_tracking','tarc_fk_id_tra')->references('id')->on('tracking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_archivo');
    }
};

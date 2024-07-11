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
        Schema::create('tracking_notificacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tracking');
            $table->string('titulo')->nullable();
            $table->string('contenido',1000)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->foreign('id_tracking','tnot_id_tra')->references('id')->on('tracking');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_notificacion');
    }
};

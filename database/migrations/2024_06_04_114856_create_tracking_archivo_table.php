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
            $table->integer('id_tracking')->nullable()->default(0);
            $table->integer('tipo')->nullable()->default(0);
            $table->integer('id_producto')->nullable()->default(0);
            $table->string('archivo', 100)->nullable();
            //$table->timestamps();
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

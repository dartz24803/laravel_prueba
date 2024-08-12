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
        Schema::create('control_camara_archivo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_control_camara');
            $table->integer('id_ronda')->nullable();
            $table->string('archivo',100)->nullable();
            $table->string('descripcion',100);
            $table->foreign('id_control_camara','ccarc_fk_id_ccam')->references('id')->on('control_camara');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_camara_archivo');
    }
};

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
        Schema::create('area_ubicacion', function (Blueprint $table) {
            $table->id('id_area_ubicacion'); // Equivalent to int(11) AI PK
            $table->integer('id_ubicacion'); // Equivalent to int(11)
            $table->unsignedBigInteger('id_area'); // Equivalent to int(11)
            $table->datetime('fec_reg'); // Equivalent to datetime
            $table->integer('user_reg'); // Equivalent to int(11)
            $table->datetime('fec_act'); // Equivalent to datetime
            $table->integer('user_act'); // Equivalent to int(11)
            $table->foreign('id_area','aubi_fk_id_are')->references('id_area')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_ubicacion');
    }
};

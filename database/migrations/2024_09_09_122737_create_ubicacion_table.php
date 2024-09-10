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
        Schema::create('ubicacion', function (Blueprint $table) {
            $table->id('id_ubicacion'); // Equivalent to int(11) AI PK
            $table->string('cod_ubi', 50); // Equivalent to varchar(50)
            $table->integer('id_sede'); // Equivalent to int(11)
            $table->integer('estado'); // Equivalent to int(11)
            $table->datetime('fec_reg'); // Equivalent to datetime
            $table->integer('user_reg'); // Equivalent to int(11)
            $table->datetime('fec_act'); // Equivalent to datetime
            $table->integer('user_act'); // Equivalent to int(11)
            $table->datetime('fec_eli')->nullable(); // Equivalent to datetime
            $table->integer('user_eli')->nullable(); // Equivalent to int(11)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubicacion');
    }
};

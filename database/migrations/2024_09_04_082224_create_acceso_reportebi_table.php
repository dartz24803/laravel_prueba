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
        Schema::create('acceso_bi_reporte', function (Blueprint $table) {
            $table->id('id_acceso_bi_reporte'); // Primary key with auto-increment
            $table->string('codigo', 50);
            $table->string('nom_reporte', 250);
            $table->text('id_area'); // Text field to store area IDs
            $table->text('iframe'); // Text field to store iframe
            $table->text('descripcion'); // Text field for description
            $table->text('acceso'); // Text field for access
            $table->integer('acceso_todo')->default(0); // Integer field for access to everything, defaulting to 0
            $table->integer('estado')->default(1); // Integer field for status, defaulting to 1 (active)
            $table->dateTime('fec_reg')->nullable(); // DateTime field for registration date
            $table->integer('user_reg')->nullable(); // Integer field for user registration ID
            $table->dateTime('fec_act')->nullable(); // DateTime field for update date
            $table->integer('user_act')->nullable(); // Integer field for user update ID
            $table->dateTime('fec_eli')->nullable(); // DateTime field for deletion date
            $table->integer('user_eli')->nullable(); // Integer field for user deletion ID
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acceso_bi_reporte');
    }
};

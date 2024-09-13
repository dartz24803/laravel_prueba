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
            $table->string('estado_act', 50); // Varchar field for state
            $table->string('nom_bi', 50); // Varchar field for BI name
            $table->string('nom_intranet', 50); // Varchar field for intranet name
            $table->integer('id_usuario'); // Integer field for user ID
            $table->string('actividad', 50); // Varchar field for activity
            $table->integer('id_area'); // Integer field for area ID
            $table->integer('frecuencia_act'); // Integer field for activity frequency
            $table->text('tablas'); // Text field for tables
            $table->text('objetivo'); // Text field for objective
            $table->text('iframe'); // Text field for iframe
            $table->integer('acceso_todo')->default(0); // Integer field for access to everything, defaulting to 0
            $table->integer('estado')->default(1); // Integer field for status, defaulting to 1 (active)
            $table->dateTime('fec_reg')->nullable(); // DateTime field for registration date
            $table->integer('user_reg')->nullable(); // Integer field for user registration ID
            $table->dateTime('fec_act')->nullable(); // DateTime field for update date
            $table->integer('user_act')->nullable(); // Integer field for user update ID
            $table->dateTime('fec_eli')->nullable(); // DateTime field for deletion date
            $table->integer('user_eli')->nullable(); // Integer field for user deletion ID
            $table->dateTime('fec_valid')->nullable(); // DateTime field for validation date
            $table->integer('estado_valid')->default(0); // Integer field for validation state, defaulting to 0
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

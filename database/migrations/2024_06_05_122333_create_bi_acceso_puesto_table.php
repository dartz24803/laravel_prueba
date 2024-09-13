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
        Schema::create('bi_puesto_acceso', function (Blueprint $table) {
            $table->id('id_bi_puesto_acceso'); // Primary key with auto-increment
            $table->integer('id_acceso_bi_reporte'); // Foreign key to acceso_bi_reporte table
            $table->integer('id_puesto'); // Integer field for puesto (position) ID
            $table->dateTime('fec_reg')->nullable(); // DateTime field for registration date
            $table->integer('user_reg')->nullable(); // Integer field for user registration ID
            $table->dateTime('fec_act')->nullable(); // DateTime field for update date
            $table->integer('user_act')->nullable(); // Integer field for user update ID

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bi_puesto_acceso');
    }
};

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
        Schema::table('caja_chica_ruta_tmp', function (Blueprint $table) {
            $table->dropColumn('personas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caja_chica_ruta_tmp', function (Blueprint $table) {
            $table->integer('personas')->nullable()->after('id_usuario');
        });
    }
};

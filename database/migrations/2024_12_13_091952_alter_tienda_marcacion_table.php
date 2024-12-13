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
        Schema::table('tienda_marcacion', function (Blueprint $table) {
            $table->dropColumn('cantidad_foto');
            $table->integer('cant_foto_ingreso')->nullable()->after('cod_base');
            $table->integer('cant_foto_apertura')->nullable()->after('cant_foto_ingreso');
            $table->integer('cant_foto_cierre')->nullable()->after('cant_foto_apertura');
            $table->integer('cant_foto_salida')->nullable()->after('cant_foto_cierre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tienda_marcacion', function (Blueprint $table) {
            $table->integer('cantidad_foto')->nullable()->after('cod_base');
            $table->dropColumn('cant_foto_ingreso');
            $table->dropColumn('cant_foto_apertura');
            $table->dropColumn('cant_foto_cierre');
            $table->dropColumn('cant_foto_salida');
        });
    }
};

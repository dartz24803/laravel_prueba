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
        Schema::table('tracking_transporte', function (Blueprint $table) {
            $table->string('guia_remision')->nullable()->after('guia_transporte');
            $table->dropColumn('archivo_transporte');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_transporte', function (Blueprint $table) {
            $table->dropColumn('guia_remision');
            $table->string('archivo_transporte')->nullable()->after('factura_transporte');
        });
    }
};

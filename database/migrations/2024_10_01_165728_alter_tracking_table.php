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
        Schema::table('tracking', function (Blueprint $table) {
            $table->dropColumn('guia_diferencia');
            $table->string('guia_sobrante',20)->nullable()->after('diferencia');
            $table->string('guia_faltante',20)->nullable()->after('guia_sobrante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->string('guia_diferencia',20)->nullable()->after('diferencia');
            $table->dropColumn('guia_sobrante');
            $table->dropColumn('guia_faltante');
        });
    }
};

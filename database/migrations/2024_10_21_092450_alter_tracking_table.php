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
            $table->integer('v_sobrante')->nullable()->after('guia_faltante');
            $table->integer('v_faltante')->nullable()->after('v_sobrante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->dropColumn('v_sobrante');
            $table->dropColumn('v_faltante');
        });
    }
};

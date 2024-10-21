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
            $table->string('anio',4)->nullable()->after('id_base');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_transporte', function (Blueprint $table) {
            $table->dropColumn('anio');
        });
    }
};

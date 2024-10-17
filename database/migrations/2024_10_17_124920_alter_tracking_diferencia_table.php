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
        Schema::table('tracking_diferencia', function (Blueprint $table) {
            $table->string('observacion')->nullable()->after('recibido');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_diferencia', function (Blueprint $table) {
            $table->dropColumn('observacion');
        });
    }
};

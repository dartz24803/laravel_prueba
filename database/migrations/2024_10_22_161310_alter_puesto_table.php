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
        Schema::table('puesto', function (Blueprint $table) {
            $table->integer('evaluador')->nullable()->after('perfil_infosap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('puesto', function (Blueprint $table) {
            $table->dropColumn('evaluador');
        });
    }
};

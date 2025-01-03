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
        Schema::table('organigrama', function (Blueprint $table) {
            $table->integer('temporal')->nullable()->after('id_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organigrama', function (Blueprint $table) {
            $table->dropColumn('temporal');
        });
    }
};

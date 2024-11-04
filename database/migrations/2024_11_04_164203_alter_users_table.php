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
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_id_ger');
            $table->dropColumn('id_gerencia');
            $table->dropColumn('id_sub_gerencia');
            $table->dropColumn('id_area');
            $table->dropColumn('id_cargo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('id_gerencia')->nullable()->after('horas_semanales');
            $table->integer('id_sub_gerencia')->nullable()->after('id_gerencia');
            $table->integer('id_area')->nullable()->after('id_sub_gerencia');
            $table->integer('id_cargo')->nullable()->after('id_puesto');
            $table->index(['id_gerencia'], 'idx_id_ger');
        });
    }
};

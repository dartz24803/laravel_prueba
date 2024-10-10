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
            $table->dropColumn('fardo_prenda');
            $table->decimal('flete_prenda',10,2)->nullable()->after('mercaderia_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->decimal('fardo_prenda',10,2)->nullable()->after('mercaderia_total');
            $table->dropColumn('flete_prenda');
        });
    }
};

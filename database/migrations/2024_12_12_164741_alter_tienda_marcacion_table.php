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
            $table->integer('cantidad_foto')->nullable()->after('cod_base');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tienda_marcacion', function (Blueprint $table) {
            $table->dropColumn('cantidad_foto');
        });
    }
};

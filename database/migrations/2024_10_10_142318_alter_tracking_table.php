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
            $table->integer('recepcion')->nullable()->after('tiempo_llegada');
            $table->integer('mercaderia_total')->nullable()->after('recepcion');
            $table->decimal('fardo_prenda',10,2)->nullable()->after('mercaderia_total');
            $table->string('receptor')->nullable()->after('fardo_prenda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking', function (Blueprint $table) {
            $table->dropColumn('recepcion');
            $table->dropColumn('mercaderia_total');
            $table->dropColumn('fardo_prenda');
            $table->dropColumn('receptor');
        });
    }
};

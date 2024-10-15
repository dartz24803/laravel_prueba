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
        Schema::table('caja_chica', function (Blueprint $table) {
            $table->integer('tipo_movimiento')->nullable()->after('id');
            $table->string('descripcion',1000)->nullable()->after('id_empresa');
            $table->dropColumn('total');
            $table->dropColumn('ruta');
            $table->dropColumn('punto_partida');
            $table->dropColumn('punto_llegada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caja_chica', function (Blueprint $table) {
            $table->dropColumn('tipo_movimiento');
            $table->dropColumn('descripcion');
            $table->decimal('total',10,2)->nullable()->after('id_tipo_moneda');
            $table->integer('ruta')->nullable()->after('razon_social');
            $table->string('punto_partida')->nullable()->after('n_comprobante');
            $table->string('punto_llegada')->nullable()->after('punto_partida');

        });
    }
};

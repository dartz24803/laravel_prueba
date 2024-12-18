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
        DB::statement("
            CREATE VIEW vw_puesto_reporte_apertura_cierre_tienda AS
            SELECT cg.valor AS id_puesto,pu.nom_puesto
            FROM conf_general cg
            LEFT JOIN puesto pu ON cg.valor=pu.id_puesto
            WHERE cg.codigo_primario='PUESTO_REPORTE_APERTURA_CIERRE_TIENDA'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_puesto_reporte_apertura_cierre_tienda");
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW stock_total_insumo AS
            SELECT co.id_insumo,iu.nom_insumo,(CASE WHEN ri.suma_reparto IS NULL THEN SUM(co.cantidad)
            ELSE SUM(co.cantidad)-ri.suma_reparto END) AS total
            FROM contometro co
            INNER JOIN insumo iu ON iu.id_insumo=co.id_insumo
            LEFT JOIN (SELECT id_insumo,SUM(cantidad_reparto) AS suma_reparto 
            FROM reparto_insumo
            WHERE estado=1
            GROUP BY id_insumo) ri ON ri.id_insumo=co.id_insumo
            WHERE co.estado=1
            GROUP BY co.id_insumo,iu.nom_insumo,ri.suma_reparto
            ORDER BY iu.nom_insumo ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS stock_total_insumo");
    }
};

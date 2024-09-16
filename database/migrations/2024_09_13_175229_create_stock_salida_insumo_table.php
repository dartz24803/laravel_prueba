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
            CREATE VIEW stock_salida_insumo AS
            SELECT ri.cod_base,iu.nom_insumo,
            (CASE WHEN sa.suma_salida IS NULL THEN SUM(ri.cantidad_reparto)
            ELSE SUM(ri.cantidad_reparto)-sa.suma_salida END) AS total
            FROM reparto_insumo ri
            LEFT JOIN (SELECT cod_base,id_insumo,SUM(cantidad_salida) AS suma_salida
            FROM salida_contometro
            WHERE estado=1
            GROUP BY id_insumo, cod_base) sa ON ri.id_insumo=sa.id_insumo AND ri.cod_base=sa.cod_base
            INNER JOIN insumo iu ON iu.id_insumo=ri.id_insumo
            WHERE ri.estado=1
            GROUP BY ri.cod_base,iu.nom_insumo,sa.suma_salida
            ORDER BY ri.cod_base ASC,iu.nom_insumo ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS stock_salida_insumo");
    }
};

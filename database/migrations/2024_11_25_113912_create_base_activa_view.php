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
            CREATE VIEW vw_base_activa AS 
            SELECT cg.valor AS id_base,ub.cod_ubi cod_base 
            FROM conf_general cg
            INNER JOIN base ba ON ba.id_base=cg.valor
            INNER JOIN ubicacion ub ON ub.id_ubicacion=ba.id_ubicacion
            WHERE cg.codigo_primario='BASE_ACTIVA'
            ORDER BY ub.cod_ubi ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_base_activa");
    }
};

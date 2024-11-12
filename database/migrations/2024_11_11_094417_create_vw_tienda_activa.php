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
            CREATE VIEW vw_tienda_activa AS
            SELECT
                valor AS id_centro_labor,
                descripcion AS nom_centro_labor
            FROM
                conf_general
            WHERE codigo_primario='TIENDA_ACTIVA'
            ORDER BY descripcion ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_tienda_activa");
    }
};
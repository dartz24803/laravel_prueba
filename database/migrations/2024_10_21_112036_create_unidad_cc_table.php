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
            CREATE VIEW vw_unidad_caja_chica AS
            SELECT
                valor AS id_unidad,
                descripcion AS nom_unidad
            FROM
                conf_general
            WHERE codigo_primario='UNIDAD_CC_TESORERIA'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_unidad_caja_chica");
    }
};

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
            CREATE VIEW vw_tipo_comprobante AS
            SELECT
                valor AS id,
                descripcion AS nom_tipo_comprobante
            FROM
                conf_general
            WHERE codigo_primario='TIPO_COMPROBANTE_TESORERIA'
            ORDER BY descripcion ASC
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_tipo_comprobante");
    }
};

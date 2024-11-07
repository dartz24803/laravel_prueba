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
            CREATE VIEW vw_tipo_cambio_puesto AS
            SELECT
                valor AS id_tipo_cambio,
                descripcion AS nom_tipo_cambio
            FROM
                conf_general
            WHERE codigo_primario='TIPO_CAMBIO_PUESTO'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_tipo_cambio_puesto");
    }
};

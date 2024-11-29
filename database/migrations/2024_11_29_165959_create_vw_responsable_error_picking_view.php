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
            CREATE VIEW vw_responsable_error_picking AS
            SELECT id_usuario AS id_responsable,
            CONCAT(SUBSTRING_INDEX(usuario_nombres,' ',1),' ',usuario_apater) AS nom_responsable 
            FROM users
            WHERE id_puesto IN (SELECT valor FROM conf_general 
            WHERE codigo_primario='RESPONSABLE_ERROR_PICKING') AND id_ubicacion=24 AND estado=1
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_responsable_error_picking");
    }
};

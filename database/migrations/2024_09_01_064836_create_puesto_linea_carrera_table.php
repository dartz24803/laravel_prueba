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
            CREATE VIEW vw_puesto_linea_carrera AS
            SELECT 
                valor AS id_puesto,
                descripcion AS nom_puesto 
            FROM 
                conf_general 
            WHERE codigo_primario='PUESTO_PREGUNTA_LINEA_CARRERA'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_puesto_linea_carrera");
    }
};

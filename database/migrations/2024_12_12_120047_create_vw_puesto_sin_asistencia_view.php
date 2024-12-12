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
            CREATE VIEW vw_puesto_sin_asistencia AS
            SELECT cg.valor AS id_puesto,pu.nom_puesto
            FROM conf_general cg
            INNER JOIN puesto pu ON pu.id_puesto=cg.valor
            WHERE cg.codigo_primario='PUESTO_SIN_ASISTENCIA'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_puesto_sin_asistencia");
    }
};

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
            CREATE PROCEDURE lista_cap (IN id_ubicacionp BIGINT, IN fechap DATE)
            BEGIN
                SELECT pu.id_puesto,pu.nom_puesto,COUNT(1) AS aprobado,
                (SELECT ca.asistencia FROM cap ca 
                WHERE ca.fecha=fechap AND ca.id_puesto=pu.id_puesto
                ORDER BY ca.id DESC
                LIMIT 1) AS asistencia,
                (SELECT ca.libre FROM cap ca 
                WHERE ca.fecha=fechap AND ca.id_puesto=pu.id_puesto
                ORDER BY ca.id DESC
                LIMIT 1) AS libre,
                (SELECT ca.falta FROM cap ca 
                WHERE ca.fecha=fechap AND ca.id_puesto=pu.id_puesto
                ORDER BY ca.id DESC
                LIMIT 1) AS falta
                FROM organigrama og 
                INNER JOIN puesto pu ON pu.id_puesto=og.id_puesto
                WHERE pu.id_area IN (14,44)
                GROUP BY pu.id_puesto,pu.nom_puesto;
            END;"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP PROCEDURE lista_cap");
    }
};

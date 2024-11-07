<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateVisualizarResponsableAreaFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE FUNCTION visualizar_responsable_area(v_puesto INT) RETURNS INT
                DETERMINISTIC
            BEGIN
                DECLARE contar_acceso_capacitacion INT;
                SET contar_acceso_capacitacion = (
                    SELECT COUNT(1) 
                    FROM area
                    WHERE FIND_IN_SET(v_puesto, puestos) > 0
                );
                
                IF contar_acceso_capacitacion > 0 THEN
                    RETURN 1;
                ELSE
                    RETURN 0;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS visualizar_responsable_area');
    }
}

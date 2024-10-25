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
        CREATE FUNCTION `visualizar_mi_equipo`(v_puesto INT) RETURNS varchar(100) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
            DETERMINISTIC
        BEGIN 
            DECLARE contar_acceso_mi_equipo INT;
            SET contar_acceso_mi_equipo = (SELECT COUNT(*) FROM acceso_mi_equipo
                                            WHERE id_visualizador=v_puesto AND estado=1);
                                            
            IF contar_acceso_mi_equipo>0 THEN
                RETURN (SELECT puestos FROM acceso_mi_equipo
                        WHERE id_visualizador=v_puesto AND estado=1);
            ELSE
                RETURN 'sin_acceso_mi_equipo';
            END IF;
        END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP FUNCTION IF EXISTS visualizar_mi_equipo");
    }
};

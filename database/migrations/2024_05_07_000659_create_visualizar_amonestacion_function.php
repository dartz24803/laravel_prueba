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
            CREATE FUNCTION visualizar_amonestacion (v_puesto INT) RETURNS varchar(100) DETERMINISTIC
            BEGIN 
                DECLARE contar_acceso_amonestacion INT;
                SET contar_acceso_amonestacion = (SELECT COUNT(*) FROM acceso_amonestacion
                                                WHERE id_visualizador=v_puesto AND estado=1);
                                                
                IF contar_acceso_amonestacion>0 THEN
                    RETURN (SELECT puestos FROM acceso_amonestacion
                            WHERE id_visualizador=v_puesto AND estado=1);
                ELSE
                    RETURN 'sin_acceso_amonestacion';
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP FUNCTION IF EXISTS visualizar_amonestacion");
    }
};

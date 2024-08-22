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
            CREATE VIEW vw_estado_usuario AS
            SELECT
                valor AS id_estado_usuario,
                descripcion AS nom_estado_usuario
            FROM
                conf_general
            WHERE codigo_primario='ESTADO_USUARIO'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_estado_usuario");
    }
};

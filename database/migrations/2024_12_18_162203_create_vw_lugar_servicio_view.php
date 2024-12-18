<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vw_lugar_servicio AS
            SELECT valor AS id_lugar_servicio,descripcion AS nom_lugar_servicio
            FROM conf_general
            WHERE codigo_primario='LUGAR_SERVICIO_SEGURIDAD'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_lugar_servicio");
    }
};

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
            CREATE VIEW vw_proceso_visita AS
            SELECT valor AS id_procesov,descripcion AS nom_proceso 
            FROM conf_general 
            WHERE codigo_primario='PROCESO_VISITA'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_proceso_visita");
    }
};

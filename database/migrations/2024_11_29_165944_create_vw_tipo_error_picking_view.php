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
            CREATE VIEW vw_tipo_error_picking AS
            SELECT valor AS id_tipo_error,descripcion AS nom_tipo_error 
            FROM conf_general
            WHERE codigo_primario='TIPO_ERROR_PICKING'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_tipo_error_picking");
    }
};

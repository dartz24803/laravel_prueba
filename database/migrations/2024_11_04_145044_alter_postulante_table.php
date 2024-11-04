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
        Schema::table('postulante', function (Blueprint $table) {
            $table->dropColumn('id_nivel');
            $table->dropColumn('num_cele');
            $table->dropColumn('num_anexoe');
            $table->dropColumn('id_gerencia');
            $table->dropColumn('id_area');
            $table->dropColumn('id_cargo');
            $table->dropColumn('ini_funciones');
            $table->dropColumn('fin_funciones');
            $table->dropColumn('observaciones');
            $table->dropColumn('situacion');
            $table->dropColumn('enfermedades');
            $table->dropColumn('alergia');
            $table->dropColumn('acceso');
            $table->dropColumn('ip_acceso');
            $table->dropColumn('aprobado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postulante', function (Blueprint $table) {
            $table->integer('id_nivel')->nullable()->after('password_desencriptado');
            $table->string('num_cele',15)->nullable()->after('num_fijop');
            $table->string('num_anexoe',10)->nullable()->after('num_cele');
            $table->integer('id_gerencia')->nullable()->after('num_anexoe');
            $table->integer('id_area')->nullable()->after('id_gerencia');
            $table->integer('id_cargo')->nullable()->after('id_puesto');
            $table->dateTime('ini_funciones')->nullable()->after('foto_nombre');
            $table->dateTime('fin_funciones')->nullable()->after('ini_funciones');
            $table->text('observaciones')->nullable()->after('fin_funciones');
            $table->integer('situacion')->nullable()->after('fec_nac');
            $table->integer('enfermedades')->nullable()->after('situacion');
            $table->integer('alergia')->nullable()->after('enfermedades');
            $table->integer('acceso')->nullable()->after('user_eli');
            $table->string('ip_acceso',25)->nullable()->after('acceso');
            $table->integer('aprobado')->nullable()->after('estado_postulacion');
        });
    }
};

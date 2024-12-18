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
        Schema::table('lectura_servicio', function (Blueprint $table) {
            $table->dropColumn('parametro_1');
            $table->dropColumn('parametro_2');
            $table->dropColumn('parametro_3');
            $table->dropColumn('parametro_4');
            $table->dropColumn('parametro_5');
            $table->dropColumn('parametro_6');
            $table->dropColumn('parametro_7');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lectura_servicio', function (Blueprint $table) {
            $table->integer('parametro_1')->nullable()->after('id_datos_servicio');
            $table->integer('parametro_2')->nullable()->after('parametro_1');
            $table->integer('parametro_3')->nullable()->after('parametro_2');
            $table->integer('parametro_4')->nullable()->after('parametro_3');
            $table->integer('parametro_5')->nullable()->after('parametro_4');
            $table->integer('parametro_6')->nullable()->after('parametro_5');
            $table->integer('parametro_7')->nullable()->after('parametro_6');
        });
    }
};

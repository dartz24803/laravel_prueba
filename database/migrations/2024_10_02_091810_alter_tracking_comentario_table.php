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
        Schema::table('tracking_comentario', function (Blueprint $table) {
            $table->unsignedBigInteger('id_usuario')->after('id_tracking');
            $table->foreign('id_usuario', 'tcom_fk_id_usu')->references('id_usuario')->on('users');
            $table->index(['id_usuario'], 'tcom_idx_id_usu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_comentario', function (Blueprint $table) {
            $table->dropForeign('tcom_fk_id_usu');
            $table->dropIndex('tcom_idx_id_usu');
            $table->dropColumn('id_usuario');
        });
    }
};

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
        Schema::create('tracking_comentario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tracking');
            $table->string('pantalla',100)->nullable();
            $table->text('comentario')->nullable();
            $table->foreign('id_tracking', 'tcom_fk_id_tra')->references('id')->on('tracking');
            $table->index(['id_tracking'], 'tcom_idx_id_tra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_comentario');
    }
};

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
        Schema::create('tracking_diferencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tracking');
            $table->string('estilo',100)->nullable();
            $table->string('color_talla',100)->nullable();
            $table->integer('bulto')->nullable();
            $table->integer('enviado')->nullable();
            $table->integer('recibido')->nullable();
            $table->foreign('id_tracking', 'tdif_fk_id_tra')->references('id')->on('tracking');
            $table->index(['id_tracking'], 'tdif_idx_id_tra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_diferencia');
    }
};

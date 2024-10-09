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
        Schema::create('requerimiento_prenda_detalle', function (Blueprint $table) {
            $table->id('id_temporal');
            $table->string('empresa', 50)->nullable();
            $table->string('costo', 50)->nullable();
            $table->string('pc', 150)->nullable();
            $table->string('pv', 150)->nullable();
            $table->string('pp', 150)->nullable();
            $table->string('pc_b4', 20)->nullable();
            $table->string('pv_b4', 50);
            $table->string('pp_b4', 250)->nullable();
            $table->string('tipo_usuario', 50)->nullable();
            $table->string('tipo_prenda', 100);
            $table->string('autogenerado', 50);
            $table->string('estilo', 250);
            $table->text('descripcion');
            $table->string('color', 50);
            $table->string('talla', 20);
            $table->integer('total');
            $table->integer('OBS');
            $table->integer('stock');
            $table->integer('B01');
            $table->integer('B02');
            $table->integer('B03');
            $table->integer('B04');
            $table->integer('B05');
            $table->integer('B06');
            $table->integer('B07');
            $table->integer('B08');
            $table->integer('B09');
            $table->integer('B10');
            $table->integer('B11');
            $table->integer('B12');
            $table->integer('B13');
            $table->integer('B14');
            $table->integer('B15');
            $table->integer('B16');
            $table->integer('B17');
            $table->integer('B18');
            $table->integer('BEC');
            $table->integer('REQ');
            $table->integer('OFC');
            $table->char('anio', 4);
            $table->char('mes', 2);
            $table->text('ubicacion');
            $table->text('observacion');
            $table->integer('cantidad_envio');
            $table->integer('estado_requerimiento');
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimiento_prenda_detalle');
    }
};

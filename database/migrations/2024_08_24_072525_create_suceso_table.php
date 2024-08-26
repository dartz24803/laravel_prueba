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
        Schema::create('suceso', function (Blueprint $table) {
            $table->id('id_suceso');
            $table->string('cod_suceso',15)->nullable();
            $table->text('nom_suceso')->nullable();
            $table->unsignedBigInteger('id_tipo_error')->nullable();
            $table->unsignedBigInteger('id_error')->nullable();
            $table->string('centro_labores',5)->nullable();
            $table->decimal('monto',10,2)->nullable();
            $table->string('archivo',100)->nullable();
            $table->string('user_suceso')->nullable();
            $table->integer('estado_suceso')->nullable();
            $table->integer('usuario_aprobado')->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_tipo_error','suc_fk_id_terr')->references('id_tipo_error')->on('tipo_error');
            $table->foreign('id_error','suc_fk_id_err')->references('id_error')->on('error');
            $table->index(['id_tipo_error'], 'idx_id_terr');
            $table->index(['id_error'], 'idx_id_err');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suceso');
    }
};

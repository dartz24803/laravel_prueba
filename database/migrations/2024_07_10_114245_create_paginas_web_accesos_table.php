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
        Schema::create('paginas_web_accesos', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' que es auto incremental y clave primaria
            $table->unsignedBigInteger('area');
            $table->unsignedBigInteger('puesto')->nullable();
            $table->string('pagina_acceso', 255)->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('puesto')->references('id_puesto')->on('puesto');
            $table->foreign('area','pwacc_fk_id_are')->references('id_area')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paginas_web_accesos');
    }
};

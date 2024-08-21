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
        Schema::create('tipo_ocurrencia', function (Blueprint $table) {
            $table->id('id_tipo_ocurrencia'); // Identificador único, clave primaria, auto-incremental
            $table->string('cod_tipo_ocurrencia', 10); // Código de ocurrencia, longitud máxima de 10 caracteres
            $table->string('nom_tipo_ocurrencia', 50); // Nombre de la ocurrencia, longitud máxima de 50 caracteres
            $table->integer('id_conclusion'); // Relación con la tabla de conclusiones (clave externa)
            $table->integer('tipo_mae'); // Indica el tipo de maestro
            $table->string('base', 10); // Base relacionada, longitud máxima de 10 caracteres
            $table->integer('estado'); // Estado de la ocurrencia (activo/inactivo)
            $table->dateTime('fec_reg'); // Fecha de registro
            $table->integer('user_reg'); // Usuario que registró la ocurrencia
            $table->dateTime('fec_act')->nullable(); // Fecha de última actualización
            $table->integer('user_act')->nullable(); // Usuario que realizó la última actualización
            $table->dateTime('fec_eli')->nullable(); // Fecha de eliminación
            $table->integer('user_eli')->nullable(); // Usuario que realizó la eliminación
            $table->integer('digitos'); // Cantidad de dígitos asociados

            // $table->timestamps(); // Si no usas las marcas de tiempo por defecto, lo puedes comentar o eliminar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_ocurrencia'); // Elimina la tabla si existe
    }
};

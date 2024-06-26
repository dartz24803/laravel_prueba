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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('usuario_apater', '100')->nullable();
            $table->string('usuario_amater', '100')->nullable();
            $table->string('usuario_nombres', '100')->nullable();
            $table->string('usuario_codigo', '100')->nullable();
            $table->string('usuario_password')->nullable();
            $table->integer('id_nivel')->default(0)->nullable();
            $table->string('emailp',150)->nullable();
            $table->string('num_celp',15)->nullable();
            $table->integer('id_area')->default(0)->nullable();
            $table->integer('id_puesto')->default(0)->nullable();
            $table->integer('id_cargo')->default(0)->nullable();
            $table->integer('urladm')->default(0)->nullable();
            $table->string('centro_labores', 10)->nullable();
            $table->integer('acceso')->default(0)->nullable();
            $table->date('ini_funciones')->nullable();
            $table->integer('desvinculacion')->default(0)->nullable();
            $table->integer('induccion')->default(0)->nullable();
            $table->integer('datos_completos')->default(0)->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            //$table->rememberToken();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

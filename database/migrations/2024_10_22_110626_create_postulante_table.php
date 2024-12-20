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
        Schema::create('postulante', function (Blueprint $table) {
            $table->id('id_postulante');
            $table->unsignedBigInteger('id_centro_labor');
            $table->string('postulante_nombres',50)->nullable();
            $table->string('postulante_apater',50)->nullable();
            $table->string('postulante_amater',50)->nullable();
            $table->string('postulante_codigo',25)->nullable();
            $table->string('postulante_password')->nullable();
            $table->string('password_desencriptado',50)->nullable();
            $table->integer('id_nivel')->nullable(); //NO SIRVE (BORRADO)
            $table->string('postulante_email',100)->nullable(); //NO SIRVE
            $table->string('emailp',150)->nullable();
            $table->string('num_celp',15)->nullable();
            $table->string('num_fijop',15)->nullable();
            $table->string('num_cele',15)->nullable(); //NO SIRVE (BORRADO)
            $table->string('num_anexoe',10)->nullable(); //NO SIRVE (BORRADO)
            $table->integer('id_gerencia')->nullable(); //NO SIRVE, solo queda id_puesto (BORRADO)
            $table->integer('id_area')->nullable(); //NO SIRVE, solo queda id_puesto (BORRADO)
            $table->unsignedBigInteger('id_puesto');
            $table->integer('id_cargo')->nullable(); //NO SIRVE (BORRADO)
            $table->unsignedBigInteger('id_tipo_documento');
            $table->string('num_doc',15)->nullable();
            $table->integer('id_nacionalidad')->nullable();
            $table->integer('id_genero')->nullable();
            $table->integer('id_estado_civil')->nullable();
            $table->string('foto')->nullable();
            $table->string('foto_nombre',100)->nullable(); //NO SIRVE
            $table->dateTime('ini_funciones')->nullable(); //NO SIRVE (BORRADO)
            $table->dateTime('fin_funciones')->nullable(); //NO SIRVE (BORRADO)
            $table->text('observaciones')->nullable(); //NO SIRVE (BORRADO)
            $table->string('dia_nac',2)->nullable(); //NO SIRVE
            $table->string('mes_nac',2)->nullable(); //NO SIRVE
            $table->string('anio_nac',4)->nullable(); //NO SIRVE
            $table->date('fec_nac')->nullable();
            $table->integer('situacion')->nullable(); //NO SIRVE (BORRADO)
            $table->integer('enfermedades')->nullable(); //NO SIRVE (BORRADO)
            $table->integer('alergia')->nullable(); //NO SIRVE (BORRADO)
            $table->string('centro_labores',10)->nullable(); //NO SIRVE (BORRADO)
            $table->unsignedBigInteger('id_puesto_evaluador');
            $table->unsignedBigInteger('id_evaluador');
            $table->integer('flag_email')->nullable();
            $table->integer('estado')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();
            $table->integer('acceso')->nullable(); //NO SIRVE (BORRADO)
            $table->string('ip_acceso',25)->nullable(); //NO SIRVE (BORRADO)
            $table->integer('estado_postulacion')->nullable();
            $table->integer('aprobado')->nullable(); //NO SIRVE (BORRADO)
            $table->foreign('id_centro_labor', 'pos_fk_id_clab')->references('id_ubicacion')->on('ubicacion');
            $table->foreign('id_puesto', 'pos_fk_id_pue')->references('id_puesto')->on('puesto');
            $table->foreign('id_tipo_documento', 'pos_fk_id_tdoc')->references('id_tipo_documento')->on('tipo_documento');
            $table->foreign('id_puesto_evaluador', 'pos_fk_id_peva')->references('id_puesto')->on('puesto');
            $table->foreign('id_evaluador', 'pos_fk_id_eva')->references('id_usuario')->on('users');
            $table->index(['estado_postulacion'], 'pos_idx_epos');
            $table->index(['estado'], 'pos_idx_est');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulante');
    }
};

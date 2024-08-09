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
            $table->string('password_desencriptado',35)->nullable();
            $table->integer('id_nivel')->nullable();
            $table->string('usuario_email',100)->nullable();
            $table->string('emailp',150)->nullable();
            $table->string('num_celp',15)->nullable();
            $table->string('num_fijop',15)->nullable();
            $table->string('num_cele',15)->nullable();
            $table->string('num_fijoe',15)->nullable();
            $table->string('num_anexoe',10)->nullable();
            $table->integer('directorio')->nullable();
            $table->integer('asistencia')->nullable();
            $table->integer('id_horario')->nullable();
            $table->integer('horas_semanales')->nullable();
            $table->integer('id_gerencia')->nullable();
            $table->integer('id_sub_gerencia')->nullable();
            $table->integer('id_area')->nullable();
            $table->integer('id_puesto')->nullable();
            $table->integer('id_cargo')->nullable();
            $table->integer('id_empresa')->nullable();
            $table->integer('id_empresapl')->nullable();
            $table->integer('id_regimen')->nullable();
            $table->integer('id_tipo_contrato')->nullable();
            $table->integer('id_tipo_documento')->nullable();
            $table->string('num_doc',15)->nullable();
            $table->date('fec_emision_doc')->nullable();
            $table->date('fec_vencimiento_doc')->nullable();
            $table->integer('id_nacionalidad')->nullable();
            $table->integer('id_genero')->nullable();
            $table->integer('id_estado_civil')->nullable();
            $table->integer('urladm')->nullable();
            $table->string('foto',150)->nullable();
            $table->text('foto_nombre')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('dia_nac',2)->nullable();
            $table->string('mes_nac',2)->nullable();
            $table->string('anio_nac',4)->nullable();
            $table->date('fec_nac')->nullable();
            $table->integer('situacion')->nullable();
            $table->string('centro_labores', 10)->nullable();
            $table->integer('acceso')->nullable();
            $table->integer('verif_email')->nullable();
            $table->string('ip_acceso', 25)->nullable();
            $table->integer('enfermedades')->nullable();
            $table->integer('alergia')->nullable();
            $table->integer('hijos')->nullable();
            $table->integer('terminos')->nullable();
            $table->integer('id_situacion_laboral')->nullable();
            $table->date('ini_funciones')->nullable();
            $table->date('fin_funciones')->nullable();
            $table->date('fec_ingreso')->nullable();
            $table->date('fec_termino')->nullable();
            $table->integer('desvinculacion')->nullable();
            $table->dateTime('fec_reg_desv')->nullable();
            $table->integer('induccion')->nullable();
            $table->decimal('nota_induccion',10,2)->nullable();
            $table->integer('datos_completos')->nullable();
            $table->dateTime('fec_reg_ind')->nullable();
            $table->integer('id_modalidad_laboral')->nullable();
            $table->string('home_office', 10)->nullable();
            $table->integer('domiciliado')->nullable();
            $table->integer('asignacion_familiar')->nullable();
            $table->integer('aporte_voluntario')->nullable();
            $table->decimal('neto_uss',10,2)->nullable();
            $table->integer('id_banco_cts')->nullable();
            $table->string('cuenta_cts', 30)->nullable();
            $table->integer('id_banco_haberes')->nullable();
            $table->string('cuenta_haberes', 30)->nullable();
            $table->integer('id_tipo_trabajador')->nullable();
            $table->integer('id_sector_laboral')->nullable();
            $table->integer('id_nivel_educativo')->nullable();
            $table->integer('id_ocupacion')->nullable();
            $table->integer('id_cargo_trabajador')->nullable();
            $table->integer('id_sctr_salud')->nullable();
            $table->integer('id_sctr_pension')->nullable();
            $table->integer('id_situacion_trabajador')->nullable();
            $table->date('fecha_cese')->nullable();
            $table->date('fec_baja')->nullable();
            $table->integer('cancelar_baja')->nullable();
            $table->integer('id_motivo_baja')->nullable();
            $table->text('observaciones_baja')->nullable();
            $table->text('doc_baja')->nullable();
            $table->date('fec_asignacionjr')->nullable();
            $table->integer('id_puestojr')->nullable();
            $table->integer('cancelar_asignacionjr')->nullable();
            $table->integer('estado_asignacioncv')->nullable();
            $table->date('fec_asignacioncv')->nullable();
            $table->date('fec_iniciocv')->nullable();
            $table->date('fec_regvc')->nullable();
            $table->integer('cancelar_asignacioncv')->nullable();
            $table->integer('id_puestocv')->nullable();
            $table->integer('id_regimen_pensionario')->nullable();
            $table->date('fecha_inscripcion')->nullable();
            $table->string('cuspp_afp', 30)->nullable();
            $table->integer('id_comision_afp')->nullable();
            $table->integer('regimen_a')->nullable();
            $table->integer('jornada_trabajo')->nullable();
            $table->integer('trabajo_nocturno')->nullable();
            $table->integer('discapacidad')->nullable();
            $table->integer('sindicalizado')->nullable();
            $table->integer('renta_quinta')->nullable();
            $table->integer('id_tipo_pago')->nullable();
            $table->integer('id_periocidad')->nullable();
            $table->integer('id_situacion_especial_trabajador')->nullable();
            $table->integer('afiliado_eps')->nullable();
            $table->integer('id_eps')->nullable();
            $table->integer('ingreso_quinta')->nullable();
            $table->string('ruc_quinta', 30)->nullable();
            $table->string('razon_social_quinta', 300)->nullable();
            $table->decimal('renta_bruta_quinta',10,2)->nullable();
            $table->decimal('retencion_renta_quinta',10,2)->nullable();
            $table->integer('trabajador')->nullable();
            $table->integer('pensionista')->nullable();
            $table->integer('servicio_cuarta')->nullable();
            $table->integer('servicio_mod')->nullable();
            $table->integer('terceros')->nullable();
            $table->string('ruc_categoria', 30)->nullable();
            $table->text('gusto_personales')->nullable();
            $table->integer('edicion_perfil')->nullable();
            $table->integer('perf_revisado')->nullable();
            $table->dateTime('fec_edi_perfil')->nullable();
            $table->integer('user_edi_perfil')->nullable();
            $table->dateTime('fec_perf_revisado')->nullable();
            $table->integer('user_perf_revisado')->nullable();
            $table->dateTime('accesos_email')->nullable();
            $table->string('motivo_renuncia', 100)->nullable();
            $table->dateTime('correo_bienvenida')->nullable();
            $table->string('documento')->nullable();
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
        Schema::dropIfExists('users');
    }
};

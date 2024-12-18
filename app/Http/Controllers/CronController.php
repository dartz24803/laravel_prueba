<?php

namespace App\Http\Controllers;

use App\Models\AsistenciaColaborador;
use App\Models\AsistenciaColaboradorInconsistencia;
use App\Models\AsistenciaColaboradorMarcaciones;
use App\Models\BiotimeTemp;
use App\Models\Feriado;
use App\Models\HorarioDia;
use App\Models\PuestoReporteAperturaCierreTienda;
use App\Models\PuestoSinAsistencia;
use App\Models\TiendaMarcacion;
use App\Models\ToleranciaHorario;
use App\Models\Turno;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;

class CronController extends Controller
{
    public function update_tolerancia_horario()
    {
        $list_horario_dia = HorarioDia::select('id_horario_dia','id_turno')->where('estado',1)->get();

        foreach($list_horario_dia as $list){
            $get_id = Turno::findOrFail($list->id_turno);

            HorarioDia::findOrFail($list->id_horario_dia)->update([
                'hora_entrada' => $get_id->entrada,
                'hora_salida' => $get_id->salida,
                'con_descanso' => $get_id->t_refrigerio,
                'hora_descanso_e' => $get_id->ini_refri,
                'hora_descanso_s' => $get_id->fin_refri
            ]);
        }

        $get_id = ToleranciaHorario::select(DB::raw("CASE WHEN tipo=1 THEN tolerancia 
                WHEN tipo=2 THEN tolerancia*60 END AS minutos"))->where('estado',1)
                ->where('estado_registro',1)->first();
        if($get_id){
            $minutos = $get_id->minutos;
        }else{
            $minutos = 0;
        }

        DB::update("
            UPDATE horario_dia SET
            hora_entrada_desde=(DATE_FORMAT(DATE_SUB(hora_entrada,INTERVAL ? MINUTE), '%H:%i:%s')),
            hora_entrada_hasta=(DATE_FORMAT(DATE_ADD(hora_entrada,INTERVAL ? MINUTE), '%H:%i:%s')),
            hora_salida_desde=(DATE_FORMAT(DATE_SUB(hora_salida,INTERVAL ? MINUTE), '%H:%i:%s')),
            hora_salida_hasta=(DATE_FORMAT(DATE_ADD(hora_salida,INTERVAL ? MINUTE), '%H:%i:%s')),
            hora_descanso_e_desde=(DATE_FORMAT(DATE_SUB(hora_descanso_e,INTERVAL ? MINUTE), '%H:%i:%s')),
            hora_descanso_e_hasta=(DATE_FORMAT(DATE_ADD(hora_descanso_e,INTERVAL ? MINUTE), '%H:%i:%s')),
            hora_descanso_s_desde=(DATE_FORMAT(DATE_SUB(hora_descanso_s,INTERVAL ? MINUTE), '%H:%i:%s')),
            hora_descanso_s_hasta=(DATE_FORMAT(DATE_ADD(hora_descanso_s,INTERVAL ? MINUTE), '%H:%i:%s'))
            WHERE estado=1
        ", [$minutos,$minutos,$minutos,$minutos,$minutos,$minutos,$minutos,$minutos]);
    }

    public function insert_asistencia_colaborador()
    {
        /*SE COLOCA LA FECHA QUE SE VA CARGAR LA ASISTENCIA (POR DEFECTO LA DE HOY, 
        YA QUE SE EJECUTA EL CRON A LAS 23:00)*/
        $hoy = date('Y-m-d');
        /*SE GUARDA EL DÍA DE LA SEMANA SEGÚN LA FECHA ESCOGIDA*/
        $numero_dia_semana = date('N', strtotime($hoy));
        /*SE EJECUTA EL STORE QUE VA CARGAR LA INFO DEL BIOTIME A LA BD DE LN1 
        (PARA AGILIZAR EL PROCESO)*/
        DB::statement("CALL insert_asistencia_colaborador('$hoy')");
        /*LISTAMOS TODOS LOS USUARIOS VIGENTES PARA TRAER SU ASISTENCIA*/
        $list_usuario = Usuario::from('users AS us')
                        ->select('us.id_usuario','ub.cod_ubi AS centro_labores','pu.id_area',
                        'us.num_doc',DB::raw("IFNULL(us.id_horario,0) AS id_horario"),
                        DB::raw("IFNULL(ho.nombre,'') AS nom_horario"))
                        ->leftjoin('ubicacion AS ub','us.id_centro_labor','=','ub.id_ubicacion')
                        ->leftjoin('puesto AS pu','us.id_puesto','=','pu.id_puesto')
                        ->leftjoin('horario AS ho','us.id_horario','=','ho.id_horario')
                        ->where('us.ini_funciones','<=',DB::raw('CURDATE()'))
                        ->whereNotIn('us.id_nivel',[8,12])->where('us.estado',1)
                        ->whereNotIn('us.id_puesto',PuestoSinAsistencia::select('id_puesto'))
                        ->get();
        /*HACEMOS UN BUCLE PARA TRAER LA ASISTENCIA DE CADA COLABORADOR*/
        foreach($list_usuario as $list){
            /*VALIDAMOS SI EL COLABORADOR TIENE HORARIO*/
            if($list->id_horario>0){
                /*LISTAMOS EL HORARIO DEL COLABORADOR*/
                $get_horario = HorarioDia::from('horario_dia AS hd')->select('hd.id_horario',
                                'hd.con_descanso','hd.dia','hd.hora_entrada',
                                DB::raw("DATE_FORMAT(DATE_ADD(hd.hora_entrada,INTERVAL 1 MINUTE),
                                '%H:%i:%s') AS max_hora_entrada"),'hd.hora_entrada_desde',
                                'hd.hora_entrada_hasta','hd.hora_salida','hd.hora_salida_desde',
                                'hd.hora_salida_hasta','hd.hora_descanso_e','hd.hora_descanso_e_desde',
                                'hd.hora_descanso_e_hasta','hd.hora_descanso_s',
                                'hd.hora_descanso_s_desde','hd.hora_descanso_s_hasta',
                                'ho.nombre AS nom_horario','hd.id_turno','ho.feriado')
                                ->join('horario AS ho','ho.id_horario','=','hd.id_horario')
                                ->where('hd.id_horario',$list->id_horario)
                                ->where('hd.dia',$numero_dia_semana)->where('hd.estado',1)
                                ->orderBy('hd.id_horario_dia','DESC')
                                ->first();
                /*VALIDAMOS SI TIENE HORARIO PARA EL DÍA ESCOGIDO*/
                if($get_horario){
                    /*BUSCAMOS SI HAY FERIADO EN EL DÍA ESCOGIDO*/
                    $dia_feriado = Feriado::where('fec_feriado',$hoy)->where('estado',1)
                                ->count();
                    /*VALIDAMOS SI ES FERIADO*/
                    if($get_horario->feriado!=1 && $dia_feriado>0){
                        /*SE GUARDA LA ASISTENCIA COMO FERIADO*/
                        AsistenciaColaborador::create([
                            'id_usuario' => $list->id_usuario,
                            'fecha' => $hoy,
                            'id_horario' => $get_horario->id_horario,
                            'con_descanso' => $get_horario->con_descanso,
                            'dia' => $numero_dia_semana,
                            'centro_labores' => $list->centro_labores,
                            'id_area' => $list->id_area,
                            'hora_entrada' => $get_horario->hora_entrada,
                            'hora_entrada_desde' => $get_horario->hora_entrada_desde,
                            'hora_entrada_hasta' => $get_horario->hora_entrada_hasta,
                            'hora_salida' => $get_horario->hora_salida,
                            'hora_salida_desde' => $get_horario->hora_salida_desde,
                            'hora_salida_hasta' => $get_horario->hora_salida_hasta,
                            'hora_descanso_e' => $get_horario->hora_descanso_e,
                            'hora_descanso_e_desde' => $get_horario->hora_descanso_e_desde,
                            'hora_descanso_e_hasta' => $get_horario->hora_descanso_e_hasta,
                            'hora_descanso_s' => $get_horario->hora_descanso_s,
                            'hora_descanso_s_desde' => $get_horario->hora_descanso_s_desde,
                            'hora_descanso_s_hasta' => $get_horario->hora_descanso_s_hasta,
                            'registro' => 'Feriado',
                            'estado_registro' => 6,
                            'nom_horario' => $get_horario->nom_horario,
                            'flag_diatrabajado' => 1,
                            'estado' => 1,
                            'fec_reg' => now(),
                            'fec_act' => now()
                        ]);
                    }else{
                        /*LISTAMOS LAS MARCACIONES*/
                        $list_marcacion = BiotimeTemp::select(DB::raw("DATE_FORMAT(punch_time,'%H:%i:%s') AS 
                                        punch_time"),'work_code')
                                        ->where(DB::raw("LPAD(emp_code,8,'0')"),'=',$list->num_doc)
                                        ->orderBy('punch_time','ASC')
                                        ->get();
                        /*VALIDAMOS SI TIENE DESCANSO (ESTO QUIERE DECIR QUE SI TENDRÁ 2 O 
                        4 MARCACIONES)*/
                        if($get_horario->con_descanso==1){
                            if(count($list_marcacion)==4){
                                $marcacion1 = null; 
                                $marcacion2 = null;
                                $marcacion3 = null;
                                $marcacion4 = null;
                                $obs_marcacion1 = null; 
                                $obs_marcacion2 = null;
                                $obs_marcacion3 = null;
                                $obs_marcacion4 = null;
                                /*HACEMOS BUCLE PARA RECORRER LAS MARCACIONES DEL COLABORADOR*/
                                foreach($list_marcacion as $marcacion){
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE ENTRADA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_entrada_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_entrada_hasta) {
                                        if ($marcacion1 === null || $marcacion->punch_time < $marcacion1) {
                                            $marcacion1 = $marcacion->punch_time;
                                            $obs_marcacion1 = $marcacion->work_code;
                                        }
                                    }
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA DE REFRIGERIO*/
                                    if ($marcacion->punch_time >= $get_horario->hora_descanso_e_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_descanso_e_hasta) {
                                        if ($marcacion2 === null || $marcacion->punch_time < $marcacion2) {
                                            $marcacion2 = $marcacion->punch_time;
                                            $obs_marcacion2 = $marcacion->work_code;
                                        }
                                    }
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE INGRESO DE REFRIGERIO*/
                                    if ($marcacion->punch_time >= $get_horario->hora_descanso_s_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_descanso_s_hasta) {
                                        if ($marcacion3 === null || $marcacion->punch_time < $marcacion3) {
                                            $marcacion3 = $marcacion->punch_time;
                                            $obs_marcacion3 = $marcacion->work_code;
                                        }
                                    }
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_salida_desde) {
                                        if ($marcacion4 === null || $marcacion->punch_time < $marcacion4) {
                                            $marcacion4 = $marcacion->punch_time;
                                            $obs_marcacion4 = $marcacion->work_code;
                                        }
                                    }
                                }
                                /*VALIDAMOS SI CUMPLE SUS MARCACIONES CON SU HORARIO*/
                                if ($marcacion1 !== null && $marcacion2 !== null && $marcacion3 !== null && $marcacion4 !== null) {
                                    /*VALIDAMOS SI LLEGO TEMPRANO O TARDE*/
                                    $registro = "";
                                    $estado_registro = 0;
                                    if($marcacion1<$get_horario->max_hora_entrada){
                                        $registro = "Puntual";
                                        $estado_registro = 1;
                                    }else{
                                        $registro = "Tardanza";
                                        $estado_registro = 2;
                                    }
                                    /*SE GUARDA LA ASISTENCIA CORRECTA POR CUMPLIR CON SU HORARIO*/
                                    AsistenciaColaborador::create([
                                        'id_usuario' => $list->id_usuario,
                                        'fecha' => $hoy,
                                        'id_horario' => $get_horario->id_horario,
                                        'con_descanso' => $get_horario->con_descanso,
                                        'dia' => $numero_dia_semana,
                                        'centro_labores' => $list->centro_labores,
                                        'id_area' => $list->id_area,
                                        'hora_entrada' => $get_horario->hora_entrada,
                                        'hora_entrada_desde' => $get_horario->hora_entrada_desde,
                                        'hora_entrada_hasta' => $get_horario->hora_entrada_hasta,
                                        'hora_salida' => $get_horario->hora_salida,
                                        'hora_salida_desde' => $get_horario->hora_salida_desde,
                                        'hora_salida_hasta' => $get_horario->hora_salida_hasta,
                                        'hora_descanso_e' => $get_horario->hora_descanso_e,
                                        'hora_descanso_e_desde' => $get_horario->hora_descanso_e_desde,
                                        'hora_descanso_e_hasta' => $get_horario->hora_descanso_e_hasta,
                                        'hora_descanso_s' => $get_horario->hora_descanso_s,
                                        'hora_descanso_s_desde' => $get_horario->hora_descanso_s_desde,
                                        'hora_descanso_s_hasta' => $get_horario->hora_descanso_s_hasta,
                                        'marcacion_entrada' => $marcacion1,
                                        'marcacion_idescanso' => $marcacion2,
                                        'marcacion_fdescanso' => $marcacion3,
                                        'marcacion_salida' => $marcacion4,
                                        'registro' => $registro,
                                        'estado_registro' => $estado_registro,
                                        'nom_horario' => $get_horario->nom_horario,
                                        'flag_diatrabajado' => 1,
                                        'obs_marc_entrada' => $obs_marcacion1,
                                        'obs_marc_idescanso' => $obs_marcacion2,
                                        'obs_marc_fdescanso' => $obs_marcacion3,
                                        'obs_marc_salida' => $obs_marcacion4,
                                        'estado' => 1,
                                        'fec_reg' => now(),
                                        'fec_act' => now()
                                    ]);
                                }else{
                                    /*GUARDAMOS LA ASISTENCIA COMO INCONSISTENCIA POR NO CUMPLIR 
                                    CON SU HORARIO*/
                                    $inconsistencia = AsistenciaColaboradorInconsistencia::create([
                                        'id_usuario' => $list->id_usuario,
                                        'fecha' => $hoy,
                                        'id_horario' => $get_horario->id_horario,
                                        'con_descanso' => $get_horario->con_descanso,
                                        'dia' => $numero_dia_semana,
                                        'centro_labores' => $list->centro_labores,
                                        'id_area' => $list->id_area,
                                        'hora_entrada' => $get_horario->hora_entrada,
                                        'hora_entrada_desde' => $get_horario->hora_entrada_desde,
                                        'hora_entrada_hasta' => $get_horario->hora_entrada_hasta,
                                        'hora_salida' => $get_horario->hora_salida,
                                        'hora_salida_desde' => $get_horario->hora_salida_desde,
                                        'hora_salida_hasta' => $get_horario->hora_salida_hasta,
                                        'hora_descanso_e' => $get_horario->hora_descanso_e,
                                        'hora_descanso_e_desde' => $get_horario->hora_descanso_e_desde,
                                        'hora_descanso_e_hasta' => $get_horario->hora_descanso_e_hasta,
                                        'hora_descanso_s' => $get_horario->hora_descanso_s,
                                        'hora_descanso_s_desde' => $get_horario->hora_descanso_s_desde,
                                        'hora_descanso_s_hasta' => $get_horario->hora_descanso_s_hasta,
                                        'observacion' => 'Marcaciones no coinciden con rangos de horario',
                                        'nom_horario' => $get_horario->nom_horario,
                                        'flag_ausencia' => 0,
                                        'tipo_inconsistencia' => 1,
                                        'id_turno' => $get_horario->id_turno,
                                        'estado' => 1,
                                        'fec_reg' => now(),
                                        'fec_act' => now()
                                    ]);
                                    /*HACEMOS BUCLE PARA GUARDAR MARCACIONES*/
                                    foreach($list_marcacion as $marcacion){
                                        $tipo_marcacion = 0;
                                        /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE ENTRADA*/
                                        if ($marcacion->punch_time >= $get_horario->hora_entrada_desde && 
                                        $marcacion->punch_time <= $get_horario->hora_entrada_hasta) {
                                            $tipo_marcacion = 1;
                                        }
                                        /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA DE REFRIGERIO*/
                                        if ($marcacion->punch_time >= $get_horario->hora_descanso_e_desde && 
                                        $marcacion->punch_time <= $get_horario->hora_descanso_e_hasta) {
                                            $tipo_marcacion = 2;
                                        }
                                        /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE INGRESO DE REFRIGERIO*/
                                        if ($marcacion->punch_time >= $get_horario->hora_descanso_s_desde && 
                                        $marcacion->punch_time <= $get_horario->hora_descanso_s_hasta) {
                                            $tipo_marcacion = 3;
                                        }                                    
                                        /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA*/
                                        if ($marcacion->punch_time >= $get_horario->hora_salida_desde) {
                                            $tipo_marcacion = 4;
                                        }
                                        /*GUARDAR LAS MARCACIONES*/
                                        AsistenciaColaboradorMarcaciones::create([
                                            'id_asistencia_inconsistencia' => $inconsistencia->id_asistencia_inconsistencia,
                                            'marcacion' => $marcacion->punch_time,
                                            'obs_marcacion' => $marcacion->work_code,
                                            'tipo_marcacion' => $tipo_marcacion,
                                            'visible' => 1,
                                            'estado' => 1,
                                            'fec_reg' => now(),
                                            'fec_act' => now()
                                        ]);
                                    }
                                }
                            }else{
                                $observacion = "Sin marcaciones";
                                $tipo_inconsistencia = 0;
                                $flag_ausencia = 1;
                                if(count($list_marcacion)>0){
                                    $observacion = "Cantidad de marcaciones";
                                    $tipo_inconsistencia = 2;
                                    $flag_ausencia = 0;
                                }
                                /*GUARDAMOS LA ASISTENCIA COMO INCONSISTENCIA POR NO CUMPLIR 
                                LAS 4 MARCACIONES DE SU HORARIO*/
                                $inconsistencia = AsistenciaColaboradorInconsistencia::create([
                                    'id_usuario' => $list->id_usuario,
                                    'fecha' => $hoy,
                                    'id_horario' => $get_horario->id_horario,
                                    'con_descanso' => $get_horario->con_descanso,
                                    'dia' => $numero_dia_semana,
                                    'centro_labores' => $list->centro_labores,
                                    'id_area' => $list->id_area,
                                    'hora_entrada' => $get_horario->hora_entrada,
                                    'hora_entrada_desde' => $get_horario->hora_entrada_desde,
                                    'hora_entrada_hasta' => $get_horario->hora_entrada_hasta,
                                    'hora_salida' => $get_horario->hora_salida,
                                    'hora_salida_desde' => $get_horario->hora_salida_desde,
                                    'hora_salida_hasta' => $get_horario->hora_salida_hasta,
                                    'hora_descanso_e' => $get_horario->hora_descanso_e,
                                    'hora_descanso_e_desde' => $get_horario->hora_descanso_e_desde,
                                    'hora_descanso_e_hasta' => $get_horario->hora_descanso_e_hasta,
                                    'hora_descanso_s' => $get_horario->hora_descanso_s,
                                    'hora_descanso_s_desde' => $get_horario->hora_descanso_s_desde,
                                    'hora_descanso_s_hasta' => $get_horario->hora_descanso_s_hasta,
                                    'observacion' => $observacion,
                                    'nom_horario' => $get_horario->nom_horario,
                                    'flag_ausencia' => $flag_ausencia,
                                    'tipo_inconsistencia' => $tipo_inconsistencia,
                                    'id_turno' => $get_horario->id_turno,
                                    'estado' => 1,
                                    'fec_reg' => now(),
                                    'fec_act' => now()
                                ]);
                                /*HACEMOS BUCLE PARA GUARDAR MARCACIONES*/
                                foreach($list_marcacion as $marcacion){
                                    $tipo_marcacion = 0;
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE ENTRADA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_entrada_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_entrada_hasta) {
                                        $tipo_marcacion = 1;
                                    }
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA DE REFRIGERIO*/
                                    if ($marcacion->punch_time >= $get_horario->hora_descanso_e_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_descanso_e_hasta) {
                                        $tipo_marcacion = 2;
                                    }
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE INGRESO DE REFRIGERIO*/
                                    if ($marcacion->punch_time >= $get_horario->hora_descanso_s_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_descanso_s_hasta) {
                                        $tipo_marcacion = 3;
                                    }                                    
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_salida_desde) {
                                        $tipo_marcacion = 4;
                                    }
                                    /*GUARDAR LAS MARCACIONES*/
                                    AsistenciaColaboradorMarcaciones::create([
                                        'id_asistencia_inconsistencia' => $inconsistencia->id_asistencia_inconsistencia,
                                        'marcacion' => $marcacion->punch_time,
                                        'obs_marcacion' => $marcacion->work_code,
                                        'tipo_marcacion' => $tipo_marcacion,
                                        'visible' => 1,
                                        'estado' => 1,
                                        'fec_reg' => now(),
                                        'fec_act' => now()
                                    ]);
                                }
                            }
                        }else{
                            if(count($list_marcacion)==2){
                                $marcacion1 = null; 
                                $marcacion2 = null;
                                $marcacion3 = null;
                                $marcacion4 = null;
                                $obs_marcacion1 = null; 
                                $obs_marcacion2 = null;
                                $obs_marcacion3 = null;
                                $obs_marcacion4 = null;
                                foreach($list_marcacion as $marcacion){
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE ENTRADA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_entrada_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_entrada_hasta) {
                                        if ($marcacion1 === null || $marcacion->punch_time < $marcacion1) {
                                            $marcacion1 = $marcacion->punch_time;
                                            $obs_marcacion1 = $marcacion->work_code;
                                        }
                                    }
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_salida_desde) {
                                        if ($marcacion4 === null || $marcacion->punch_time < $marcacion4) {
                                            $marcacion4 = $marcacion->punch_time;
                                            $obs_marcacion4 = $marcacion->work_code;
                                        }
                                    }
                                }
                                /*VALIDAMOS SI CUMPLE SUS MARCACIONES CON SU HORARIO*/
                                if ($marcacion1 !== null && $marcacion4 !== null) {
                                    /*VALIDAMOS SI LLEGO TEMPRANO O TARDE*/
                                    $registro = "";
                                    $estado_registro = 0;
                                    if($marcacion1<$get_horario->max_hora_entrada){
                                        $registro = "Puntual";
                                        $estado_registro = 1;
                                    }else{
                                        $registro = "Tardanza";
                                        $estado_registro = 2;
                                    }
                                    /*SE GUARDA LA ASISTENCIA CORRECTA POR CUMPLIR CON SU HORARIO*/
                                    AsistenciaColaborador::create([
                                        'id_usuario' => $list->id_usuario,
                                        'fecha' => $hoy,
                                        'id_horario' => $get_horario->id_horario,
                                        'con_descanso' => $get_horario->con_descanso,
                                        'dia' => $numero_dia_semana,
                                        'centro_labores' => $list->centro_labores,
                                        'id_area' => $list->id_area,
                                        'hora_entrada' => $get_horario->hora_entrada,
                                        'hora_entrada_desde' => $get_horario->hora_entrada_desde,
                                        'hora_entrada_hasta' => $get_horario->hora_entrada_hasta,
                                        'hora_salida' => $get_horario->hora_salida,
                                        'hora_salida_desde' => $get_horario->hora_salida_desde,
                                        'hora_salida_hasta' => $get_horario->hora_salida_hasta,
                                        'hora_descanso_e' => $get_horario->hora_descanso_e,
                                        'hora_descanso_e_desde' => $get_horario->hora_descanso_e_desde,
                                        'hora_descanso_e_hasta' => $get_horario->hora_descanso_e_hasta,
                                        'hora_descanso_s' => $get_horario->hora_descanso_s,
                                        'hora_descanso_s_desde' => $get_horario->hora_descanso_s_desde,
                                        'hora_descanso_s_hasta' => $get_horario->hora_descanso_s_hasta,
                                        'marcacion_entrada' => $marcacion1,
                                        'marcacion_idescanso' => $marcacion2,
                                        'marcacion_fdescanso' => $marcacion3,
                                        'marcacion_salida' => $marcacion4,
                                        'registro' => $registro,
                                        'estado_registro' => $estado_registro,
                                        'nom_horario' => $get_horario->nom_horario,
                                        'flag_diatrabajado' => 1,
                                        'obs_marc_entrada' => $obs_marcacion1,
                                        'obs_marc_idescanso' => $obs_marcacion2,
                                        'obs_marc_fdescanso' => $obs_marcacion3,
                                        'obs_marc_salida' => $obs_marcacion4,
                                        'estado' => 1,
                                        'fec_reg' => now(),
                                        'fec_act' => now()
                                    ]);
                                }else{
                                    /*GUARDAMOS LA ASISTENCIA COMO INCONSISTENCIA POR NO CUMPLIR 
                                    CON SU HORARIO*/
                                    $inconsistencia = AsistenciaColaboradorInconsistencia::create([
                                        'id_usuario' => $list->id_usuario,
                                        'fecha' => $hoy,
                                        'id_horario' => $get_horario->id_horario,
                                        'con_descanso' => $get_horario->con_descanso,
                                        'dia' => $numero_dia_semana,
                                        'centro_labores' => $list->centro_labores,
                                        'id_area' => $list->id_area,
                                        'hora_entrada' => $get_horario->hora_entrada,
                                        'hora_entrada_desde' => $get_horario->hora_entrada_desde,
                                        'hora_entrada_hasta' => $get_horario->hora_entrada_hasta,
                                        'hora_salida' => $get_horario->hora_salida,
                                        'hora_salida_desde' => $get_horario->hora_salida_desde,
                                        'hora_salida_hasta' => $get_horario->hora_salida_hasta,
                                        'hora_descanso_e' => $get_horario->hora_descanso_e,
                                        'hora_descanso_e_desde' => $get_horario->hora_descanso_e_desde,
                                        'hora_descanso_e_hasta' => $get_horario->hora_descanso_e_hasta,
                                        'hora_descanso_s' => $get_horario->hora_descanso_s,
                                        'hora_descanso_s_desde' => $get_horario->hora_descanso_s_desde,
                                        'hora_descanso_s_hasta' => $get_horario->hora_descanso_s_hasta,
                                        'observacion' => 'Marcaciones no coinciden con rangos de horario',
                                        'nom_horario' => $get_horario->nom_horario,
                                        'flag_ausencia' => 0,
                                        'tipo_inconsistencia' => 1,
                                        'id_turno' => $get_horario->id_turno,
                                        'estado' => 1,
                                        'fec_reg' => now(),
                                        'fec_act' => now()
                                    ]);
                                    /*HACEMOS BUCLE PARA GUARDAR MARCACIONES*/
                                    foreach($list_marcacion as $marcacion){
                                        $tipo_marcacion = 0;
                                        /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE ENTRADA*/
                                        if ($marcacion->punch_time >= $get_horario->hora_entrada_desde && 
                                        $marcacion->punch_time <= $get_horario->hora_entrada_hasta) {
                                            $tipo_marcacion = 1;
                                        }                                 
                                        /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA*/
                                        if ($marcacion->punch_time >= $get_horario->hora_salida_desde){
                                            $tipo_marcacion = 4;
                                        }
                                        /*GUARDAR LAS MARCACIONES*/
                                        AsistenciaColaboradorMarcaciones::create([
                                            'id_asistencia_inconsistencia' => $inconsistencia->id_asistencia_inconsistencia,
                                            'marcacion' => $marcacion->punch_time,
                                            'obs_marcacion' => $marcacion->work_code,
                                            'tipo_marcacion' => $tipo_marcacion,
                                            'visible' => 1,
                                            'estado' => 1,
                                            'fec_reg' => now(),
                                            'fec_act' => now()
                                        ]);
                                    }
                                }
                            }else{
                                $observacion = "Sin marcaciones";
                                $tipo_inconsistencia = 0;
                                $flag_ausencia = 1;
                                if(count($list_marcacion)>0){
                                    $observacion = "Cantidad de marcaciones";
                                    $tipo_inconsistencia = 2;
                                    $flag_ausencia = 0;
                                }
                                /*GUARDAMOS LA ASISTENCIA COMO INCONSISTENCIA POR NO CUMPLIR 
                                LAS 2 MARCACIONES DE SU HORARIO*/
                                $inconsistencia = AsistenciaColaboradorInconsistencia::create([
                                    'id_usuario' => $list->id_usuario,
                                    'fecha' => $hoy,
                                    'id_horario' => $get_horario->id_horario,
                                    'con_descanso' => $get_horario->con_descanso,
                                    'dia' => $numero_dia_semana,
                                    'centro_labores' => $list->centro_labores,
                                    'id_area' => $list->id_area,
                                    'hora_entrada' => $get_horario->hora_entrada,
                                    'hora_entrada_desde' => $get_horario->hora_entrada_desde,
                                    'hora_entrada_hasta' => $get_horario->hora_entrada_hasta,
                                    'hora_salida' => $get_horario->hora_salida,
                                    'hora_salida_desde' => $get_horario->hora_salida_desde,
                                    'hora_salida_hasta' => $get_horario->hora_salida_hasta,
                                    'hora_descanso_e' => $get_horario->hora_descanso_e,
                                    'hora_descanso_e_desde' => $get_horario->hora_descanso_e_desde,
                                    'hora_descanso_e_hasta' => $get_horario->hora_descanso_e_hasta,
                                    'hora_descanso_s' => $get_horario->hora_descanso_s,
                                    'hora_descanso_s_desde' => $get_horario->hora_descanso_s_desde,
                                    'hora_descanso_s_hasta' => $get_horario->hora_descanso_s_hasta,
                                    'observacion' => $observacion,
                                    'nom_horario' => $get_horario->nom_horario,
                                    'flag_ausencia' => $flag_ausencia,
                                    'tipo_inconsistencia' => $tipo_inconsistencia,
                                    'id_turno' => $get_horario->id_turno,
                                    'estado' => 1,
                                    'fec_reg' => now(),
                                    'fec_act' => now()
                                ]);
                                /*HACEMOS BUCLE PARA GUARDAR MARCACIONES*/
                                foreach($list_marcacion as $marcacion){
                                    $tipo_marcacion = 0;
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE ENTRADA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_entrada_desde && 
                                    $marcacion->punch_time <= $get_horario->hora_entrada_hasta) {
                                        $tipo_marcacion=  1;
                                    }
                                    /*VERIFICAR SI MARCACIÓN ESTÁ EN RANGO DE SALIDA*/
                                    if ($marcacion->punch_time >= $get_horario->hora_salida_desde) {
                                        $tipo_marcacion = 4;
                                    }
                                    /*GUARDAR LAS MARCACIONES*/
                                    AsistenciaColaboradorMarcaciones::create([
                                        'id_asistencia_inconsistencia' => $inconsistencia->id_asistencia_inconsistencia,
                                        'marcacion' => $marcacion->punch_time,
                                        'obs_marcacion' => $marcacion->work_code,
                                        'tipo_marcacion' => $tipo_marcacion,
                                        'visible' => 1,
                                        'estado' => 1,
                                        'fec_reg' => now(),
                                        'fec_act' => now()
                                    ]);
                                }
                            }
                        }
                    }
                }else{
                    /*SI NO TIENE HORARIO SE GUARDA EN ASISTENCIA COMO DESCANSO*/
                    AsistenciaColaborador::create([
                        'id_usuario' => $list->id_usuario,
                        'fecha' => $hoy,
                        'id_horario' => $list->id_horario,
                        'nom_horario' => $list->nom_horario,
                        'dia' => $numero_dia_semana,
                        'centro_labores' => $list->centro_labores,
                        'id_area' => $list->id_area,
                        'registro' => 'Descanso',
                        'estado_registro' => 4,
                        'flag_diatrabajado' => 1,
                        'estado' => 1,
                        'fec_reg' => now(),
                        'fec_act' => now()
                    ]);
                }
            }else{
                /*GUARDAMOS AL COLABORADOR COMO INCONSISTENCIA POR NO TENER HORARIO*/
                $inconsistencia = AsistenciaColaboradorInconsistencia::create([
                    'id_usuario' => $list->id_usuario,
                    'fecha' => $hoy,
                    'con_descanso' => 0,
                    'dia' => $numero_dia_semana,
                    'centro_labores' => $list->centro_labores,
                    'id_area' => $list->id_area,
                    'observacion' => 'Sin horario',
                    'flag_ausencia' => 0,
                    'tipo_inconsistencia' => 3,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'fec_act' => now()
                ]);
                /*LISTAMOS LAS MARCACIONES, SI TUVIERA, YA QUE NO ES NECESARIO TENER HORARIO 
                PARA MARCAR*/
                $list_marcacion = BiotimeTemp::select(DB::raw("DATE_FORMAT(punch_time,'%H:%i:%s') AS 
                                punch_time"),'work_code')
                                ->where(DB::raw("LPAD(emp_code,8,'0')"),'=',$list->num_doc)
                                ->orderBy('punch_time','ASC')
                                ->get();
                /*GUARDAR LAS MARCACIONES, SI TUVIERA*/
                foreach($list_marcacion as $marcacion){
                    AsistenciaColaboradorMarcaciones::create([
                        'id_asistencia_inconsistencia' => $inconsistencia->id_asistencia_inconsistencia,
                        'marcacion' => $marcacion->punch_time,
                        'obs_marcacion' => $marcacion->work_code,
                        'tipo_marcacion' => 0,
                        'visible' => 1,
                        'estado' => 1,
                        'fec_reg' => now(),
                        'fec_act' => now()
                    ]);
                }
            }
        }
    }

    public function reporte_apertura_cierre_tienda()
    {
        $list_reporte = TiendaMarcacion::get_list_reporte_apertura_cierre_tienda();
        $list_correo = Usuario::select('emailp')
                    ->whereIn('id_puesto',PuestoReporteAperturaCierreTienda::select('id_puesto'))
                    ->where('estado',1)->get(); 

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            //foreach($list_correo as $list){
            //    $mail->addAddress($list->emailp);
            //}
            $mail->addAddress('dpalomino@lanumero1.com.pe');
            $mail->addAddress('OGUTIERREZ@LANUMERO1.COM.PE');

            $mail->isHTML(true);

            $mail->Subject = "Reporte diario de apertura y cierre de tienda";
        
            $mail->Body =  '<FONT SIZE=3>
                                A continuación se presenta el detalle de las bases de hoy:<br><br>
                                <table CELLPADDING="2" CELLSPACING="0" border="2" style="width:100%;border: 1px solid black;">
                                    <thead>
                                        <tr align="center">
                                            <th><b>BASE</b></th>
                                            <th><b>INGRESO</b></th>
                                            <th><b>DIFERENCIA (INGRESO)</b></th>
                                            <th><b>APERTURA</b></th>
                                            <th><b>DIFERENCIA (APERTURA)</b></th>
                                            <th><b>CIERRE</b></th>
                                            <th><b>DIFERENCIA (CIERRE)</b></th>
                                            <th><b>SALIDA</b></th>
                                            <th><b>DIFERENCIA (SALIDA)</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                foreach($list_reporte as $list){
                                        if($list->ingreso!="" && $list->apertura!="" && $list->cierre!="" && $list->salida!=""){
                                            $color_base = "transparent";
                                        }else{
                                            $color_base = "red";
                                        }
                                        if($list->diferencia_ingreso>0){
                                            $color_ingreso = "green";
                                        }elseif($list->diferencia_ingreso<0){
                                            $color_ingreso = "red";
                                        }else{
                                            $color_ingreso = "black";
                                        }
                                        if($list->diferencia_apertura>0){
                                            $color_apertura = "green";
                                        }elseif($list->diferencia_apertura<0){
                                            $color_apertura = "red";
                                        }else{
                                            $color_apertura = "black";
                                        }
                                        if($list->diferencia_cierre>0){
                                            $color_cierre = "green";
                                        }elseif($list->diferencia_cierre<0){
                                            $color_cierre = "red";
                                        }else{
                                            $color_cierre = "black";
                                        }
                                        if($list->diferencia_salida>0){
                                            $color_salida = "green";
                                        }elseif($list->diferencia_salida<0){
                                            $color_salida = "red";
                                        }else{
                                            $color_salida = "black";
                                        }
            $mail->Body .=  '            <tr align="center">
                                            <td style="color:'.$color_base.';">'.$list->cod_base.'</td>
                                            <td>'.$list->ingreso.'</td>
                                            <td style="color:'.$color_ingreso.';">'.$list->diferencia_ingreso.'</td>
                                            <td>'.$list->apertura.'</td>
                                            <td style="color:'.$color_apertura.';">'.$list->diferencia_apertura.'</td>
                                            <td>'.$list->cierre.'</td>
                                            <td style="color:'.$color_cierre.';">'.$list->diferencia_cierre.'</td>
                                            <td>'.$list->salida.'</td>
                                            <td style="color:'.$color_salida.';">'.$list->diferencia_salida.'</td>
                                        </tr>';
                                }
            $mail->Body .=  '        </tbody>
                                </table><br>';
            $mail->CharSet = 'UTF-8';
            $mail->send();
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
}

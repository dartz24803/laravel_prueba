<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CronController extends Controller
{
    public function insert_asistencia_colaborador()
    {
        $hoy = "2024-12-03";
        $hoy = date('Y-m-d');
        DB::statement("CALL insert_asistencia_colaborador('$hoy')");

        $list_usuario = Usuario::from('users AS us')
                        ->select('us.id_usuario','ub.cod_ubi AS centro_labores','pu.id_area',
                        'us.num_doc',DB::raw("IFNULL(us.id_horario,0) AS id_horario"),
                        DB::raw("IFNULL(ho.nombre,'') AS nom_horario"))
                        ->leftjoin('ubicacion AS ub','us.id_centro_labor','=','ub.id_ubicacion')
                        ->leftjoin('puesto AS pu','us.id_puesto','=','pu.id_puesto')
                        ->leftjoin('horario AS ho','us.id_horario','=','ho.id_horario')
                        ->where('us.ini_funciones','<=',DB::raw('CURDATE()'))
                        ->whereNotIn('us.id_nivel',[8,12])->where('us.estado',1)
                        ->count();

        echo $list_usuario;

        /*TrackingTemporal::truncate();
        $list_tracking = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?', ['T']);
        foreach($list_tracking as $list){
            if($list->id_origen_hacia=="4" || $list->id_origen_hacia=="6" || $list->id_origen_hacia=="10"){
                TrackingTemporal::create([
                    'n_requerimiento' => $list->n_requerimiento,
                    'n_guia_remision' => $list->n_guia_remision,
                    'semana' => $list->semana,
                    'id_origen_desde' => $list->id_origen_desde,
                    'desde' => $list->desde,
                    'id_origen_hacia' => $list->id_origen_hacia,
                    'hacia' => $list->hacia,
                    'bultos' => $list->bultos
                ]);
            }
        }
        DB::statement('CALL insert_tracking()');

        $list_tracking = Tracking::from('tracking AS tr')
                        ->select('tr.id','tr.n_requerimiento','tr.n_guia_remision',
                        'tr.semana',DB::raw('base.cod_base AS hacia'),'distrito.nombre_distrito')
                        ->join('base','base.id_base','=','tr.id_origen_hacia')
                        ->leftjoin('distrito','distrito.id_distrito','=','base.id_distrito')
                        ->where('tr.iniciar',0)->take(1)->get();

        foreach($list_tracking as $get_id){
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $get_id->id,
                'id_proceso' => 1,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
            ]);
    
            //ALERTA 1
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'MERCADERÍA POR SALIR',
                    'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está listo',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'MERCADERÍA POR SALIR',
                'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está listo',
            ];
            $this->insert_notificacion($dato);

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 1,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
            ]);
        }*/
    }
}

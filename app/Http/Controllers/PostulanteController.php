<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Postulante;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostulanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index_prev()
    {
        return view('rrhh.postulante.revision.index');
    }

    public function list_prev(Request $request)
    {
        $list_revision = Postulante::select('id_postulante','centro_labores','num_doc','postulante_apater',
                        'postulante_amater','postulante_nombres')->where('estado_postulacion',11)
                        ->where('estado',1)->get();
        return view('rrhh.postulante.revision.lista', compact('list_revision'));
    }

    public function edit_prev($id)
    {
        $get_id = Postulante::findOrFail($id);
        $get_base = Base::where('cod_base',$get_id->centro_labores)->first();
        $get_base = Base::select(DB::raw("GROUP_CONCAT(DISTINCT CONCAT('\'',cod_base,'\'')) AS cadena"))
                    ->where('id_departamento',$get_base->id_departamento)->where('estado',1)->first();
        $list_vinculo = Usuario::select('users.centro_labores','users.num_doc','users.usuario_apater',
                        'users.usuario_amater','users.usuario_nombres','vw_estado_usuario.nom_estado_usuario',
                        DB::raw('CASE WHEN LEFT(users.fin_funciones,1)="2" THEN DATE_FORMAT(users.fin_funciones, 
                        "%d/%m/%Y") ELSE "" END AS fecha_cese'))
                        ->join('vw_estado_usuario','vw_estado_usuario.id_estado_usuario','=','users.estado')
                        ->whereRaw('users.centro_labores IN ('.$get_base->cadena.') AND (users.usuario_apater=? OR 
                        users.usuario_amater=?) AND users.estado IN (1,3)',[$get_id->postulante_apater, $get_id->postulante_amater])
                        ->get();
        return view('rrhh.postulante.revision.modal_editar',compact('get_id','list_vinculo'));
    }

    public function update_prev(Request $request,$id)
    {
        $request->validate([
            'resultado' => 'gt:0'
        ],[
            'resultado.gt' => 'Debe seleccionar resultado.'
        ]);

        echo "Siuuu";
        /*if($tipo=="ingreso"){
            $request->validate([
                'cod_sedee' => 'not_in:0',
                'h_ingresoe' => 'required'
            ],[
                'cod_sedee.not_in' => 'Debe seleccionar sede.',
                'h_ingresoe.required' => 'Debe ingresar hora ingreso.'
            ]);

            SeguridadAsistencia::findOrFail($id)->update([
                'cod_sede' => $request->cod_sedee,
                'h_ingreso' => $request->h_ingresoe,
                'observacion' => $request->observacione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }else{
            $request->validate([
                'fecha_salidae' => 'required',
                'cod_sedese' => 'not_in:0',
                'h_salidae' => 'required'
            ],[
                'fecha_salidae.required' => 'Debe ingresar fecha.',
                'cod_sedese.not_in' => 'Debe seleccionar sede.',
                'h_salidae.required' => 'Debe ingresar hora salida.'
            ]);

            SeguridadAsistencia::findOrFail($id)->update([
                'fecha_salida' => $request->fecha_salidae,
                'cod_sedes' => $request->cod_sedese,
                'h_salida' => $request->h_salidae,
                'observacion' => $request->observacione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }*/
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Pregunta;
use App\Models\PreguntaDetalle;
use App\Models\PuestoLineaCarrera;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LineaCarreraConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion(); 
        $list_subgerencia = SubGerencia::list_subgerencia(13);           
        return view('caja.administracion.linea_carrera.index',compact('list_notificacion','list_subgerencia'));
    }

    public function index_pre()
    {
        return view('caja.administracion.linea_carrera.pregunta.index');
    }

    public function list_pre()
    {
        $list_pregunta = Pregunta::from('pregunta AS pr')
                        ->select('pr.id','pu.nom_puesto',DB::raw('CASE WHEN pr.id_tipo=1 THEN "Abierta" 
                        WHEN pr.id_tipo=2 THEN "Opción múltiple" ELSE "" END AS nom_tipo'),'pr.descripcion',
                        'pr.id_tipo')
                        ->join('puesto AS pu','pu.id_puesto','=','pr.id_puesto')
                        ->where('pr.estado', 1)->get();
        $list_cantidad = Pregunta::get_list_cantidad_preguntas();                        
        return view('caja.administracion.linea_carrera.pregunta.lista', compact('list_pregunta','list_cantidad'));
    }

    public function create_pre()
    {
        $list_puesto = PuestoLineaCarrera::all();
        return view('caja.administracion.linea_carrera.pregunta.modal_registrar', compact('list_puesto'));
    }

    public function store_pre(Request $request)
    {
        $validate = $request->validate([
            'id_puesto' => 'gt:0',
            'id_tipo' => 'gt:0'
        ],[
            'id_puesto.gt' => 'Debe seleccionar puesto.',
            'id_tipo.gt' => 'Debe seleccionar tipo.'
        ]);

        $errors = [];

        if($validate['id_tipo']=="1"){
            if($request->descripcion==""){
                $errors['descripcion'] = ['Debe ingresar descripción.'];
            }
        }
        if($validate['id_tipo']=="2"){
            if($request->descripcion==""){
                $errors['descripcion'] = ['Debe ingresar descripción.'];
            }
            if($request->opcion_1==""){
                $errors['opcion_1'] = ['Debe ingresar opción 1.'];
            }
            if($request->opcion_2==""){
                $errors['opcion_2'] = ['Debe ingresar opción 2.'];
            }
            if($request->opcion_3==""){
                $errors['opcion_3'] = ['Debe ingresar opción 3.'];
            }
            if($request->opcion_4==""){
                $errors['opcion_4'] = ['Debe ingresar opción 4.'];
            }
            if($request->opcion_5==""){
                $errors['opcion_5'] = ['Debe ingresar opción 5.'];
            }
            if(!isset($request->validar_opcion)){
                $errors['validar_opcion'] = ['Debe seleccionar la alternativa correcta.'];
            }
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $valida = Pregunta::where('id_puesto', $request->id_puesto)
                ->where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            $pregunta = Pregunta::create([
                'id_puesto' => $request->id_puesto,
                'id_tipo' => $request->id_tipo,
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            if($request->id_tipo=="2"){
                $i = 1;
                while($i<=5){
                    $respuesta = 0;
                    if($request->validar_opcion==$i){
                        $respuesta = 1;
                    }
                    PreguntaDetalle::create([
                        'id_pregunta' => $pregunta->id,
                        'opcion' => $request->input('opcion_'.$i),
                        'respuesta' => $respuesta
                    ]);
                    $i++;
                }
            }
        }
    }

    public function edit_pre($id)
    {
        $get_id = Pregunta::findOrFail($id);
        $list_puesto = PuestoLineaCarrera::all();
        $get_opcion = PreguntaDetalle::where('id_pregunta',$id)->get();
        return view('caja.administracion.linea_carrera.pregunta.modal_editar', compact('get_id','list_puesto','get_opcion'));
    }

    public function update_pre(Request $request, $id)
    {
        $validate = $request->validate([
            'id_puestoe' => 'gt:0',
            'id_tipoe' => 'gt:0'
        ],[
            'id_puestoe.gt' => 'Debe seleccionar puesto.',
            'id_tipoe.gt' => 'Debe seleccionar tipo.'
        ]);

        $errors = [];

        if($validate['id_tipoe']=="1"){
            if($request->descripcione==""){
                $errors['descripcione'] = ['Debe ingresar descripción.'];
            }
        }
        if($validate['id_tipoe']=="2"){
            if($request->descripcione==""){
                $errors['descripcione'] = ['Debe ingresar descripción.'];
            }
            if($request->opcion_1e==""){
                $errors['opcion_1e'] = ['Debe ingresar opción 1.'];
            }
            if($request->opcion_2e==""){
                $errors['opcion_2e'] = ['Debe ingresar opción 2.'];
            }
            if($request->opcion_3e==""){
                $errors['opcion_3e'] = ['Debe ingresar opción 3.'];
            }
            if($request->opcion_4e==""){
                $errors['opcion_4e'] = ['Debe ingresar opción 4.'];
            }
            if($request->opcion_5e==""){
                $errors['opcion_5e'] = ['Debe ingresar opción 5.'];
            }
            if(!isset($request->validar_opcione)){
                $errors['validar_opcione'] = ['Debe seleccionar la alternativa correcta.'];
            }
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $valida = Pregunta::where('id_puesto', $request->id_puestoe)
                ->where('descripcion', $request->descripcione)->where('estado', 1)->where('id','!=',$id)->exists();
        if($valida){
            echo "error";
        }else{
            Pregunta::findOrFail($id)->update([
                'id_puesto' => $request->id_puestoe,
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            if($request->id_tipoe=="2"){
                PreguntaDetalle::where('id_pregunta', $id)->delete();
                $i = 1;
                while($i<=5){
                    $respuesta = 0;
                    if($request->validar_opcione==$i){
                        $respuesta = 1;
                    }
                    PreguntaDetalle::create([
                        'id_pregunta' => $id,
                        'opcion' => $request->input('opcion_'.$i.'e'),
                        'respuesta' => $respuesta
                    ]);
                    $i++;
                }
            }
        }
    }

    public function show_pre($id)
    {
        $list_opcion = PreguntaDetalle::where('id_pregunta',$id)->get();
        return view('caja.administracion.linea_carrera.pregunta.modal_opcion', compact('list_opcion'));
    }

    public function destroy_pre($id)
    {
        Pregunta::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

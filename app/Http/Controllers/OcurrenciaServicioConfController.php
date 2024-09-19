<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\DatosServicio;
use App\Models\Notificacion;
use App\Models\ProveedorServicio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OcurrenciaGestion;
use App\Models\OcurrenciaConclusion;
use App\Models\OcurrenciaTipo;
use App\Models\SubGerencia;




class OcurrenciaServicioConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(1);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();        
        return view('seguridad.administracion.ocurrencias.index',compact('list_notificacion', 'list_subgerencia'));
    }


    // Gestión Ocurrencias
    public function index_go()
    {
        return view('seguridad.administracion.ocurrencias.gestion_ocurrencias.index');
    }

    public function list_go()
    {
        $list_gestion_ocurrencias = OcurrenciaGestion::select('id_gestion','nom_gestion')
        ->where('estado', 1)->get();
        return view('seguridad.administracion.ocurrencias.gestion_ocurrencias.lista', compact('list_gestion_ocurrencias'));
    }


    public function create_go()
    {
        return view('seguridad.administracion.ocurrencias.gestion_ocurrencias.modal_registrar');
    }

    public function store_go(Request $request)
    {
        $request->validate([
            'nom_gestion' => 'required',
        ],[
            'nom_gestion.required' => 'Debe ingresar nombre.',
        ]);

        $valida = OcurrenciaGestion::where('nom_gestion', $request->nom_gestion)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            OcurrenciaGestion::create([
                'nom_gestion' => $request->nom_gestion,
                'estado' => 1,
                'lectura' => $request->lectura,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,

            ]);
        }
    }

    public function edit_go($id)
    {
        $get_id = OcurrenciaGestion::findOrFail($id);
        return view('seguridad.administracion.ocurrencias.gestion_ocurrencias.modal_editar', compact('get_id'));
    }

    public function update_go(Request $request, $id)
    {
        $request->validate([
            'nom_servicioe' => 'required',
        ],[
            'nom_servicioe.required' => 'Debe ingresar nombre.',
        ]);

        $valida = OcurrenciaGestion::where('nom_gestion', $request->nom_servicioe)
                ->where('estado', 1)->where('id_gestion', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            OcurrenciaGestion::findOrFail($id)->update([
                'nom_gestion' => $request->nom_servicioe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_go($id)
    {
        OcurrenciaGestion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    // Conclusión Ocurrencias
    public function index_co()
    {
        return view('seguridad.administracion.ocurrencias.conclusion_ocurrencias.index');

    }

    public function list_coc()
    {
        $list_conclusion_ocurrencias = OcurrenciaConclusion::select('id_conclusion','cod_conclusion','nom_conclusion')
        ->where('estado', 1)->get();
        return view('seguridad.administracion.ocurrencias.conclusion_ocurrencias.lista', compact('list_conclusion_ocurrencias'));
    }

    public function create_co()
    {
        return view('seguridad.administracion.ocurrencias.conclusion_ocurrencias.modal_registrar');
    }

    public function store_co(Request $request)
    {
        $request->validate([
            'nom_conclusion' => 'required',
            'cod_conclusion' => 'required',

        ],[
            'nom_conclusion.required' => 'Debe ingresar nombre.',
            'cod_conclusion.required' => 'Debe ingresar código.',

        ]);

        $valida = OcurrenciaConclusion::where('nom_conclusion', $request->nom_conclusion)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            OcurrenciaConclusion::create([
                'nom_conclusion' => $request->nom_conclusion,
                'cod_conclusion' => $request->cod_conclusion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,

            ]);
        }
    }

    public function edit_co($id)
    {
        $get_id = OcurrenciaConclusion::findOrFail($id);
        return view('seguridad.administracion.ocurrencias.conclusion_ocurrencias.modal_editar', compact('get_id'));
    }

    public function update_co(Request $request, $id)
    {
        $request->validate([
            'nom_conclusione' => 'required',
            'cod_conclusione' => 'required',

        ],[
            'nom_conclusione.required' => 'Debe ingresar nombre.',
            'cod_conclusione.required' => 'Debe ingresar código.',

        ]);

        $valida = OcurrenciaConclusion::where('nom_conclusion', $request->nom_conclusione)
                ->where('estado', 1)->where('id_conclusion', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            OcurrenciaConclusion::findOrFail($id)->update([
                'cod_conclusion' => $request->cod_conclusione,
                'nom_conclusion' => $request->nom_conclusione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_co($id)
    {
        OcurrenciaConclusion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }




    // Tipo Ocurrencias
    public function index_to()
    {
        return view('seguridad.administracion.ocurrencias.tipo_ocurrencias.index');

    }


    public function list_to()
    {
        $list_tipo_ocurrencias = OcurrenciaTipo::with('conclusion')
            ->where('estado', 1)
            ->get();

        // Prepare the data to include conclusion name
        $list_tipo_ocurrencias = $list_tipo_ocurrencias->map(function($item) {
            return [
                'id_tipo_ocurrencia' => $item->id_tipo_ocurrencia,
                'cod_tipo_ocurrencia' => $item->cod_tipo_ocurrencia,
                'nom_tipo_ocurrencia' => $item->nom_tipo_ocurrencia,
                'base' => $item->base,
                'nom_conclusion' => $item->conclusion->nom_conclusion ?? 'No conclusión'
            ];
        });

        return view('seguridad.administracion.ocurrencias.tipo_ocurrencias.lista', compact('list_tipo_ocurrencias'));
    }

    public function create_to()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        // $list_base = Base::select('cod_base')->where('estado',1)->orderBy('cod_base','ASC')
        //                     ->get();
        $list_conclusion = OcurrenciaConclusion::get_list_conclusion();
        return view('seguridad.administracion.ocurrencias.tipo_ocurrencias.modal_registrar', compact(['list_base','list_conclusion']));
    }




    public function store_to(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'nom_tipo_ocurrencia' => 'required',
            'cod_tipo_ocurrencia' => 'required',
            'id_conclusion' => 'required|gt:0', // Asegurando que se seleccione una conclusión válida
            'cod_base' => 'required',
        ],[
            'nom_tipo_ocurrencia.required' => 'Debe ingresar nombre.',
            'cod_tipo_ocurrencia.required' => 'Debe ingresar código.',
            'id_conclusion.gt' => 'Debe seleccionar una conclusión.',
            'cod_base.required' => 'Debe seleccionar una base.',
        ]);

        // Verificación de existencia de la ocurrencia tipo
        $valida = OcurrenciaTipo::where('nom_tipo_ocurrencia', $request->nom_tipo_ocurrencia)
                                ->where('estado', 1)->exists();

        if($valida){
            echo "error";
        } else {
            // Manejo para múltiples bases (si es necesario)
            if(is_array($request->cod_base) && count($request->cod_base) > 0){
                $cadena = "";
                foreach($request->cod_base as $base){
                    $exists = OcurrenciaTipo::where('nom_tipo_ocurrencia', $request->nom_tipo_ocurrencia)
                                            ->where('cod_tipo_ocurrencia', $request->cod_tipo_ocurrencia)
                                            ->where('base', $base)
                                            ->where('estado', 1)
                                            ->exists();
                    if($exists){
                        $cadena .= "El código de base $base ya está asociado con este tipo de ocurrencia. ";
                    }
                }

                if($cadena != ""){
                    echo $cadena; // Devuelve el mensaje de error si existe alguna duplicación
                } else {
                    // Creación de múltiples ocurrencias tipo para cada base
                    foreach($request->cod_base as $base){
                        OcurrenciaTipo::create([
                            'nom_tipo_ocurrencia' => $request->nom_tipo_ocurrencia,
                            'cod_tipo_ocurrencia' => $request->cod_tipo_ocurrencia,
                            'id_conclusion' => $request->id_conclusion,
                            'base' => $base,
                            'tipo_mae' => 1,
                            'estado' => 1,
                            'fec_reg' => now(),
                            'user_reg' => session('usuario')->id_usuario,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario,
                        ]);
                    }
                }
            } else {
                // Si solo hay una base, crea una sola ocurrencia tipo
                OcurrenciaTipo::create([
                    'nom_tipo_ocurrencia' => $request->nom_tipo_ocurrencia,
                    'cod_tipo_ocurrencia' => $request->cod_tipo_ocurrencia,
                    'id_conclusion' => $request->id_conclusion,
                    'base' => $request->cod_base,
                    'tipo_mae' => 1,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            }
        }
    }


    public function edit_to($id)
    {
        $get_id = OcurrenciaTipo::findOrFail($id);
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_conclusion = OcurrenciaConclusion::get_list_conclusion();
        return view('seguridad.administracion.ocurrencias.tipo_ocurrencias.modal_editar', compact(['get_id','list_base','list_conclusion']));
    }

    public function update_to(Request $request, $id)
    {
        $request->validate([
            'nom_tipo_oc' => 'required',
            'cod_tipo_oc' => 'required',
            'cod_basee' =>'required',
        ],[
            'nom_tipo_oc.required' => 'Debe ingresar nombre333.',
            'cod_tipo_oc.required' => 'Debe ingresar código4.',
            'cod_basee.required' => 'Debe ingresar base.',

        ]);

        $valida = OcurrenciaTipo::where('nom_tipo_ocurrencia', $request->nom_tipo_oc)
                ->where('estado', 1)->where('id_tipo_ocurrencia', '!=', $id)->exists();

        if($valida){
            echo "error";
        }else{
            OcurrenciaTipo::findOrFail($id)->update([
                'nom_tipo_ocurrencia' => $request->nom_tipo_oc,
                'cod_tipo_ocurrencia' => $request->cod_tipo_oc,
                'id_conclusion' => $request->id_conclusione,
                'base' => $request->cod_basee,
                'tipo_mae' => 1,
                'estado' => 1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }
    }


    public function destroy_to($id)
    {
        OcurrenciaTipo::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}


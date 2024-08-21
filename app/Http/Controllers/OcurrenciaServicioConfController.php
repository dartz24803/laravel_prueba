<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\DatosServicio;
use App\Models\ProveedorServicio;
use App\Models\SegLugarServicio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\OcurrenciaGestion;
use App\Models\OcurrenciaConclusion;




class OcurrenciaServicioConfController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.administracion.ocurrencias.index');
    }

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
}


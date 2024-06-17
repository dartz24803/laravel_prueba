<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Base;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\Mes;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index_conf()
    {
        return view('tienda.administracion.administrador.index');
    }

    public function index_conf_st()
    {
        return view('tienda.administracion.administrador.supervision_tienda.index');
    }

    public function list_conf_st()
    {
        $list_c_supervision_tienda = ContenidoSupervisionTienda::select('id','descripcion')->where('estado', 1)->get();
        return view('tienda.administracion.administrador.supervision_tienda.lista', compact('list_c_supervision_tienda'));
    }

    public function create_conf_st($validador=null)
    {
        $validador = $validador;
        return view('tienda.administracion.administrador.supervision_tienda.modal_registrar', compact('validador'));
    }

    public function store_conf_st(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ContenidoSupervisionTienda::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            ContenidoSupervisionTienda::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_conf_st($id)
    {
        $get_id = ContenidoSupervisionTienda::findOrFail($id);
        return view('tienda.administracion.administrador.supervision_tienda.modal_editar', compact('get_id'));
    }

    public function update_conf_st(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ContenidoSupervisionTienda::where('descripcion', $request->descripcione)->where('estado', 1)->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            ContenidoSupervisionTienda::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_conf_st($id)
    {
        ContenidoSupervisionTienda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_conf_sc()
    {
        $list_base = Base::get_list_base_administrador_sc();
        $list_area = Area::select('id_area','nom_area')->where('estado',1)->orderBy('nom_area','ASC')->get();
        return view('tienda.administracion.administrador.seguimiento_coordinador.index', compact('list_base','list_area'));
    }

    public function list_conf_sc(Request $request)
    {
        $list_c_seguimiento_coordinador = ContenidoSeguimientoCoordinador::get_list_c_seguimiento_coordinador(['base'=>$request->base,'id_area'=>$request->area,'id_periocidad'=>$request->periocidad]);
        return view('tienda.administracion.administrador.seguimiento_coordinador.lista', compact('list_c_seguimiento_coordinador'));
    }

    public function create_conf_sc($validador=null)
    {
        $list_base = Base::get_list_base_administrador_sc();
        $list_area = Area::select('id_area','nom_area')->where('estado',1)->orderBy('nom_area','ASC')->get();
        $list_dia_semana = DiaSemana::all();
        $list_mes = Mes::select('id_mes','nom_mes')->get();
        $validador = $validador;
        return view('tienda.administracion.administrador.seguimiento_coordinador.modal_registrar', compact('list_base','list_area','list_dia_semana','list_mes','validador'));
    }

    public function store_conf_sc(Request $request)
    {
        $rules = [
            'bases' => 'required_without:todos',
            'id_area' => 'gt:0',
            'id_periocidad' => 'gt:0',
        ];
        $messages = [
            'bases.required_without' => 'Debe seleccionar al menos una base.',
            'id_area.gt' => 'Debe seleccionar área.',
            'id_periocidad.gt' => 'Debe seleccionar periocidad.',
        ];
        if($request->id_periocidad=="2"){
            if($request->nom_dia_1=="0" && $request->nom_dia_2=="0" && $request->nom_dia_3=="0"){
                $rules['dummy_field'] = 'gt:0';
                $messages['dummy_field.gt'] = 'Debe seleccionar al menos un día.';
            }
        }elseif($request->id_periocidad=="3"){
            $rules['dia_1'] = 'gt:0';
            $messages['dia_1.gt'] = 'Debe seleccionar día 1.';
            $rules['dia_2'] = 'gt:0';
            $messages['dia_2.gt'] = 'Debe seleccionar día 2.';
        }elseif($request->id_periocidad=="4"){
            $rules['dia'] = 'gt:0';
            $messages['dia.gt'] = 'Debe seleccionar día.';
        }elseif($request->id_periocidad=="5"){
            $rules['mes'] = 'gt:0';
            $messages['mes.gt'] = 'Debe seleccionar mes.';
            $rules['dia'] = 'gt:0';
            $messages['dia.gt'] = 'Debe seleccionar día.';
        }
        $rules['descripcion'] = 'required';
        $messages['descripcion.required'] = 'Debe ingresar descripción.';
        
        $request->validate($rules, $messages);

        if($request->todos=="1"){
            $list_base = Base::get_list_base_administrador_sc();
            foreach($list_base as $list){
                ContenidoSeguimientoCoordinador::create([
                    'base' => $list->cod_base,
                    'id_area' => $request->id_area,
                    'id_periocidad' => $request->id_periocidad,
                    'nom_dia_1' => $request->nom_dia_1,
                    'nom_dia_2' => $request->nom_dia_2,
                    'nom_dia_3' => $request->nom_dia_3,
                    'dia_1' => $request->dia_1,
                    'dia_2' => $request->dia_2,
                    'dia' => $request->dia,
                    'mes' => $request->mes,
                    'descripcion' => $request->descripcion,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }else{
            foreach($request->bases as $base){
                ContenidoSeguimientoCoordinador::create([
                    'base' => $base,
                    'id_area' => $request->id_area,
                    'id_periocidad' => $request->id_periocidad,
                    'nom_dia_1' => $request->nom_dia_1,
                    'nom_dia_2' => $request->nom_dia_2,
                    'nom_dia_3' => $request->nom_dia_3,
                    'dia_1' => $request->dia_1,
                    'dia_2' => $request->dia_2,
                    'dia' => $request->dia,
                    'mes' => $request->mes,
                    'descripcion' => $request->descripcion,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }
    }

    public function edit_conf_sc($id)
    {
        $get_id = ContenidoSeguimientoCoordinador::findOrFail($id);
        $list_base = Base::get_list_base_administrador_sc();
        $list_area = Area::select('id_area','nom_area')->where('estado',1)->orderBy('nom_area','ASC')->get();
        $list_dia_semana = DiaSemana::all();
        $list_mes = Mes::select('id_mes','nom_mes')->get();
        return view('tienda.administracion.administrador.seguimiento_coordinador.modal_editar', compact('get_id','list_base','list_area','list_dia_semana','list_mes'));
    }

    public function update_conf_sc(Request $request, $id)
    {
        $rules = [
            'basese' => 'not_in:0',
            'id_areae' => 'gt:0',
            'id_periocidade' => 'gt:0',
        ];
        $messages = [
            'basese.not_in' => 'Debe seleccionar base.',
            'id_areae.gt' => 'Debe seleccionar área.',
            'id_periocidade.gt' => 'Debe seleccionar periocidad.',
        ];
        if($request->id_periocidade=="2"){
            if($request->nom_dia_1e=="0" && $request->nom_dia_2e=="0" && $request->nom_dia_3e=="0"){
                $rules['dummy_fielde'] = 'gt:0';
                $messages['dummy_fielde.gt'] = 'Debe seleccionar al menos un día.';
            }
        }elseif($request->id_periocidade=="3"){
            $rules['dia_1e'] = 'gt:0';
            $messages['dia_1e.gt'] = 'Debe seleccionar día 1.';
            $rules['dia_2e'] = 'gt:0';
            $messages['dia_2e.gt'] = 'Debe seleccionar día 2.';
        }elseif($request->id_periocidade=="4"){
            $rules['diae'] = 'gt:0';
            $messages['diae.gt'] = 'Debe seleccionar día.';
        }elseif($request->id_periocidade=="5"){
            $rules['mese'] = 'gt:0';
            $messages['mese.gt'] = 'Debe seleccionar mes.';
            $rules['diae'] = 'gt:0';
            $messages['diae.gt'] = 'Debe seleccionar día.';
        }
        $rules['descripcione'] = 'required';
        $messages['descripcione.required'] = 'Debe ingresar descripción.';
        
        $request->validate($rules, $messages);

        ContenidoSeguimientoCoordinador::findOrFail($id)->update([
            'base' => $request->basese,
            'id_area' => $request->id_areae,
            'id_periocidad' => $request->id_periocidade,
            'nom_dia_1' => $request->nom_dia_1e,
            'nom_dia_2' => $request->nom_dia_2e,
            'nom_dia_3' => $request->nom_dia_3e,
            'dia_1' => $request->dia_1e,
            'dia_2' => $request->dia_2e,
            'dia' => $request->diae,
            'mes' => $request->mese,
            'descripcion' => $request->descripcione,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_conf_sc($id)
    {
        ContenidoSeguimientoCoordinador::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
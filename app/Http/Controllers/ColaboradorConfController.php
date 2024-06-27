<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Competencia;
use App\Models\CompetenciaPuesto;
use App\Models\Direccion;
use App\Models\FuncionesPuesto;
use App\Models\Gerencia;
use App\Models\NivelJerarquico;
use App\Models\Organigrama;
use App\Models\Puesto;
use App\Models\SedeLaboral;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class ColaboradorConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('rrhh.administracion.colaborador.index');
    }

    public function traer_gerencia(Request $request)
    {
        $list_gerencia = Gerencia::select('id_gerencia','nom_gerencia')->where('id_direccion',$request->id_direccion)->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.gerencia',compact('list_gerencia'));
    }

    public function traer_sub_gerencia(Request $request)
    {
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia','nom_sub_gerencia')->where('id_gerencia',$request->id_gerencia)->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia',compact('list_sub_gerencia'));
    }

    public function traer_area(Request $request)
    {
        $list_area = Area::select('id_area','nom_area')->where('id_departamento',$request->id_sub_gerencia)->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.area',compact('list_area'));
    }

    public function index_di()
    {
        return view('rrhh.administracion.colaborador.direccion.index');
    }

    public function list_di()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.direccion.lista', compact('list_direccion'));
    }

    public function create_di()
    {
        return view('rrhh.administracion.colaborador.direccion.modal_registrar');
    }

    public function store_di(Request $request)
    {
        $request->validate([
            'direccion' => 'required',
        ],[
            'direccion.required' => 'Debe ingresar dirección.',
        ]);

        $valida = Direccion::where('direccion', $request->direccion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Direccion::create([
                'direccion' => $request->direccion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_di($id)
    {
        $get_id = Direccion::findOrFail($id);
        return view('rrhh.administracion.colaborador.direccion.modal_editar', compact('get_id'));
    }

    public function update_di(Request $request, $id)
    {
        $request->validate([
            'direccione' => 'required',
        ],[
            'direccione.required' => 'Debe ingresar dirección.',
        ]);

        $valida = Direccion::where('direccion', $request->direccione)->where('estado', 1)->where('id_direccion', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Direccion::findOrFail($id)->update([
                'direccion' => $request->direccione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_di($id)
    {
        Direccion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ge()
    {
        return view('rrhh.administracion.colaborador.gerencia.index');
    }

    public function list_ge()
    {
        $list_gerencia = Gerencia::select('gerencia.id_gerencia','direccion.direccion','gerencia.nom_gerencia')
                                    ->join('direccion','direccion.id_direccion','=','gerencia.id_direccion')
                                    ->where('gerencia.estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.lista', compact('list_gerencia'));
    }

    public function create_ge()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.modal_registrar', compact('list_direccion'));
    }

    public function store_ge(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'nom_gerencia' => 'required',
        ],[
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'nom_gerencia.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Gerencia::where('id_direccion', $request->id_direccion)->where('nom_gerencia', $request->nom_gerencia)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Gerencia::create([
                'id_direccion' => $request->id_direccion,
                'nom_gerencia' => $request->nom_gerencia,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ge($id)
    {
        $get_id = Gerencia::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.modal_editar', compact('get_id','list_direccion'));
    }

    public function update_ge(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'nom_gerenciae' => 'required',
        ],[
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'nom_gerenciae.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Gerencia::where('id_direccion', $request->id_direccione)->where('nom_gerencia', $request->nom_gerenciae)->where('estado', 1)->where('id_gerencia', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Gerencia::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'nom_gerencia' => $request->nom_gerenciae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ge($id)
    {
        Gerencia::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_sg()
    {
        return view('rrhh.administracion.colaborador.sub_gerencia.index');
    }

    public function list_sg()
    {
        $list_sub_gerencia = SubGerencia::select('sub_gerencia.id_sub_gerencia','direccion.direccion','gerencia.nom_gerencia','sub_gerencia.nom_sub_gerencia')
                                    ->join('direccion','direccion.id_direccion','=','sub_gerencia.id_direccion')
                                    ->join('gerencia','gerencia.id_gerencia','=','sub_gerencia.id_gerencia')
                                    ->where('sub_gerencia.estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.lista', compact('list_sub_gerencia'));
    }

    public function create_sg()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.modal_registrar', compact('list_direccion'));
    }

    public function store_sg(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'nom_sub_gerencia' => 'required',
        ],[
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'id_gerencia.gt' => 'Debe seleccionar gerencia.',
            'nom_sub_gerencia.required' => 'Debe ingresar descripción.',
        ]);

        $valida = SubGerencia::where('id_direccion', $request->id_direccion)->where('id_gerencia', $request->id_gerencia)
                                ->where('nom_sub_gerencia', $request->nom_sub_gerencia)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            SubGerencia::create([
                'id_direccion' => $request->id_direccion,
                'id_gerencia' => $request->id_gerencia,
                'nom_sub_gerencia' => $request->nom_sub_gerencia,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_sg($id)
    {
        $get_id = SubGerencia::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia','nom_gerencia')->where('id_direccion',$get_id->id_direccion)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.modal_editar', compact('get_id','list_direccion','list_gerencia'));
    }

    public function update_sg(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'nom_sub_gerenciae' => 'required',
        ],[
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
            'nom_sub_gerenciae.required' => 'Debe ingresar descripción.',
        ]);

        $valida = SubGerencia::where('id_direccion', $request->id_direccione)->where('id_gerencia', $request->id_gerenciae)
                            ->where('nom_sub_gerencia', $request->nom_sub_gerenciae)->where('estado', 1)->where('id_sub_gerencia', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            SubGerencia::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'id_gerencia' => $request->id_gerenciae,
                'nom_sub_gerencia' => $request->nom_sub_gerenciae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_sg($id)
    {
        SubGerencia::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ar()
    {
        return view('rrhh.administracion.colaborador.area.index');
    }

    public function list_ar()
    {
        $list_area = Area::get_list_area();
        return view('rrhh.administracion.colaborador.area.lista', compact('list_area'));
    }

    public function create_ar()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.modal_registrar', compact('list_direccion'));
    }
    
    public function traer_puesto_ar(Request $request)
    {
        $list_puesto = Puesto::select('id_puesto','nom_puesto')->where('id_gerencia',$request->id_gerencia)->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.area.puestos',compact('list_puesto'));
    }

    public function store_ar(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'id_sub_gerencia' => 'gt:0',
            'nom_area' => 'required',
            'cod_area' => 'required',
        ],[
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'id_gerencia.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerencia.gt' => 'Debe seleccionar departamento.',
            'nom_area.required' => 'Debe ingresar descripción.',
            'cod_area.required' => 'Debe ingresar código.',
        ]);

        $valida = Area::where('id_direccion', $request->id_direccion)
                        ->where('id_gerencia', $request->id_gerencia)
                        ->where('id_departamento', $request->id_sub_gerencia)
                        ->where('nom_area', $request->nom_area)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            $puestos = "";
            if(is_array($request->puestos) && count($request->puestos)>0){
                $puestos = implode(",",$request->puestos);
            }
            Area::create([
                'id_direccion' => $request->id_direccion,
                'id_gerencia' => $request->id_gerencia,
                'id_departamento' => $request->id_sub_gerencia,
                'nom_area' => $request->nom_area,
                'cod_area' => $request->cod_area,
                'puestos' => $puestos,
                'orden' => $request->orden,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ar($id)
    {
        $get_id = Area::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia','nom_gerencia')->where('id_direccion',$get_id->id_direccion)->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia','nom_sub_gerencia')->where('id_gerencia',$get_id->id_gerencia)->where('estado', 1)->get();
        $list_puesto = Puesto::select('id_puesto','nom_puesto')->where('id_gerencia',$get_id->id_gerencia)->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.area.modal_editar', compact('get_id','list_direccion','list_gerencia','list_sub_gerencia','list_puesto'));
    }

    public function update_ar(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'id_sub_gerenciae' => 'gt:0',
            'nom_areae' => 'required',
            'cod_areae' => 'required',
        ],[
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerenciae.gt' => 'Debe seleccionar departamento.',
            'nom_areae.required' => 'Debe ingresar descripción.',
            'cod_areae.required' => 'Debe ingresar código.',
        ]);

        $valida = Area::where('id_direccion', $request->id_direccione)
                                ->where('id_gerencia', $request->id_gerenciae)
                                ->where('id_departamento', $request->id_sub_gerenciae)
                                ->where('nom_area', $request->nom_areae)->where('estado', 1)
                                ->where('id_area', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            $puestos = "";
            if(is_array($request->puestose) && count($request->puestose)>0){
                $puestos = implode(",",$request->puestose);
            }
            Area::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'id_gerencia' => $request->id_gerenciae,
                'id_departamento' => $request->id_sub_gerenciae,
                'nom_area' => $request->nom_areae,
                'cod_area' => $request->cod_areae,
                'puestos' => $puestos,
                'orden' => $request->ordene,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ar($id)
    {
        Area::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ni()
    {
        return view('rrhh.administracion.colaborador.nivel_jerarquico.index');
    }

    public function list_ni()
    {
        $list_nivel_jerarquico = NivelJerarquico::select('id_nivel','nom_nivel')->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.nivel_jerarquico.lista', compact('list_nivel_jerarquico'));
    }

    public function create_ni()
    {
        return view('rrhh.administracion.colaborador.nivel_jerarquico.modal_registrar');
    }

    public function store_ni(Request $request)
    {
        $request->validate([
            'nom_nivel' => 'required',
        ],[
            'nom_nivel.required' => 'Debe ingresar nombre.',
        ]);

        $valida = NivelJerarquico::where('nom_nivel', $request->nom_nivel)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            NivelJerarquico::create([
                'nom_nivel' => $request->nom_nivel,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ni($id)
    {
        $get_id = NivelJerarquico::findOrFail($id);
        return view('rrhh.administracion.colaborador.nivel_jerarquico.modal_editar', compact('get_id'));
    }

    public function update_ni(Request $request, $id)
    {
        $request->validate([
            'nom_nivele' => 'required',
        ],[
            'nom_nivele.required' => 'Debe ingresar nombre.',
        ]);


        $valida = NivelJerarquico::where('nom_nivel', $request->nom_nivele)->where('estado', 1)
                                    ->where('id_nivel', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            NivelJerarquico::findOrFail($id)->update([
                'nom_nivel' => $request->nom_nivele,
                'orden' => $request->ordene,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ni($id)
    {
        NivelJerarquico::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_se()
    {
        return view('rrhh.administracion.colaborador.sede_laboral.index');
    }

    public function list_se()
    {
        $list_sede_laboral = SedeLaboral::select('id','descripcion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sede_laboral.lista', compact('list_sede_laboral'));
    }

    public function create_se()
    {
        return view('rrhh.administracion.colaborador.sede_laboral.modal_registrar');
    }

    public function store_se(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'Debe ingresar nombre.',
        ]);

        $valida = SedeLaboral::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            SedeLaboral::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_se($id)
    {
        $get_id = SedeLaboral::findOrFail($id);
        return view('rrhh.administracion.colaborador.sede_laboral.modal_editar', compact('get_id'));
    }

    public function update_se(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar nombre.',
        ]);

        $valida = SedeLaboral::where('descripcion', $request->descripcione)->where('estado', 1)
                                ->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            SedeLaboral::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_se($id)
    {
        SedeLaboral::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_pu()
    {
        return view('rrhh.administracion.colaborador.puesto.index');
    }

    public function list_pu()
    {
        $list_puesto = Puesto::select('puesto.id_puesto','direccion.direccion','gerencia.nom_gerencia',
                                'sub_gerencia.nom_sub_gerencia','area.nom_area','puesto.nom_puesto',
                                'nivel_jerarquico.nom_nivel','sede_laboral.descripcion')
                                ->join('direccion','direccion.id_direccion','=','puesto.id_direccion')
                                ->join('gerencia','gerencia.id_gerencia','=','puesto.id_gerencia')
                                ->join('sub_gerencia','sub_gerencia.id_sub_gerencia','=','puesto.id_departamento')
                                ->join('area','area.id_area','=','puesto.id_area')
                                ->join('nivel_jerarquico','nivel_jerarquico.id_nivel','=','puesto.id_nivel')
                                ->join('sede_laboral','sede_laboral.id','=','puesto.id_sede_laboral')
                                ->where('puesto.estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto.lista', compact('list_puesto'));
    }

    public function create_pu()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        $list_nivel = NivelJerarquico::select('id_nivel','nom_nivel')->where('estado',1)->get();
        $list_sede_laboral = SedeLaboral::select('id','descripcion')->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.puesto.modal_registrar', compact('list_direccion','list_nivel','list_sede_laboral'));
    }

    public function store_pu(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'id_sub_gerencia' => 'gt:0',
            'id_area' => 'gt:0',
            'id_nivel' => 'gt:0',
            'id_sede_laboral' => 'gt:0',
            'cantidad' => 'gt:0',
            'nom_puesto' => 'required',
        ],[
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'id_gerencia.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerencia.gt' => 'Debe seleccionar departamento.',
            'id_area.gt' => 'Debe seleccionar área.',
            'id_nivel.gt' => 'Debe seleccionar nivel jerárquico.',
            'id_sede_laboral.gt' => 'Debe seleccionar sede laboral.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
            'nom_puesto.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Puesto::where('id_direccion', $request->id_direccion)
                        ->where('id_gerencia', $request->id_gerencia)
                        ->where('id_departamento', $request->id_sub_gerencia)
                        ->where('id_area', $request->id_area)
                        ->where('nom_puesto', $request->nom_puesto)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            $puesto = Puesto::create([
                'id_direccion' => $request->id_direccion,
                'id_gerencia' => $request->id_gerencia,
                'id_departamento' => $request->id_sub_gerencia,
                'id_area' => $request->id_area,
                'id_nivel' => $request->id_nivel,
                'id_sede_laboral' => $request->id_sede_laboral,
                'nom_puesto' => $request->nom_puesto,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if($request->cantidad>0){
                $i = 1;
                while($i<=$request->cantidad){
                    Organigrama::create([
                        'id_puesto' => $puesto->id_puesto,
                        'id_usuario' => 0,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario,
                    ]);
                    $i++;
                }
            }
        }
    }

    public function edit_pu($id)
    {
        $get_id = Puesto::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia','nom_gerencia')->where('id_direccion',$get_id->id_direccion)->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia','nom_sub_gerencia')->where('id_gerencia',$get_id->id_gerencia)->where('estado', 1)->get();
        $list_area = Area::select('id_area','nom_area')->where('id_departamento',$get_id->id_departamento)->where('estado', 1)->get();
        $list_nivel = NivelJerarquico::select('id_nivel','nom_nivel')->where('estado',1)->get();
        $list_sede_laboral = SedeLaboral::select('id','descripcion')->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.puesto.modal_editar', compact('get_id','list_direccion','list_gerencia','list_sub_gerencia','list_area','list_nivel','list_sede_laboral'));
    }

    public function update_pu(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'id_sub_gerenciae' => 'gt:0',
            'id_areae' => 'gt:0',
            'id_nivele' => 'gt:0',
            'id_sede_laborale' => 'gt:0',
            'nom_puestoe' => 'required',
        ],[
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerenciae.gt' => 'Debe seleccionar departamento.',
            'id_areae.gt' => 'Debe seleccionar área.',
            'id_nivele.gt' => 'Debe seleccionar nivel jerárquico.',
            'id_sede_laborale.gt' => 'Debe seleccionar sede laboral.',
            'nom_puestoe.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Puesto::where('id_direccion', $request->id_direccione)
                            ->where('id_gerencia', $request->id_gerenciae)
                            ->where('id_departamento', $request->id_sub_gerenciae)
                            ->where('id_area', $request->id_areae)
                            ->where('nom_puesto', $request->nom_puestoe)->where('estado', 1)
                            ->where('id_puesto', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Puesto::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'id_gerencia' => $request->id_gerenciae,
                'id_departamento' => $request->id_sub_gerenciae,
                'id_area' => $request->id_areae,
                'id_nivel' => $request->id_nivele,
                'id_sede_laboral' => $request->id_sede_laborale,
                'nom_puesto' => $request->nom_puestoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_pu($id)
    {
        Puesto::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function detalle_pu($id)
    {
        $get_id = Puesto::findOrFail($id);
        $list_competencia = Competencia::select('id_competencia','nom_competencia')->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.puesto.modal_detalle', compact('get_id','list_competencia'));
    }

    public function list_funcion_pu(Request $request)
    {
        $list_funcion = FuncionesPuesto::select('id_funcion','nom_funcion')
                                        ->where('id_puesto',$request->id_puesto)
                                        ->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.puesto.lista_funcion', compact('list_funcion'));
    }

    public function list_competencia_pu(Request $request)
    {
        $list_competencia = CompetenciaPuesto::select('competencia_puesto.id_competencia_puesto','competencia.nom_competencia')
                                                ->join('competencia','competencia.id_competencia','=','competencia_puesto.id_competencia')
                                                ->where('competencia_puesto.id_puesto',$request->id_puesto)
                                                ->where('competencia_puesto.estado',1)->get();
        return view('rrhh.administracion.colaborador.puesto.lista_competencia', compact('list_competencia'));
    }

    public function update_proposito_pu(Request $request, $id)
    {
        $request->validate([
            'propositod' => 'required',
            'propositod' => 'max:250',
        ],[
            'propositod.required' => 'Debe ingresar propósito.',
            'propositod.max' => 'El propósito debe tener como máximo 250 carácteres.',
        ]);

        Puesto::findOrFail($id)->update([
            'proposito' => $request->propositod,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function insert_funcion_pu(Request $request, $id)
    {
        $request->validate([
            'nom_funciond' => 'required',
        ],[
            'nom_funciond.required' => 'Debe ingresar función.',
        ]);

        FuncionesPuesto::create([
            'id_puesto' => $id,
            'nom_funcion' => $request->nom_funciond,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function edit_funcion_pu($id)
    {
        $get_id = FuncionesPuesto::findOrFail($id);
        return view('rrhh.administracion.colaborador.puesto.editar_funcion',compact('get_id'));
    }

    public function update_funcion_pu(Request $request, $id)
    {
        $request->validate([
            'nom_funciond' => 'required',
        ],[
            'nom_funciond.required' => 'Debe ingresar función.',
        ]);

        FuncionesPuesto::findOrFail($id)->update([
            'nom_funcion' => $request->nom_funciond,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function delete_funcion_pu($id)
    {
        FuncionesPuesto::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function insert_competencia_pu(Request $request, $id)
    {
        $request->validate([
            'id_competenciad' => 'gt:0',
        ],[
            'id_competenciad.gt' => 'Debe seleccionar competencia.',
        ]);

        $valida = CompetenciaPuesto::where('id_puesto', $id)
                                    ->where('id_competencia', $request->id_competenciad)
                                    ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            CompetenciaPuesto::create([
                'id_puesto' => $id,
                'id_competencia' => $request->id_competenciad,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function delete_competencia_pu($id)
    {
        CompetenciaPuesto::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ca()
    {
        return view('rrhh.administracion.colaborador.area.index');
    }

    public function list_ca()
    {
        $list_area = Area::select('area.id_area','direccion.direccion','gerencia.nom_gerencia','sub_gerencia.nom_sub_gerencia','area.nom_area','area.cod_area','area.orden')
                                    ->join('direccion','direccion.id_direccion','=','area.id_direccion')
                                    ->join('gerencia','gerencia.id_gerencia','=','area.id_gerencia')
                                    ->join('sub_gerencia','sub_gerencia.id_sub_gerencia','=','area.id_departamento')
                                    ->where('area.estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.lista', compact('list_area'));
    }

    public function create_ca()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.modal_registrar', compact('list_direccion'));
    }

    public function store_ca(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'id_sub_gerencia' => 'gt:0',
            'nom_area' => 'required',
            'cod_area' => 'required',
        ],[
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'id_gerencia.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerencia.gt' => 'Debe seleccionar departamento.',
            'nom_area.required' => 'Debe ingresar descripción.',
            'cod_area.required' => 'Debe ingresar código.',
        ]);

        $valida = Area::where('id_direccion', $request->id_direccion)
                        ->where('id_gerencia', $request->id_gerencia)
                        ->where('id_departamento', $request->id_sub_gerencia)
                        ->where('nom_area', $request->nom_area)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Area::create([
                'id_direccion' => $request->id_direccion,
                'id_gerencia' => $request->id_gerencia,
                'id_departamento' => $request->id_sub_gerencia,
                'nom_area' => $request->nom_area,
                'cod_area' => $request->cod_area,
                'orden' => $request->orden,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ca($id)
    {
        $get_id = Area::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia','nom_gerencia')->where('id_direccion',$get_id->id_direccion)->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia','nom_sub_gerencia')->where('id_gerencia',$get_id->id_gerencia)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.modal_editar', compact('get_id','list_direccion','list_gerencia','list_sub_gerencia'));
    }

    public function update_ca(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'id_sub_gerenciae' => 'gt:0',
            'nom_areae' => 'required',
            'cod_areae' => 'required',
        ],[
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerenciae.gt' => 'Debe seleccionar departamento.',
            'nom_areae.required' => 'Debe ingresar descripción.',
            'cod_areae.required' => 'Debe ingresar código.',
        ]);

        $valida = Area::where('id_direccion', $request->id_direccione)
                                ->where('id_gerencia', $request->id_gerenciae)
                                ->where('id_departamento', $request->id_sub_gerenciae)
                                ->where('nom_area', $request->nom_areae)->where('estado', 1)
                                ->where('id_area', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Area::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'id_gerencia' => $request->id_gerenciae,
                'id_departamento' => $request->id_sub_gerenciae,
                'nom_area' => $request->nom_areae,
                'cod_area' => $request->cod_areae,
                'orden' => $request->ordene,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ca($id)
    {
        Area::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
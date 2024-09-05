<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cargo;
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
use App\Models\DatacorpAccesos;
use App\Models\PaginasWebAccesos;
use App\Models\ProgramaAccesos;
use App\Models\EstadoCivil;
use App\Models\Idioma;
use App\Models\Nacionalidad;
use App\Models\Parentesco;
use App\Models\ReferenciaLaboral;
use App\Models\Regimen;
use App\Models\SituacionLaboral;
use App\Models\TipoContrato;
use App\Models\TipoDocumento;
// use App\Models\SituacionLaboral;
use Illuminate\Http\Request;
use App\Models\Notificacion;

class ColaboradorConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.administracion.colaborador.index', compact('list_notificacion'));
    }

    public function traer_gerencia(Request $request)
    {
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('id_direccion', $request->id_direccion)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia', compact('list_gerencia'));
    }

    public function traer_sub_gerencia(Request $request)
    {
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia', 'nom_sub_gerencia')->where('id_gerencia', $request->id_gerencia)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia', compact('list_sub_gerencia'));
    }

    public function traer_area(Request $request)
    {
        $list_area = Area::select('id_area', 'nom_area')->where('id_departamento', $request->id_sub_gerencia)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area', compact('list_area'));
    }

    public function traer_puesto(Request $request)
    {
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')->where('id_area', $request->id_area)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto', compact('list_puesto'));
    }

    public function index_di()
    {
        return view('rrhh.administracion.colaborador.direccion.index');
    }

    public function list_di()
    {
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
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
        ], [
            'direccion.required' => 'Debe ingresar dirección.',
        ]);

        $valida = Direccion::where('direccion', $request->direccion)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        ], [
            'direccione.required' => 'Debe ingresar dirección.',
        ]);

        $valida = Direccion::where('direccion', $request->direccione)->where('estado', 1)->where('id_direccion', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        $list_gerencia = Gerencia::select('gerencia.id_gerencia', 'direccion.direccion', 'gerencia.nom_gerencia')
            ->join('direccion', 'direccion.id_direccion', '=', 'gerencia.id_direccion')
            ->where('gerencia.estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.lista', compact('list_gerencia'));
    }

    public function create_ge()
    {
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.modal_registrar', compact('list_direccion'));
    }

    public function store_ge(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'nom_gerencia' => 'required',
        ], [
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'nom_gerencia.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Gerencia::where('id_direccion', $request->id_direccion)->where('nom_gerencia', $request->nom_gerencia)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.modal_editar', compact('get_id', 'list_direccion'));
    }

    public function update_ge(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'nom_gerenciae' => 'required',
        ], [
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'nom_gerenciae.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Gerencia::where('id_direccion', $request->id_direccione)->where('nom_gerencia', $request->nom_gerenciae)->where('estado', 1)->where('id_gerencia', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        $list_sub_gerencia = SubGerencia::select('sub_gerencia.id_sub_gerencia', 'direccion.direccion', 'gerencia.nom_gerencia', 'sub_gerencia.nom_sub_gerencia')
            ->join('direccion', 'direccion.id_direccion', '=', 'sub_gerencia.id_direccion')
            ->join('gerencia', 'gerencia.id_gerencia', '=', 'sub_gerencia.id_gerencia')
            ->where('sub_gerencia.estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.lista', compact('list_sub_gerencia'));
    }

    public function create_sg()
    {
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.modal_registrar', compact('list_direccion'));
    }

    public function store_sg(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'nom_sub_gerencia' => 'required',
        ], [
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'id_gerencia.gt' => 'Debe seleccionar gerencia.',
            'nom_sub_gerencia.required' => 'Debe ingresar descripción.',
        ]);

        $valida = SubGerencia::where('id_direccion', $request->id_direccion)->where('id_gerencia', $request->id_gerencia)
            ->where('nom_sub_gerencia', $request->nom_sub_gerencia)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('id_direccion', $get_id->id_direccion)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.modal_editar', compact('get_id', 'list_direccion', 'list_gerencia'));
    }

    public function update_sg(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'nom_sub_gerenciae' => 'required',
        ], [
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
            'nom_sub_gerenciae.required' => 'Debe ingresar descripción.',
        ]);

        $valida = SubGerencia::where('id_direccion', $request->id_direccione)->where('id_gerencia', $request->id_gerenciae)
            ->where('nom_sub_gerencia', $request->nom_sub_gerenciae)->where('estado', 1)->where('id_sub_gerencia', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.modal_registrar', compact('list_direccion'));
    }

    public function traer_puesto_ar(Request $request)
    {
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')->where('id_gerencia', $request->id_gerencia)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.puestos', compact('list_puesto'));
    }

    public function store_ar(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'id_sub_gerencia' => 'gt:0',
            'nom_area' => 'required',
            'cod_area' => 'required',
        ], [
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
        if ($valida) {
            echo "error";
        } else {
            $puestos = "";
            if (is_array($request->puestos) && count($request->puestos) > 0) {
                $puestos = implode(",", $request->puestos);
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
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('id_direccion', $get_id->id_direccion)->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia', 'nom_sub_gerencia')->where('id_gerencia', $get_id->id_gerencia)->where('estado', 1)->get();
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')->where('id_gerencia', $get_id->id_gerencia)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.modal_editar', compact('get_id', 'list_direccion', 'list_gerencia', 'list_sub_gerencia', 'list_puesto'));
    }

    public function update_ar(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'id_sub_gerenciae' => 'gt:0',
            'nom_areae' => 'required',
            'cod_areae' => 'required',
        ], [
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
        if ($valida) {
            echo "error";
        } else {
            $puestos = "";
            if (is_array($request->puestose) && count($request->puestose) > 0) {
                $puestos = implode(",", $request->puestose);
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
        $list_nivel_jerarquico = NivelJerarquico::select('id_nivel', 'nom_nivel')->where('estado', 1)->get();
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
        ], [
            'nom_nivel.required' => 'Debe ingresar nombre.',
        ]);

        $valida = NivelJerarquico::where('nom_nivel', $request->nom_nivel)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        ], [
            'nom_nivele.required' => 'Debe ingresar nombre.',
        ]);


        $valida = NivelJerarquico::where('nom_nivel', $request->nom_nivele)->where('estado', 1)
            ->where('id_nivel', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        $list_sede_laboral = SedeLaboral::select('id', 'descripcion')->where('estado', 1)->get();
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
        ], [
            'descripcion.required' => 'Debe ingresar nombre.',
        ]);

        $valida = SedeLaboral::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        ], [
            'descripcione.required' => 'Debe ingresar nombre.',
        ]);

        $valida = SedeLaboral::where('descripcion', $request->descripcione)->where('estado', 1)
            ->where('id', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
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

    public function index_co()
    {
        return view('rrhh.administracion.colaborador.competencia.index');
    }

    public function list_co()
    {
        $list_competencia = Competencia::select('id_competencia', 'nom_competencia', 'def_competencia')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.competencia.lista', compact('list_competencia'));
    }

    public function create_co()
    {
        return view('rrhh.administracion.colaborador.competencia.modal_registrar');
    }

    public function store_co(Request $request)
    {
        $request->validate([
            'nom_competencia' => 'required',
            'def_competencia' => 'required',
        ], [
            'nom_competencia.required' => 'Debe ingresar nombre.',
            'def_competencia.required' => 'Debe ingresar definición.',
        ]);

        $valida = Competencia::where('nom_competencia', $request->nom_competencia)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            Competencia::create([
                'nom_competencia' => $request->nom_competencia,
                'def_competencia' => $request->def_competencia,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_co($id)
    {
        $get_id = Competencia::findOrFail($id);
        return view('rrhh.administracion.colaborador.competencia.modal_editar', compact('get_id'));
    }

    public function update_co(Request $request, $id)
    {
        $request->validate([
            'nom_competenciae' => 'required',
            'def_competenciae' => 'required',
        ], [
            'nom_competenciae.required' => 'Debe ingresar nombre.',
            'def_competenciae.required' => 'Debe ingresar definición.',
        ]);

        $valida = Competencia::where('nom_competencia', $request->nom_competenciae)->where('estado', 1)
            ->where('id_competencia', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            Competencia::findOrFail($id)->update([
                'nom_competencia' => $request->nom_competenciae,
                'def_competencia' => $request->def_competenciae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_co($id)
    {
        Competencia::findOrFail($id)->update([
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
        $list_puesto = Puesto::select(
            'puesto.id_puesto',
            'direccion.direccion',
            'gerencia.nom_gerencia',
            'sub_gerencia.nom_sub_gerencia',
            'area.nom_area',
            'puesto.nom_puesto',
            'nivel_jerarquico.nom_nivel',
            'sede_laboral.descripcion'
        )
            ->join('direccion', 'direccion.id_direccion', '=', 'puesto.id_direccion')
            ->join('gerencia', 'gerencia.id_gerencia', '=', 'puesto.id_gerencia')
            ->join('sub_gerencia', 'sub_gerencia.id_sub_gerencia', '=', 'puesto.id_departamento')
            ->join('area', 'area.id_area', '=', 'puesto.id_area')
            ->join('nivel_jerarquico', 'nivel_jerarquico.id_nivel', '=', 'puesto.id_nivel')
            ->join('sede_laboral', 'sede_laboral.id', '=', 'puesto.id_sede_laboral')
            ->where('puesto.estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto.lista', compact('list_puesto'));
    }

    public function create_pu()
    {
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        $list_nivel = NivelJerarquico::select('id_nivel', 'nom_nivel')->where('estado', 1)->get();
        $list_sede_laboral = SedeLaboral::select('id', 'descripcion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto.modal_registrar', compact('list_direccion', 'list_nivel', 'list_sede_laboral'));
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
        ], [
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
        if ($valida) {
            echo "error";
        } else {
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

            if ($request->cantidad > 0) {
                $i = 1;
                while ($i <= $request->cantidad) {
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
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('id_direccion', $get_id->id_direccion)->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia', 'nom_sub_gerencia')->where('id_gerencia', $get_id->id_gerencia)->where('estado', 1)->get();
        $list_area = Area::select('id_area', 'nom_area')->where('id_departamento', $get_id->id_departamento)->where('estado', 1)->get();
        $list_nivel = NivelJerarquico::select('id_nivel', 'nom_nivel')->where('estado', 1)->get();
        $list_sede_laboral = SedeLaboral::select('id', 'descripcion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto.modal_editar', compact('get_id', 'list_direccion', 'list_gerencia', 'list_sub_gerencia', 'list_area', 'list_nivel', 'list_sede_laboral'));
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
        ], [
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
        if ($valida) {
            echo "error";
        } else {
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
        $list_competencia = Competencia::select('id_competencia', 'nom_competencia')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto.modal_detalle', compact('get_id', 'list_competencia'));
    }

    public function list_funcion_pu(Request $request)
    {
        $list_funcion = FuncionesPuesto::select('id_funcion', 'nom_funcion')
            ->where('id_puesto', $request->id_puesto)
            ->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto.lista_funcion', compact('list_funcion'));
    }

    public function list_competencia_pu(Request $request)
    {
        $list_competencia = CompetenciaPuesto::select('competencia_puesto.id_competencia_puesto', 'competencia.nom_competencia')
            ->join('competencia', 'competencia.id_competencia', '=', 'competencia_puesto.id_competencia')
            ->where('competencia_puesto.id_puesto', $request->id_puesto)
            ->where('competencia_puesto.estado', 1)->get();
        return view('rrhh.administracion.colaborador.puesto.lista_competencia', compact('list_competencia'));
    }

    public function update_proposito_pu(Request $request, $id)
    {
        $request->validate([
            'propositod' => 'required',
            'propositod' => 'max:250',
        ], [
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
        ], [
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
        return view('rrhh.administracion.colaborador.puesto.editar_funcion', compact('get_id'));
    }

    public function update_funcion_pu(Request $request, $id)
    {
        $request->validate([
            'nom_funciond' => 'required',
        ], [
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
        ], [
            'id_competenciad.gt' => 'Debe seleccionar competencia.',
        ]);

        $valida = CompetenciaPuesto::where('id_puesto', $id)
            ->where('id_competencia', $request->id_competenciad)
            ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        return view('rrhh.administracion.colaborador.cargo.index');
    }

    public function list_ca()
    {
        $list_cargo = Cargo::select(
            'cargo.id_cargo',
            'direccion.direccion',
            'gerencia.nom_gerencia',
            'sub_gerencia.nom_sub_gerencia',
            'area.nom_area',
            'puesto.nom_puesto',
            'cargo.nom_cargo'
        )
            ->join('direccion', 'direccion.id_direccion', '=', 'cargo.id_direccion')
            ->join('gerencia', 'gerencia.id_gerencia', '=', 'cargo.id_gerencia')
            ->join('sub_gerencia', 'sub_gerencia.id_sub_gerencia', '=', 'cargo.id_departamento')
            ->join('area', 'area.id_area', '=', 'cargo.id_area')
            ->join('puesto', 'puesto.id_puesto', '=', 'cargo.id_puesto')
            ->where('cargo.estado', 1)->get();
        return view('rrhh.administracion.colaborador.cargo.lista', compact('list_cargo'));
    }

    public function create_ca()
    {
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.cargo.modal_registrar', compact('list_direccion'));
    }

    public function store_ca(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'id_sub_gerencia' => 'gt:0',
            'id_area' => 'gt:0',
            'id_puesto' => 'gt:0',
            'nom_cargo' => 'required',
        ], [
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'id_gerencia.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerencia.gt' => 'Debe seleccionar departamento.',
            'id_area.gt' => 'Debe seleccionar área.',
            'id_puesto.gt' => 'Debe seleccionar puesto.',
            'nom_cargo.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Cargo::where('id_direccion', $request->id_direccion)
            ->where('id_gerencia', $request->id_gerencia)
            ->where('id_departamento', $request->id_sub_gerencia)
            ->where('id_area', $request->id_area)->where('id_puesto', $request->id_puesto)
            ->where('nom_cargo', $request->nom_cargo)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            Cargo::create([
                'id_direccion' => $request->id_direccion,
                'id_gerencia' => $request->id_gerencia,
                'id_departamento' => $request->id_sub_gerencia,
                'id_area' => $request->id_area,
                'id_puesto' => $request->id_puesto,
                'nom_cargo' => $request->nom_cargo,
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
        $get_id = Cargo::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('id_direccion', $get_id->id_direccion)->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia', 'nom_sub_gerencia')->where('id_gerencia', $get_id->id_gerencia)->where('estado', 1)->get();
        $list_area = Area::select('id_area', 'nom_area')->where('id_departamento', $get_id->id_departamento)->where('estado', 1)->get();
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')->where('id_area', $get_id->id_area)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.cargo.modal_editar', compact('get_id', 'list_direccion', 'list_gerencia', 'list_sub_gerencia', 'list_area', 'list_puesto'));
    }

    public function update_ca(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'id_sub_gerenciae' => 'gt:0',
            'id_areae' => 'gt:0',
            'id_puestoe' => 'gt:0',
            'nom_cargoe' => 'required',
        ], [
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerenciae.gt' => 'Debe seleccionar departamento.',
            'id_areae.gt' => 'Debe seleccionar área.',
            'id_puestoe.gt' => 'Debe seleccionar puesto.',
            'nom_cargoe.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Cargo::where('id_direccion', $request->id_direccione)
            ->where('id_gerencia', $request->id_gerenciae)
            ->where('id_departamento', $request->id_sub_gerenciae)
            ->where('id_area', $request->id_areae)
            ->where('id_puesto', $request->id_puestoe)
            ->where('nom_cargo', $request->nom_cargoe)->where('estado', 1)
            ->where('id_cargo', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            Cargo::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'id_gerencia' => $request->id_gerenciae,
                'id_departamento' => $request->id_sub_gerenciae,
                'id_area' => $request->id_areae,
                'id_puesto' => $request->id_puestoe,
                'nom_cargo' => $request->nom_cargoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ca($id)
    {
        Cargo::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    //DATACORP
    public function Index_Datacorp()
    {
        return view('rrhh.administracion.colaborador.Datacorp.index');
    }

    public function Listar_Accesos_Datacorp()
    {
        $list = DatacorpAccesos::join('area', 'datacorp_accesos.area', '=', 'area.id_area')
            ->join('puesto', 'datacorp_accesos.puesto', '=', 'puesto.id_puesto')
            ->where('datacorp_accesos.estado', 1)
            ->select('datacorp_accesos.*', 'area.*', 'puesto.*')
            //->orderBy('datacorp_accesos.fec_reg', 'DESC')
            ->get();
        return view('rrhh.administracion.colaborador.Datacorp.lista', compact('list'));
    }

    public function Modal_Registrar_Datacorp()
    {
        $list_area = Area::select('*')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->get();
        return view('rrhh.administracion.colaborador.Datacorp.modal_registrar', compact('list_area'));
    }

    public function Registrar_Datacorp(Request $request)
    {
        $request->validate([
            'id_area' => 'not_in:0',
            'id_puesto' => 'not_in:0',
            'carpeta_acceso' => 'required',
        ], [
            'id_area.not_in' => 'Debe seleccionar area.',
            'id_puesto.not_in' => 'Debe seleccionar puesto.',
            'carpeta_acceso.required' => 'Debe ingresar carpeta de acceso.',
        ]);

        $valida = DatacorpAccesos::where('area', $request->id_area)
            ->where('puesto', $request->id_puesto)
            ->where('carpeta_acceso', $request->carpeta_acceso)
            ->where('estado', 1)->exists();
        //alerta de validacion
        if ($valida) {
            echo "error";
        } else {
            DatacorpAccesos::create([
                'area' => $request->id_area,
                'puesto' => $request->id_puesto,
                'carpeta_acceso' => $request->carpeta_acceso,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function Modal_Update_Datacorp($id)
    {
        $list_area = Area::select('*')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->get();
        $get_id = DatacorpAccesos::select('*')
            ->where('estado', 1)
            ->where('id', $id)
            ->get();
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')
            ->where('id_area', $get_id[0]['area'])
            ->where('estado', 1)
            ->get();
        //print_r($list_puesto);
        return view('rrhh.administracion.colaborador.Datacorp.modal_editar', compact('list_area', 'get_id', 'list_puesto'));
    }

    public function Update_Datacorp(Request $request)
    {
        $request->validate([
            'id_area_e' => 'not_in:0',
            'id_puesto_e' => 'not_in:0',
            'carpeta_acceso_e' => 'required',
        ], [
            'id_area_e.not_in' => 'Debe seleccionar area.',
            'id_puesto_e.not_in' => 'Debe seleccionar puesto.',
            'carpeta_acceso_e.required' => 'Debe ingresar carpeta de acceso.',
        ]);

        $valida = DatacorpAccesos::where('area', $request->id_area_e)
            ->where('puesto', $request->id_puesto_e)
            ->where('carpeta_acceso', $request->carpeta_acceso_e)
            ->where('estado', 1)->exists();
        //alerta de validacion
        if ($valida) {
            echo "error";
        } else {
            DatacorpAccesos::findOrFail($request->id)->update([
                'area' => $request->id_area_e,
                'puesto' => $request->id_puesto_e,
                'carpeta_acceso' => $request->carpeta_acceso_e,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function Delete_Datacorp(Request $request)
    {
        //print_r($request->input('id'));
        DatacorpAccesos::findOrFail($request->id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    //PAGINAS
    public function Index_Paginas_Web()
    {
        return view('rrhh.administracion.colaborador.Paginas_web.index');
    }

    public function Listar_Accesos_Pagina()
    {
        $list = PaginasWebAccesos::join('area', 'paginas_web_accesos.area', '=', 'area.id_area')
            ->join('puesto', 'paginas_web_accesos.puesto', '=', 'puesto.id_puesto')
            ->where('paginas_web_accesos.estado', 1)
            ->select('paginas_web_accesos.*', 'area.*', 'puesto.*')
            ->get();
        return view('rrhh.administracion.colaborador.Paginas_web.lista', compact('list'));
    }

    public function Modal_Registrar_Pagina()
    {
        $list_area = Area::select('*')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->get();
        return view('rrhh.administracion.colaborador.Paginas_web.modal_registrar', compact('list_area'));
    }

    public function Registrar_Pagina(Request $request)
    {
        $request->validate([
            'id_area' => 'not_in:0',
            'id_puesto' => 'not_in:0',
            'pagina_acceso' => 'required',
        ], [
            'id_area.not_in' => 'Debe seleccionar area.',
            'id_puesto.not_in' => 'Debe seleccionar puesto.',
            'pagina_acceso.required' => 'Debe ingresar pagina de acceso.',
        ]);

        $valida = PaginasWebAccesos::where('area', $request->id_area)
            ->where('puesto', $request->id_puesto)
            ->where('pagina_acceso', $request->carpeta_acceso)
            ->where('estado', 1)->exists();
        //alerta de validacion
        if ($valida) {
            echo "error";
        } else {
            PaginasWebAccesos::create([
                'area' => $request->id_area,
                'puesto' => $request->id_puesto,
                'pagina_acceso' => $request->pagina_acceso,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function Modal_Update_Pagina($id)
    {
        $list_area = Area::select('*')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->get();
        $get_id = PaginasWebAccesos::select('*')
            ->where('estado', 1)
            ->where('id', $id)
            ->get();
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')
            ->where('id_area', $get_id[0]['area'])
            ->where('estado', 1)
            ->get();
        //print_r($list_puesto);
        return view('rrhh.administracion.colaborador.Paginas_web.modal_editar', compact('list_area', 'get_id', 'list_puesto'));
    }

    public function Update_Pagina(Request $request)
    {
        $request->validate([
            'id_area_e' => 'not_in:0',
            'id_puesto_e' => 'not_in:0',
            'pagina_acceso_e' => 'required',
        ], [
            'id_area_e.not_in' => 'Debe seleccionar area.',
            'id_puesto_e.not_in' => 'Debe seleccionar puesto.',
            'pagina_acceso_e.required' => 'Debe ingresar pagina de acceso.',
        ]);

        $valida = PaginasWebAccesos::where('area', $request->id_area_e)
            ->where('puesto', $request->id_puesto_e)
            ->where('pagina_acceso', $request->pagina_acceso_e)
            ->where('estado', 1)->exists();
        //alerta de validacion
        if ($valida) {
            echo "error";
        } else {
            PaginasWebAccesos::findOrFail($request->id)->update([
                'area' => $request->id_area_e,
                'puesto' => $request->id_puesto_e,
                'pagina_acceso' => $request->pagina_acceso_e,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function Delete_Pagina(Request $request)
    {
        //print_r($request->input('id'));
        PaginasWebAccesos::findOrFail($request->id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    //PROGRAMAS
    public function Index_Programas()
    {
        return view('rrhh.administracion.colaborador.Programas.index');
    }

    public function Listar_Accesos_Programa()
    {
        $list = ProgramaAccesos::join('area', 'programas_accesos.area', '=', 'area.id_area')
            ->join('puesto', 'programas_accesos.puesto', '=', 'puesto.id_puesto')
            ->where('programas_accesos.estado', 1)
            ->select('programas_accesos.*', 'area.*', 'puesto.*')
            //->orderBy('datacorp_accesos.fec_reg', 'DESC')
            ->get();
        return view('rrhh.administracion.colaborador.Programas.lista', compact('list'));
    }

    public function Modal_Registrar_Programa()
    {
        $list_area = Area::select('*')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->get();
        return view('rrhh.administracion.colaborador.Programas.modal_registrar', compact('list_area'));
    }

    public function Registrar_Programa(Request $request)
    {
        $request->validate([
            'id_area' => 'not_in:0',
            'id_puesto' => 'not_in:0',
            'programa' => 'required',
        ], [
            'id_area.not_in' => 'Debe seleccionar area.',
            'id_puesto.not_in' => 'Debe seleccionar puesto.',
            'programa.required' => 'Debe ingresar programa de acceso.',
        ]);

        $valida = ProgramaAccesos::where('area', $request->id_area)
            ->where('puesto', $request->id_puesto)
            ->where('programa', $request->programa)
            ->where('estado', 1)->exists();
        //alerta de validacion
        if ($valida) {
            echo "error";
        } else {
            ProgramaAccesos::create([
                'area' => $request->id_area,
                'puesto' => $request->id_puesto,
                'programa' => $request->programa,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function Modal_Update_Programa($id)
    {
        $list_area = Area::select('*')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->get();
        $get_id = ProgramaAccesos::select('*')
            ->where('estado', 1)
            ->where('id', $id)
            ->get();
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')
            ->where('id_area', $get_id[0]['area'])
            ->where('estado', 1)
            ->get();
        //print_r($list_puesto);
        return view('rrhh.administracion.colaborador.Programas.modal_editar', compact('list_area', 'get_id', 'list_puesto'));
    }

    public function Update_Programa(Request $request)
    {
        $request->validate([
            'id_area_e' => 'not_in:0',
            'id_puesto_e' => 'not_in:0',
            'programa_e' => 'required',
        ], [
            'id_area_e.not_in' => 'Debe seleccionar area.',
            'id_puesto_e.not_in' => 'Debe seleccionar puesto.',
            'programa_e.required' => 'Debe ingresar programa de acceso.',
        ]);

        $valida = ProgramaAccesos::where('area', $request->id_area_e)
            ->where('puesto', $request->id_puesto_e)
            ->where('programa', $request->programa_e)
            ->where('estado', 1)->exists();
        //alerta de validacion
        if ($valida) {
            echo "error";
        } else {
            ProgramaAccesos::findOrFail($request->id)->update([
                'area' => $request->id_area_e,
                'puesto' => $request->id_puesto_e,
                'programa' => $request->programa_e,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function Delete_Programa(Request $request)
    {
        //print_r($request->input('id'));
        ProgramaAccesos::findOrFail($request->id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function Estado_Civil()
    {
        $dato['list_estado_civil'] = EstadoCivil::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.EstadoCivil.index', $dato);
    }

    public function Modal_Estado_Civil()
    {
        return view('rrhh.administracion.colaborador.EstadoCivil.modal_registrar');
    }

    public function Insert_Estado_Civil(Request $request)
    {
        $request->validate([
            'cod_estado_civil' => 'required',
            'nom_estado_civil' => 'required',
        ], [
            'cod_estado_civil.required' => 'Debe ingresar codigo de estado civil.',
            'nom_estado_civil.required' => 'Debe ingresar descripcion de estado civil.',
        ]);

        $valida = EstadoCivil::where('cod_estado_civil', $request->input("cod_estado_civil"))
            ->where('nom_estado_civil', $request->input("nom_estado_civil"))
            ->where('estado', 1)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['cod_estado_civil'] = $request->input("cod_estado_civil");
            $dato['nom_estado_civil'] = $request->input("nom_estado_civil");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            EstadoCivil::create($dato);
        }
    }

    public function Modal_Update_Estado_Civil($id_estado_civil)
    {
        $dato['get_id'] = EstadoCivil::where('id_estado_civil', $id_estado_civil)
            ->get();
        return view('rrhh.administracion.colaborador.EstadoCivil.modal_editar', $dato);
    }

    public function Update_Estado_Civil(Request $request)
    {
        $request->validate([
            'cod_estado_civil_e' => 'required',
            'nom_estado_civil_e' => 'required',
        ], [
            'cod_estado_civil_e.required' => 'Debe ingresar codigo de estado civil.',
            'nom_estado_civil_e.required' => 'Debe ingresar descripcion de estado civil.',
        ]);

        $valida = EstadoCivil::where('cod_estado_civil', $request->input("cod_estado_civil_e"))
            ->where('nom_estado_civil', $request->input("nom_estado_civil_e"))
            ->where('estado', 1)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['cod_estado_civil'] = $request->input("cod_estado_civil_e");
            $dato['nom_estado_civil'] = $request->input("nom_estado_civil_e");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            EstadoCivil::findOrFail($request->id_estado_civil)->update($dato);
        }
    }

    public function Delete_Estado_Civil(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        EstadoCivil::findOrFail($request->id_estado_civil)->update($dato);
    }


    public function Idioma()
    {
        $dato['list_idioma'] = Idioma::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Idioma.index', $dato);
    }

    public function Modal_Idioma()
    {
        return view('rrhh.administracion.colaborador.Idioma.modal_registrar');
    }

    public function Insert_Idioma(Request $request)
    {
        $request->validate([
            'nom_idioma' => 'required',
        ], [
            'nom_idioma.required' => 'Debe ingresar descripcion de idioma.',
        ]);
        $valida = Idioma::where('nom_idioma', $request->input("nom_idioma"))
            ->where('estado', 1)
            ->exists();
        if ($valida > 0) {
            echo "error";
        } else {
            $dato['nom_idioma'] = $request->input("nom_idioma");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Idioma::create($dato);
        }
    }

    public function Modal_Update_Idioma($id_idioma)
    {
        $dato['get_id'] = Idioma::where('id_idioma', $id_idioma)
            ->get();
        return view('rrhh.administracion.colaborador.Idioma.modal_editar', $dato);
    }

    public function Update_Idioma(Request $request)
    {
        $request->validate([
            'nom_idioma_e' => 'required',
        ], [
            'nom_idioma_e.required' => 'Debe ingresar descripcion de idioma.',
        ]);
        $valida = Idioma::where('nom_idioma', $request->input("nom_idioma_e"))
            ->where('estado', 1)
            ->exists();
        if ($valida > 0) {
            echo "error";
        } else {
            $dato['nom_idioma'] = $request->input("nom_idioma_e");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Idioma::findOrFail($request->id_idioma)->update($dato);
        }
    }

    public function Delete_Idioma(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Idioma::findOrFail($request->id_idioma)->update($dato);
    }

    public function Nacionalidad()
    {
        $dato['list_nacionalidad'] = Nacionalidad::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Nacionalidad.index', $dato);
    }

    public function Modal_Nacionalidad()
    {
        return view('rrhh.administracion.colaborador.Nacionalidad.modal_registrar');
    }

    public function Insert_Nacionalidad(Request $request)
    {
        $request->validate([
            'pais_nacionalidad' => 'required',
            'nom_nacionalidad' => 'required',
        ], [
            'pais_nacionalidad.required' => 'Debe ingresar pais de nacionalidad.',
            'nom_nacionalidad.required' => 'Debe ingresar nacionalidad.',
        ]);
        $valida = Nacionalidad::where('pais_nacionalidad', $request->pais_nacionalidad)
            ->where('nom_nacionalidad', $request->nom_nacionalidad)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['pais_nacionalidad'] = $request->input("pais_nacionalidad");
            $dato['nom_nacionalidad'] = $request->input("nom_nacionalidad");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Nacionalidad::create($dato);
        }
    }

    public function Modal_Update_Nacionalidad($id_nacionalidad)
    {
        $dato['get_id'] = Nacionalidad::where('id_nacionalidad', $id_nacionalidad)
            ->get();
        return view('rrhh.administracion.colaborador.Nacionalidad.modal_editar', $dato);
    }

    public function Update_Nacionalidad(Request $request)
    {
        $request->validate([
            'pais_nacionalidad_e' => 'required',
            'nom_nacionalidad_e' => 'required',
        ], [
            'pais_nacionalidad_e.required' => 'Debe ingresar pais de nacionalidad.',
            'nom_nacionalidad_e.required' => 'Debe ingresar nacionalidad.',
        ]);
        $valida = Nacionalidad::where('pais_nacionalidad', $request->pais_nacionalidad_e)
            ->where('nom_nacionalidad', $request->nom_nacionalidad_e)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['pais_nacionalidad'] = $request->input("pais_nacionalidad_e");
            $dato['nom_nacionalidad'] = $request->input("nom_nacionalidad_e");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Nacionalidad::findOrFail($request->id_nacionalidad)->update($dato);
        }
    }

    public function Delete_Nacionalidad(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Nacionalidad::findOrFail($request->id_nacionalidad)->update($dato);
    }

    public function Parentesco()
    {
        $dato['list_parentesco'] = Parentesco::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Parentesco.index', $dato);
    }

    public function Modal_Parentesco()
    {
        return view('rrhh.administracion.colaborador.Parentesco.modal_registrar');
    }

    public function Insert_Parentesco(Request $request)
    {
        $request->validate([
            'cod_parentesco' => 'required',
            'nom_parentesco' => 'required',
        ], [
            'cod_parentesco.required' => 'Debe ingresar codigo de parentesco.',
            'nom_parentesco.required' => 'Debe ingresar descripcion de parentesco.',
        ]);

        $valida = Parentesco::where('cod_parentesco', $request->cod_parentesco)
            ->where('nom_parentesco', $request->nom_parentesco)
            ->where('estado', 1)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['cod_parentesco'] = $request->input("cod_parentesco");
            $dato['nom_parentesco'] = $request->input("nom_parentesco");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Parentesco::create($dato);
        }
    }

    public function Modal_Update_Parentesco($id_parentesco)
    {
        $dato['get_id'] = Parentesco::where('id_parentesco', $id_parentesco)
            ->get();
        return view('rrhh.administracion.colaborador.Parentesco.modal_editar', $dato);
    }

    public function Update_Parentesco(Request $request)
    {
        $request->validate([
            'cod_parentesco' => 'required',
            'nom_parentesco' => 'required',
        ], [
            'cod_parentesco.required' => 'Debe ingresar codigo de parentesco.',
            'nom_parentesco.required' => 'Debe ingresar descripcion de parentesco.',
        ]);

        $dato['cod_parentesco'] = $request->input("cod_parentesco");
        $dato['nom_parentesco'] = $request->input("nom_parentesco");
        $dato['fec_act'] = now();
        $dato['user_act'] = session('usuario')->id_usuario;
        Parentesco::findOrFail($request->id_parentesco)->update($dato);
    }

    public function Delete_Parentesco(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Parentesco::findOrFail($request->id_parentesco)->update($dato);
    }

    public function Referencia_Laboral()
    {
        $dato['list_referencia_laboral'] = ReferenciaLaboral::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.ReferenciaLaboral.index', $dato);
    }

    public function Modal_Referencia_Laboral()
    {
        return view('rrhh.administracion.colaborador.ReferenciaLaboral.modal_registrar');
    }

    public function Insert_Referencia_Laboral(Request $request)
    {
        $request->validate([
            'cod_referencia_laboral' => 'required',
            'nom_referencia_laboral' => 'required',
        ], [
            'cod_referencia_laboral.required' => 'Debe ingresar codigo de referencia laboral.',
            'nom_referencia_laboral.required' => 'Debe ingresar descripcion de referencia laboral.',
        ]);
        $valida = ReferenciaLaboral::where('cod_referencia_laboral', $request->cod_referencia_laboral)
            ->where('nom_referencia_laboral', $request->nom_referencia_laboral)
            ->where('estado', 1)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['cod_referencia_laboral'] = $request->input("cod_referencia_laboral");
            $dato['nom_referencia_laboral'] = $request->input("nom_referencia_laboral");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            ReferenciaLaboral::create($dato);
        }
    }

    public function Modal_Update_Referencia_Laboral($id_referencia_laboral)
    {
        $dato['get_id'] = ReferenciaLaboral::where('id_referencia_laboral', $id_referencia_laboral)
            ->get();
        return view('rrhh.administracion.colaborador.ReferenciaLaboral.modal_editar', $dato);
    }

    public function Update_Referencia_Laboral(Request $request)
    {
        $request->validate([
            'cod_referencia_laboral' => 'required',
            'nom_referencia_laboral' => 'required',
        ], [
            'cod_referencia_laboral.required' => 'Debe ingresar codigo de referencia laboral.',
            'nom_referencia_laboral.required' => 'Debe ingresar descripcion de referencia laboral.',
        ]);
        $valida = ReferenciaLaboral::where('cod_referencia_laboral', $request->cod_referencia_laboral)
            ->where('nom_referencia_laboral', $request->nom_referencia_laboral)
            ->where('estado', 1)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['id_referencia_laboral'] = $request->input("id_referencia_laboral");
            $dato['cod_referencia_laboral'] = $request->input("cod_referencia_laboral");
            $dato['nom_referencia_laboral'] = $request->input("nom_referencia_laboral");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            ReferenciaLaboral::findOrFail($request->id_referencia_laboral)->update($dato);
        }
    }

    public function Delete_Referencia_Laboral(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        ReferenciaLaboral::findOrFail($request->id_referencia_laboral)->update($dato);
    }

    public function Regimen()
    {
        $dato['list_regimen'] = Regimen::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Regimen.index', $dato);
    }

    public function Modal_Regimen()
    {
        return view('rrhh.administracion.colaborador.Regimen.modal_registrar');
    }

    public function Insert_Regimen(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
        ], [
            'codigo.required' => 'Debe ingresar codigo de regimen.',
            'nombre.required' => 'Debe ingresar descripcion de regimen.',
        ]);

        $valida = Regimen::where('cod_regimen', $request->codigo)
            ->where('nom_regimen', $request->nombre)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['cod_regimen'] = strtoupper($request->input("codigo"));
            $dato['nom_regimen'] = strtoupper($request->input("nombre"));
            $dato['dia_vacaciones'] = $request->input("vacaciones");
            $dato['da_mes'] = $dato['dia_vacaciones'] / 12;
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Regimen::create($dato);
        }
    }

    public function Modal_Update_Regimen($id_regimen)
    {
        $dato['get_id'] = Regimen::where('id_regimen', $id_regimen)
            ->get();
        return view('rrhh.administracion.colaborador.Regimen.modal_editar', $dato);
    }

    public function Update_Regimen(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
        ], [
            'codigo.required' => 'Debe ingresar codigo de regimen.',
            'nombre.required' => 'Debe ingresar descripcion de regimen.',
        ]);

        $valida = Regimen::where('cod_regimen', $request->codigo)
            ->where('nom_regimen', $request->nombre)
            ->where('dia_vacaciones', $request->vacaciones)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_regimen'] = strtoupper($request->input("codigo"));
            $dato['nom_regimen'] = strtoupper($request->input("nombre"));
            $dato['dia_vacaciones'] = $request->input("vacaciones");
            $dato['da_mes'] = $dato['dia_vacaciones'] / 12;
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;

            Regimen::findOrFail($request->id_regimen)->update($dato);
        }
    }

    public function Delete_regimen(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Regimen::findOrFail($request->input("id_regimen"))->update($dato);
    }


    public function Situacion_Laboral() // RRHH
    {
        $dato['list_situacion_laboral'] = SituacionLaboral::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.SituacionLaboral.index', $dato);
    }

    public function Modal_Situacion_Laboral()
    {
        return view('rrhh.administracion.colaborador.SituacionLaboral.modal_registrar');
    }

    public function Insert_Situacion_Laboral(Request $request)
    {
        $request->validate([
            'cod_situacion_laboral' => 'required',
            'nom_situacion_laboral' => 'required',
        ], [
            'cod_situacion_laboral.required' => 'Debe ingresar codigo de situacion laboral.',
            'nom_situacion_laboral.required' => 'Debe ingresar descripcion de situacion laboral.',
        ]);

        $valida = SituacionLaboral::where('cod_situacion_laboral', $request->nom_situacion_laboral)
            ->where('nom_situacion_laboral', $request->cod_situacion_laboral)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_situacion_laboral'] = $request->input("cod_situacion_laboral");
            $dato['nom_situacion_laboral'] = $request->input("nom_situacion_laboral");
            $dato['ficha'] = $request->input("ficha");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            SituacionLaboral::create($dato);
        }
    }

    public function Modal_Update_Situacion_Laboral($id_situacion_laboral)
    {
        $dato['get_id'] = SituacionLaboral::where('id_situacion_laboral', $id_situacion_laboral)
            ->get();
        return view('rrhh.administracion.colaborador.SituacionLaboral.modal_editar', $dato);
    }

    public function Update_Situacion_Laboral(Request $request)
    {
        $request->validate([
            'cod_situacion_laboral' => 'required',
            'nom_situacion_laboral' => 'required',
        ], [
            'cod_situacion_laboral.required' => 'Debe ingresar codigo de situacion laboral.',
            'nom_situacion_laboral.required' => 'Debe ingresar descripcion de situacion laboral.',
        ]);

        $valida = SituacionLaboral::where('cod_situacion_laboral', $request->cod_situacion_laboral)
            ->where('nom_situacion_laboral', $request->nom_situacion_laboral)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_situacion_laboral'] = $request->input("cod_situacion_laboral");
            $dato['nom_situacion_laboral'] = $request->input("nom_situacion_laboral");
            $dato['ficha'] = $request->input("ficha");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;

            SituacionLaboral::findOrFail($request->id_situacion_laboral)->update($dato);
        }
    }

    public function Delete_Situacion_Laboral(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        SituacionLaboral::findOrFail($request->input("id_situacion_laboral"))->update($dato);
    }

    //-------------------------------------TIPO CONTRATO----------------------------------
    public function Tipo_Contrato()
    {
        $dato['list_tipo_contrato'] = TipoContrato::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.TipoContrato.index', $dato);
    }

    public function Modal_Tipo_Contrato()
    {
        return view('rrhh.administracion.colaborador.TipoContrato.modal_registrar');
    }

    public function Insert_Tipo_Contrato(Request $request)
    {
        $request->validate([
            'nom_tipo_contrato' => 'required',
        ], [
            'nom_tipo_contrato.required' => 'Debe ingresar descripcion de situacion laboral.',
        ]);
        $valida = TipoContrato::where('nom_tipo_contrato', $request->nom_tipo_contrato)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['id_situacion_laboral'] = 2;
            $dato['nom_tipo_contrato'] = $request->input("nom_tipo_contrato");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            TipoContrato::create($dato);
        }
    }

    public function Modal_Update_Tipo_Contrato($id_tipo_contrato)
    {
        $dato['get_id'] = TipoContrato::where('id_tipo_contrato', $id_tipo_contrato)
            ->get();
        return view('rrhh.administracion.colaborador.TipoContrato.modal_editar', $dato);
    }

    public function Update_Tipo_Contrato(Request $request)
    {
        $request->validate([
            'nom_tipo_contrato' => 'required',
        ], [
            'nom_tipo_contrato.required' => 'Debe ingresar descripcion de situacion laboral.',
        ]);
        $valida = TipoContrato::where('nom_tipo_contrato', $request->nom_tipo_contrato)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['nom_tipo_contrato'] = $request->input("nom_tipo_contrato");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            TipoContrato::findOrFail($request->id_tipo_contrato)->update($dato);
        }
    }

    public function Delete_Tipo_Contrato(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        TipoContrato::findOrFail($request->input("id_tipo_contrato"))->update($dato);
    }


    //-------------------------------------TIPO DOCUMENTO---------------------------------
    public function Tipo_Documento()
    {
        $dato['list_tipo_doc'] = TipoDocumento::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.TipoDocumento.index', $dato);
    }

    public function Modal_Tipo_Documento()
    {
        return view('rrhh.administracion.colaborador.TipoDocumento.modal_registrar');
    }

    public function Insert_Tipo_Documento(Request $request)
    {
        $request->validate([
            'cod_tipo_documento' => 'required',
            'digitos' => 'required',
            'nom_tipo_documento' => 'required',
        ], [
            'cod_tipo_documento' => 'Debe ingresar codigo de tipo de documento',
            'digitos' => 'Debe ingresar digitos',
            'nom_tipo_documento.required' => 'Debe ingresar descripcion de situacion laboral.',
        ]);
        $valida = TipoDocumento::where('nom_tipo_documento', $request->nom_tipo_documento)
            ->where('digitos', $request->digitos)
            ->where('cod_tipo_documento', $request->cod_tipo_documento)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_tipo_documento'] = $request->input("cod_tipo_documento");
            $dato['nom_tipo_documento'] = $request->input("nom_tipo_documento");
            $dato['digitos'] = $request->input("digitos");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            TipoDocumento::create($dato);
        }
    }

    public function Modal_Update_Tipo_Documento($id_tipo_documento)
    {
        $dato['get_id'] = TipoDocumento::where('id_tipo_documento', $id_tipo_documento)
            ->get();
        return view('rrhh.administracion.colaborador.TipoDocumento.modal_editar', $dato);
    }

    public function Update_Tipo_Documento(Request $request)
    {
        $request->validate([
            'cod_tipo_documento' => 'required',
            'digitos' => 'required',
            'nom_tipo_documento' => 'required',
        ], [
            'cod_tipo_documento' => 'Debe ingresar codigo de tipo de documento',
            'digitos' => 'Debe ingresar digitos',
            'nom_tipo_documento.required' => 'Debe ingresar descripcion de situacion laboral.',
        ]);
        $valida = TipoDocumento::where('nom_tipo_documento', $request->nom_tipo_documento)
            ->where('digitos', $request->digitos)
            ->where('cod_tipo_documento', $request->cod_tipo_documento)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_tipo_documento'] = $request->input("cod_tipo_documento");
            $dato['nom_tipo_documento'] = $request->input("nom_tipo_documento");
            $dato['digitos'] = $request->input("digitos");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            TipoDocumento::findOrFail($request->input("id_tipo_documento"))->update($dato);
        }
    }

    public function Delete_Tipo_Documento(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        TipoDocumento::findOrFail($request->input("id_tipo_documento"))->update($dato);
    }
}

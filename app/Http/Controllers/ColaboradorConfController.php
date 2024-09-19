<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaUbicacion;
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
use App\Models\GrupoSanguineo;
use App\Models\TipoVia;
use App\Models\TipoVivienda;
use App\Models\Empresas;
use App\Models\Config;
use App\Models\Banco;
use App\Models\Genero;
use App\Models\Talla;
use App\Models\Accesorio;
use App\Models\GradoInstruccion;
use App\Models\Zona;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\ComisionAFP;
use App\Models\Turno;
use App\Models\Base;
use App\Models\Horario;
use App\Models\HorarioDia;
use App\Models\ToleranciaHorario;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\Ubicacion;

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
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia', 'nom_sub_gerencia')->where('estado', 1)->get();
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')->where('estado', 1)->get();
        $list_sedes = SedeLaboral::select('id', 'descripcion')->where('estado', 1)->get();
        $list_ubicaciones = Ubicacion::select('id_ubicacion', 'cod_ubi')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.area.modal_registrar', compact('list_direccion', 'list_gerencia', 'list_sub_gerencia', 'list_puesto', 'list_ubicaciones', 'list_sedes'));
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




            $area = Area::create([
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

            // Obtén las sedes seleccionadas
            $sedesSeleccionadas = $request->sedelaboral ?? [];

            // Obtén las ubicaciones seleccionadas
            $ubicacionesSeleccionadas = $request->ubicaciones ?? [];
            if (in_array(6, $sedesSeleccionadas)) {
                // Si se selecciona la sede con id 6, solo usa las ubicaciones seleccionadas
                if (count($ubicacionesSeleccionadas) > 0) {
                    // Elimina las entradas existentes para el id_area
                    AreaUbicacion::where('id_area', $area)->delete();

                    // Inserta las nuevas entradas
                    $data = array_map(function ($id_ubicacion) use ($area) {
                        return [
                            'id_area' => $area->id_area,
                            'id_ubicacion' => $id_ubicacion,
                            'user_reg' => session('usuario')->id_usuario,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario,
                        ];
                    }, $ubicacionesSeleccionadas);

                    AreaUbicacion::insert($data);
                }
            } else if (is_array($request->ubicaciones) && count($request->ubicaciones) > 0) {
                $data = array_map(function ($id_ubicacion) use ($area) {
                    return [
                        'id_area' => $area->id_area,
                        'id_ubicacion' => $id_ubicacion,
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario
                    ];
                }, $request->ubicaciones);

                // Inserta los registros en AreaUbicacion
                AreaUbicacion::insert($data);
            }
        }
    }

    public function edit_ar($id)
    {
        $get_id = Area::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion', 'direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('id_direccion', $get_id->id_direccion)->where('estado', 1)->get();
        $list_sub_gerencia = SubGerencia::select('id_sub_gerencia', 'nom_sub_gerencia')->where('id_gerencia', $get_id->id_gerencia)->where('estado', 1)->get();
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')->where('id_gerencia', $get_id->id_gerencia)->where('estado', 1)->get();

        $list_sedes = SedeLaboral::select('id', 'descripcion')
            ->where('estado', 1)
            ->get();
        // dd($list_ubicaciones);

        $list_ubicaciones = Ubicacion::select('id_ubicacion', 'cod_ubi', 'id_sede')
            ->where('id_sede', 6)
            ->where('estado', 1)
            ->get();

        $id_ubicaciones = AreaUbicacion::where('id_area', $get_id->id_area)
            ->join('ubicacion', 'area_ubicacion.id_ubicacion', '=', 'ubicacion.id_ubicacion')
            ->where('ubicacion.estado', 1)
            ->pluck('area_ubicacion.id_ubicacion') // Extrae solo los 'id_ubicacion'
            ->map(function ($id) {
                return (string) $id; // Convertir a string
            })
            ->toArray();


        $id_ubicaciones_by_sede = AreaUbicacion::where('id_area', $get_id->id_area)
            ->pluck('id_ubicacion')
            ->toArray();
        // Obtener los id_sede basados en los id_ubicaciones
        $id_sedes = Ubicacion::whereIn('id_ubicacion', $id_ubicaciones_by_sede)
            ->pluck('id_sede')
            ->unique() // Asegura que los IDs sean únicos
            ->toArray();
        // Obtener los sedes correspondientes
        $sedes = SedeLaboral::whereIn('id', $id_sedes)
            ->where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.area.modal_editar', compact('get_id', 'list_direccion', 'list_gerencia', 'list_sub_gerencia', 'list_puesto', 'list_sedes', 'list_ubicaciones', 'id_ubicaciones', 'sedes'));
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
            ->where('nom_area', $request->nom_areae)
            ->where('estado', 1)
            ->where('id_area', '!=', $id)->exists();

        if ($valida) {
            echo "error";
        } else {
            $puestos = "";
            if (is_array($request->puestose) && count($request->puestose) > 0) {
                $puestos = implode(",", $request->puestose);
            }

            // Obtén las sedes seleccionadas
            $sedesSeleccionadas = $request->sedelaborale ?? [];

            // Obtén las ubicaciones seleccionadas
            $ubicacionesSeleccionadas = $request->ubicacionesed ?? [];

            if (in_array(6, $sedesSeleccionadas)) {
                // Si se selecciona la sede con id 6, solo usa las ubicaciones seleccionadas
                if (count($ubicacionesSeleccionadas) > 0) {
                    // Elimina las entradas existentes para el id_area
                    AreaUbicacion::where('id_area', $id)->delete();

                    // Inserta las nuevas entradas
                    $data = array_map(function ($id_ubicacion) use ($id) {
                        return [
                            'id_area' => $id,
                            'id_ubicacion' => $id_ubicacion,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario,
                        ];
                    }, $ubicacionesSeleccionadas);

                    AreaUbicacion::insert($data);
                }
            } else {
                // Si no se selecciona la sede con id 6, procede a obtener ubicaciones por sedes
                if (count($sedesSeleccionadas) > 0) {
                    // Elimina las entradas existentes para el id_area
                    AreaUbicacion::where('id_area', $id)->delete();

                    // Obtén las ubicaciones asociadas a las sedes seleccionadas
                    $ubicaciones = Ubicacion::whereIn('id_sede', $sedesSeleccionadas)
                        ->where('estado', 1)
                        ->pluck('id_ubicacion');

                    // Inserta las nuevas entradas
                    $data = array_map(function ($id_ubicacion) use ($id) {
                        return [
                            'id_area' => $id,
                            'id_ubicacion' => $id_ubicacion,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario,
                        ];
                    }, $ubicaciones->toArray());

                    AreaUbicacion::insert($data);
                }
                // Además, si hay ubicaciones seleccionadas, agrégalas también
                if (count($ubicacionesSeleccionadas) > 0) {
                    // Obtén las ubicaciones seleccionadas que no están en las obtenidas por sedes
                    $ubicacionesADicionales = array_diff($ubicacionesSeleccionadas, $ubicaciones->toArray());

                    $dataAdicionales = array_map(function ($id_ubicacion) use ($id) {
                        return [
                            'id_area' => $id,
                            'id_ubicacion' => $id_ubicacion,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario,
                        ];
                    }, $ubicacionesADicionales);

                    AreaUbicacion::insert($dataAdicionales);
                }
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


    // public function update_ar(Request $request, $id)
    // {
    //     $request->validate([
    //         'id_direccione' => 'gt:0',
    //         'id_gerenciae' => 'gt:0',
    //         'id_sub_gerenciae' => 'gt:0',
    //         'nom_areae' => 'required',
    //         'cod_areae' => 'required',
    //     ], [
    //         'id_direccione.gt' => 'Debe seleccionar dirección.',
    //         'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
    //         'id_sub_gerenciae.gt' => 'Debe seleccionar departamento.',
    //         'nom_areae.required' => 'Debe ingresar descripción.',
    //         'cod_areae.required' => 'Debe ingresar código.',
    //     ]);

    //     $valida = Area::where('id_direccion', $request->id_direccione)
    //         ->where('id_gerencia', $request->id_gerenciae)
    //         ->where('id_departamento', $request->id_sub_gerenciae)
    //         ->where('nom_area', $request->nom_areae)->where('estado', 1)
    //         ->where('id_area', '!=', $id)->exists();

    //     if ($valida) {
    //         echo "error";
    //     } else {
    //         $puestos = "";
    //         if (is_array($request->puestose) && count($request->puestose) > 0) {
    //             $puestos = implode(",", $request->puestose);
    //         }

    //         // Si se han seleccionado sedes
    //         if (is_array($request->sedelaborale) && count($request->sedelaborale) > 0) {
    //             // Elimina las entradas existentes para el id_area
    //             AreaUbicacion::where('id_area', $id)->delete();

    //             // Obtén las ubicaciones asociadas a las sedes seleccionadas
    //             $ubicaciones = Ubicacion::whereIn('id_sede', $request->sedelaborale)
    //                 ->where('estado', 1)
    //                 ->pluck('id_ubicacion');

    //             // Inserta las nuevas entradas
    //             $data = array_map(function ($id_ubicacion) use ($id) {
    //                 return [
    //                     'id_area' => $id,
    //                     'id_ubicacion' => $id_ubicacion,
    //                     'fec_act' => now(),
    //                     'user_act' => session('usuario')->id_usuario,
    //                 ];
    //             }, $ubicaciones->toArray());

    //             AreaUbicacion::insert($data);
    //         }

    //         Area::findOrFail($id)->update([
    //             'id_direccion' => $request->id_direccione,
    //             'id_gerencia' => $request->id_gerenciae,
    //             'id_departamento' => $request->id_sub_gerenciae,
    //             'nom_area' => $request->nom_areae,
    //             'cod_area' => $request->cod_areae,
    //             'puestos' => $puestos,
    //             'orden' => $request->ordene,
    //             'fec_act' => now(),
    //             'user_act' => session('usuario')->id_usuario
    //         ]);
    //     }
    // }

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

    public function Delete_Regimen(Request $request)
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
            'nom_tipo_contrato.required' => 'Debe ingresar descripcion de tipo de contrato.',
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
            'nom_tipo_contrato.required' => 'Debe ingresar descripcion de tipo de contrato.',
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
            'nom_tipo_documento.required' => 'Debe ingresar descripcion de tipo de documento.',
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
            'nom_tipo_documento.required' => 'Debe ingresar descripcion de tipo de documento.',
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

    public function Grupo_Sanguineo()
    {
        $dato['list_grupo_sanguineo'] = GrupoSanguineo::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.GrupoSanguineo.index', $dato);
    }

    public function Modal_Grupo_Sanguineo()
    {
        return view('rrhh.administracion.colaborador.GrupoSanguineo.modal_registrar');
    }

    public function Insert_Grupo_Sanguineo(Request $request)
    {
        $request->validate([
            'cod_grupo_sanguineo' => 'required',
            'nom_grupo_sanguineo' => 'required',
        ], [
            'cod_grupo_sanguineo' => 'Debe ingresar codigo de grupo sanguineo',
            'nom_grupo_sanguineo.required' => 'Debe ingresar descripcion de grupo sanguineo.',
        ]);
        $valida = GrupoSanguineo::where('nom_grupo_sanguineo', $request->nom_grupo_sanguineo)
            ->where('cod_grupo_sanguineo', $request->cod_grupo_sanguineo)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_grupo_sanguineo'] = $request->input("cod_grupo_sanguineo");
            $dato['nom_grupo_sanguineo'] = $request->input("nom_grupo_sanguineo");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            GrupoSanguineo::create($dato);
        }
    }
    /*----------------------------------------Paolo*/
    public function Modal_Update_Grupo_Sanguineo($id_Grupo_Sanguineo)
    {
        $dato['get_id'] = GrupoSanguineo::where('id_grupo_sanguineo', $id_Grupo_Sanguineo)
            ->get();
        return view('rrhh.administracion.colaborador.GrupoSanguineo.modal_editar', $dato);
    }

    public function Update_Grupo_Sanguineo(Request $request)
    {
        $request->validate([
            'cod_grupo_sanguineo' => 'required',
            'nom_grupo_sanguineo' => 'required',
        ], [
            'cod_grupo_sanguineo' => 'Debe ingresar codigo de grupo sanguineo',
            'nom_grupo_sanguineo.required' => 'Debe ingresar descripcion de grupo sanguineo.',
        ]);
        $valida = GrupoSanguineo::where('nom_grupo_sanguineo', $request->nom_grupo_sanguineo)
            ->where('cod_grupo_sanguineo', $request->cod_grupo_sanguineo)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_grupo_sanguineo'] = $request->input("cod_grupo_sanguineo");
            $dato['nom_grupo_sanguineo'] = $request->input("nom_grupo_sanguineo");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            GrupoSanguineo::findOrFail($request->input("id_grupo_sanguineo"))->update($dato);
        }
    }

    public function Delete_Grupo_Sanguineo(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        GrupoSanguineo::findOrFail($request->input("id_grupo_sanguineo"))->update($dato);
    }

    public function Tipo_Via()
    {
        $dato['list_tipo_via'] = TipoVia::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.TipoVia.index', $dato);
    }

    public function Modal_Tipo_Via()
    {
        return view('rrhh.administracion.colaborador.TipoVia.modal_registrar');
    }

    public function Insert_Tipo_Via(Request $request)
    {
        $request->validate([
            'cod_tipo_via' => 'required',
            'nom_tipo_via' => 'required',
        ], [
            'cod_tipo_via' => 'Debe ingresar codigo de tipo de via',
            'nom_tipo_via.required' => 'Debe ingresar descripcion de tipo de via.',
        ]);
        $valida = TipoVia::where('nom_tipo_via', $request->nom_tipo_via)
            ->where('cod_tipo_via', $request->cod_tipo_via)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_tipo_via'] = $request->input("cod_tipo_via");
            $dato['nom_tipo_via'] = $request->input("nom_tipo_via");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            TipoVia::create($dato);
        }
    }

    public function Modal_Update_Tipo_Via($id_tipo_via)
    {
        $dato['get_id'] = TipoVia::where('id_tipo_via', $id_tipo_via)
            ->get();
        return view('rrhh.administracion.colaborador.TipoVia.modal_editar', $dato);
    }

    public function Update_Tipo_Via(Request $request)
    {
        $request->validate([
            'cod_tipo_via' => 'required',
            'nom_tipo_via' => 'required',
        ], [
            'cod_tipo_via' => 'Debe ingresar codigo de tipo de via',
            'nom_tipo_via.required' => 'Debe ingresar descripcion de tipo de via.',
        ]);

        $valida = TipoVia::where('nom_tipo_via', $request->nom_tipo_via)
            ->where('cod_tipo_via', $request->cod_tipo_via)
            ->where('estado', 1)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['cod_tipo_via'] = $request->input("cod_tipo_via");
            $dato['nom_tipo_via'] = $request->input("nom_tipo_via");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;

            TipoVia::findOrFail($request->input("id_tipo_via"))->update($dato);
        }
    }

    public function Delete_Tipo_Via(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        TipoVia::findOrFail($request->input("id_tipo_via"))->update($dato);
    }

    public function Tipo_Vivienda()
    {
        $dato['list_tipo_vivienda'] = TipoVivienda::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.TipoVivienda.index', $dato);
    }

    public function Modal_Tipo_Vivienda()
    {
        return view('rrhh.administracion.colaborador.TipoVivienda.modal_registrar');
    }

    public function Insert_Tipo_Vivienda(Request $request)
    {
        $request->validate([
            'nom_tipo_vivienda' => 'required',
        ], [
            'nom_tipo_vivienda.required' => 'Debe ingresar descripcion de tipo de vivienda.',
        ]);
        $valida = TipoVivienda::where('nom_tipo_vivienda', $request->nom_tipo_vivienda)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['nom_tipo_vivienda'] = $request->input("nom_tipo_vivienda");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            TipoVivienda::create($dato);
        }
    }

    public function Modal_Update_Tipo_Vivienda($id_tipo_vivienda)
    {
        $dato['get_id'] = TipoVivienda::where('id_tipo_vivienda', $id_tipo_vivienda)
            ->get();
        return view('rrhh.administracion.colaborador.TipoVivienda.modal_editar', $dato);
    }

    public function Update_Tipo_Vivienda(Request $request)
    {
        $request->validate([
            'nom_tipo_vivienda' => 'required',
        ], [
            'nom_tipo_vivienda.required' => 'Debe ingresar descripcion de tipo de vivienda.',
        ]);

        $valida = TipoVivienda::where('nom_tipo_vivienda', $request->nom_tipo_vivienda)
            ->where('estado', 1)
            ->exists();

        if ($valida) {
            echo "error";
        } else {
            $dato['nom_tipo_vivienda'] = $request->input("nom_tipo_vivienda");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;

            TipoVivienda::findOrFail($request->input("id_tipo_vivienda"))->update($dato);
        }
    }

    public function Delete_Tipo_Vivienda(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        TipoVivienda::findOrFail($request->input("id_tipo_vivienda"))->update($dato);
    }

    public function Banco()
    {
        $dato['list_banco'] = Banco::where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.Banco.index', $dato);
    }

    public function Modal_Banco()
    {
        return view('rrhh.administracion.colaborador.Banco.modal_registrar');
    }

    public function Insert_Banco(Request $request)
    {
        $request->validate([
            'cod_banco' => 'required',
            'nom_banco' => 'required',
            'digitos_cuenta' => 'required',
            'digitos_cci' => 'required',
        ], [
            'cod_banco.required' => 'Debe ingresar codigo de banco.',
            'nom_banco.required' => 'Debe ingresar descripcion de banco.',
            'digitos_cuenta.required' => 'Debe ingresar digitos de cuenta',
            'digitos_cci.required' => 'Debe ingresar digitos cci',
        ]);

        $valida = Banco::where('nom_banco', $request->nom_banco)
            ->where('cod_banco', $request->cod_banco)
            ->where('digitos_cuenta', $request->digitos_cuenta)
            ->where('digitos_cci', $request->digitos_cci)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_banco'] = $request->input("cod_banco");
            $dato['nom_banco'] = $request->input("nom_banco");
            $dato['digitos_cuenta'] = $request->input("digitos_cuenta");
            $dato['digitos_cci'] = $request->input("digitos_cci");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Banco::create($dato);
        }
    }

    public function Modal_Update_Banco($id_banco)
    {
        $dato['get_id'] = Banco::where('id_banco', $id_banco)->get();
        return view('rrhh.administracion.colaborador.Banco.modal_editar', $dato);
    }

    public function Update_Banco(Request $request)
    {
        $request->validate([
            'cod_banco' => 'required',
            'nom_banco' => 'required',
            'digitos_cuenta' => 'required',
            'digitos_cci' => 'required',
        ], [
            'cod_banco.required' => 'Debe ingresar codigo de banco.',
            'nom_banco.required' => 'Debe ingresar descripcion de banco.',
            'digitos_cuenta' => 'Debe ingresar digitos de cuenta',
            'digitos_cci' => 'Debe ingresar digitos cci',
        ]);

        $valida = Banco::where('nom_banco', $request->nom_banco)
            ->where('cod_banco', $request->cod_banco)
            ->where('digitos_cuenta', $request->digitos_cuenta)
            ->where('digitos_cci', $request->digitos_cci)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_banco'] = $request->input("cod_banco");
            $dato['nom_banco'] = $request->input("nom_banco");
            $dato['digitos_cuenta'] = $request->input("digitos_cuenta");
            $dato['digitos_cci'] = $request->input("digitos_cci");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Banco::findOrFail($request->id_banco)->update($dato);
        }
    }

    public function Delete_Banco(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Banco::findOrFail($request->input("id_banco"))->update($dato);
    }

    public function Provincia(Request $request)
    {
        $id_departamento = $request->input("id_departamento");
        $dato['list_provincia'] = DB::table('provincia')->where('id_departamento', $id_departamento)
            ->where('estado', 1)
            ->get();
        return view('layouts.provincia', $dato);
    }

    public function Distrito(Request $request)
    {
        $id_departamento = $request->input("id_departamento");
        $id_provincia = $request->input("id_provincia");
        $dato['list_distrito'] = DB::table('distrito')->where('id_departamento', $id_departamento)
            ->where('id_provincia', $id_provincia)
            ->get();
        return view('layouts.distrito', $dato);
    }

    public function Empresa()
    {
        $dato['list_empresa'] = Empresas::where('estado', 1)
            ->get();
        $dato['url'] = Config::where('descrip_config', 'Img_Empresa_Adm_Finanzas')
            ->get();
        return view('rrhh.administracion.colaborador.Empresa.index', $dato);
    }

    public function Modal_Empresa()
    {
        $dato['list_banco'] = Banco::where('estado', 1)->get();
        $dato['list_tipo_documento'] = TipoDocumento::where('estado', 1)->get();
        $dato['list_departamento'] = DB::table('departamento')->where('estado', 1)->get();
        $dato['list_provincia'] = DB::table('provincia')->where('estado', 1)->get();
        $dato['list_distrito'] = DB::table('distrito')->where('estado', 1)->get();
        $dato['list_regimen'] = Regimen::where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.Empresa.modal_registrar', $dato);
    }

    public function Insert_Empresa(Request $request)
    {
        $request->validate([
            'cod_empresa' => 'required',
            'nom_empresa' => 'required',
            'ruc_empresa' => 'required',
            'representante_empresa' => 'required',
            'id_tipo_documento' => 'required',
            'num_documento' => 'required',
            'id_departamento' => 'not_in:0',
            'id_distrito' => 'not_in:0',
            'id_provincia' => 'not_in:0',
            'direccion' => 'required',
        ], [
            'cod_empresa.required' => 'Debe ingresar codigo de empresa',
            'nom_empresa.required' => 'Debe ingresar nombre de empresa',
            'ruc_empresa.required' => 'Debe ingresar ruc de empresa',
            'representante_empresa.required' => 'Debe ingresar representante de empresa',
            'id_tipo_documento.required' => 'Debe ingresar tipo de documento de empresa',
            'num_documento.required' => 'Debe ingresar numero de documento de empresa',
            'id_departamento.not_in' => 'Debe ingresar departamento de empresa',
            'id_distrito.not_in' => 'Debe ingresar distrito de empresa',
            'id_provincia.not_in' => 'Debe ingresar provincia de empresa',
            'direccion.required' => 'Debe ingresar direccion de empresa',
        ]);
        $valida = Empresas::where("cod_empresa", $request->cod_empresa)
            ->where("nom_empresa", $request->nom_empresa)
            ->where("ruc_empresa", $request->ruc_empresa)
            ->where("representante_empresa", $request->representante_empresa)
            ->where("id_tipo_documento", $request->id_tipo_documento)
            ->where("num_documento", $request->num_documento)
            ->where("num_partida", $request->num_partida)
            ->where("id_departamento", $request->id_departamento)
            ->where("id_distrito", $request->id_distrito)
            ->where("id_provincia", $request->id_provincia)
            ->where("direccion", $request->direccion)
            ->exists();
        if ($valida > 0) {
            echo "error";
        } else {
            $dato['cod_empresa'] = $request->input("cod_empresa");
            $dato['nom_empresa'] = $request->input("nom_empresa");
            $dato['ruc_empresa'] = $request->input("ruc_empresa");
            $dato['id_banco'] = $request->input("id_banco");
            $dato['num_cuenta'] = $request->input("num_cuenta");
            $dato['email_empresa'] = $request->input("email_empresa");
            $dato['representante_empresa'] = $request->input("representante_empresa");
            $dato['id_tipo_documento'] = $request->input("id_tipo_documento");
            $dato['num_documento'] = $request->input("num_documento");
            $dato['num_partida'] = $request->input("num_partida");
            $dato['id_departamento'] = $request->input("id_departamento");
            $dato['id_distrito'] = $request->input("id_distrito");
            $dato['id_provincia'] = $request->input("id_provincia");
            $dato['direccion'] = $request->input("direccion");
            $dato['id_regimen'] = $request->input("id_regimen");
            $dato['activo'] = $request->input("activo");
            $dato['telefono_empresa'] = $request->input("telefono_empresa");
            $dato['inicio_actividad'] = $request->input("inicio_actividad");
            $dato['dias_laborales'] = $request->input("dias_laborales");
            $dato['hora_dia'] = $request->input("hora_dia");
            $dato['aporte_senati'] = $request->input("aporte_senati");
            $dato['firma'] = "";
            $dato['logo'] = "";
            $dato['pie'] = "";
            $dato['aporte_senati'] = 0;
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            if ($_FILES['firma']['name'] != "" || $_FILES['logo']['name'] != "" || $_FILES['pie']['name'] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ((!$con_id) || (!$lr)) {
                    echo "No se conecto";
                } else {
                    echo "Se conecto";
                    if ($_FILES['firma']['name'] != "") {
                        $path = $_FILES['firma']['name'];
                        $temp = explode(".", $_FILES['firma']['name']);
                        $source_file = $_FILES['firma']['tmp_name'];

                        $fecha = date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "Firma_" . $fecha . "_" . rand(10, 199);
                        $nombre = $nombre_soli . "." . $ext;

                        $dato['firma'] = $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "ADM_TABLAS/ADM_FINANZAS/EMPRESA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            echo "Archivo subido correctamente";
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                    if ($_FILES['logo']['name'] != "") {
                        $path = $_FILES['logo']['name'];
                        $temp = explode(".", $_FILES['logo']['name']);
                        $source_file = $_FILES['logo']['tmp_name'];

                        $fecha = date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "Logo_" . $fecha . "_" . rand(10, 199);
                        $nombre = $nombre_soli . "." . $ext;

                        $dato['logo'] = $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "ADM_TABLAS/ADM_FINANZAS/EMPRESA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            echo "Archivo subido correctamente";
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                    if ($_FILES['pie']['name'] != "") {
                        $path = $_FILES['pie']['name'];
                        $temp = explode(".", $_FILES['pie']['name']);
                        $source_file = $_FILES['pie']['tmp_name'];

                        $fecha = date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "PiePagina_" . $fecha . "_" . rand(10, 199);
                        $nombre = $nombre_soli . "." . $ext;

                        $dato['pie'] = $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "ADM_TABLAS/ADM_FINANZAS/EMPRESA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            echo "Archivo subido correctamente";
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            }
            Empresas::create($dato);
        }
    }

    public function Modal_Update_Empresa($id_empresa)
    {
        $dato['get_id'] = Empresas::where('id_empresa', $id_empresa)
            ->get();
        $id_departamento = $dato['get_id'][0]['id_departamento'];
        $id_provincia = $dato['get_id'][0]['id_provincia'];
        $dato['list_banco'] = Banco::where('estado', 1)->get();
        $dato['list_tipo_documento'] = TipoDocumento::where('estado', 1)->get();
        $dato['list_departamento'] = DB::table('departamento')->where('estado', 1)->get();
        $dato['list_provincia'] = DB::table('provincia')
            ->where('estado', 1)
            ->where('id_departamento', $id_departamento)
            ->get();
        $dato['list_distrito'] = DB::table('distrito')
            ->where('estado', 1)
            ->where('id_departamento', $id_departamento)
            ->where('id_provincia', $id_provincia)
            ->get();
        $dato['list_regimen'] = Regimen::where('estado', 1)->get();
        $dato['url'] = Config::where('descrip_config', 'Img_Empresa_Adm_Finanzas')
            ->where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Empresa.modal_editar', $dato);
    }

    public function Update_Empresa(Request $request)
    {
        $request->validate([
            'cod_empresa' => 'required',
            'nom_empresa' => 'required',
            'ruc_empresa' => 'required',
            'representante_empresa' => 'required',
            'id_tipo_documento' => 'required',
            'num_documento' => 'required',
            'id_departamento' => 'not_in:0',
            'id_distrito' => 'not_in:0',
            'id_provincia' => 'not_in:0',
            'direccion' => 'required',
        ], [
            'cod_empresa.required' => 'Debe ingresar codigo de empresa',
            'nom_empresa.required' => 'Debe ingresar nombre de empresa',
            'ruc_empresa.required' => 'Debe ingresar ruc de empresa',
            'representante_empresa.required' => 'Debe ingresar representante de empresa',
            'id_tipo_documento.required' => 'Debe ingresar tipo de documento de empresa',
            'num_documento.required' => 'Debe ingresar numero de documento de empresa',
            'id_departamento.not_in' => 'Debe ingresar departamento de empresa',
            'id_distrito.not_in' => 'Debe ingresar distrito de empresa',
            'id_provincia.not_in' => 'Debe ingresar provincia de empresa',
            'direccion.required' => 'Debe ingresar direccion de empresa',
        ]);
        $valida = Empresas::where("cod_empresa", $request->cod_empresa)
            ->where("nom_empresa", $request->nom_empresa)
            ->where("ruc_empresa", $request->ruc_empresa)
            ->where("representante_empresa", $request->representante_empresa)
            ->where("id_tipo_documento", $request->id_tipo_documento)
            ->where("num_documento", $request->num_documento)
            ->where("num_partida", $request->num_partida)
            ->where("id_departamento", $request->id_departamento)
            ->where("id_distrito", $request->id_distrito)
            ->where("id_provincia", $request->id_provincia)
            ->where("direccion", $request->direccion)
            ->exists();
        if ($valida > 0) {
            echo "error";
        } else {
            $dato['cod_empresa'] = $request->input("cod_empresa");
            $dato['nom_empresa'] = $request->input("nom_empresa");
            $dato['ruc_empresa'] = $request->input("ruc_empresa");
            $dato['id_banco'] = $request->input("id_banco");
            $dato['num_cuenta'] = $request->input("num_cuenta");
            $dato['email_empresa'] = $request->input("email_empresa");
            $dato['representante_empresa'] = $request->input("representante_empresa");
            $dato['id_tipo_documento'] = $request->input("id_tipo_documento");
            $dato['num_documento'] = $request->input("num_documento");
            $dato['num_partida'] = $request->input("num_partida");
            $dato['id_departamento'] = $request->input("id_departamento");
            $dato['id_distrito'] = $request->input("id_distrito");
            $dato['id_provincia'] = $request->input("id_provincia");
            $dato['direccion'] = $request->input("direccion");
            $dato['id_regimen'] = $request->input("id_regimen");
            $dato['activo'] = $request->input("activo");
            $dato['telefono_empresa'] = $request->input("telefono_empresa");
            $dato['inicio_actividad'] = $request->input("inicio_actividad");
            $dato['dias_laborales'] = $request->input("dias_laborales");
            $dato['hora_dia'] = $request->input("hora_dia");
            $dato['aporte_senati'] = $request->input("aporte_senati");
            $dato['firma'] = "";
            $dato['logo'] = "";
            $dato['pie'] = "";
            $dato['aporte_senati'] = 0;
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            if ($_FILES['firmae']['name'] != "" || $_FILES['logoe']['name'] != "" || $_FILES['piee']['name'] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ((!$con_id) || (!$lr)) {
                    echo "No se conecto";
                } else {
                    echo "Se conecto";
                    if ($_FILES['firmae']['name'] != "") {
                        $path = $_FILES['firmae']['name'];
                        $temp = explode(".", $_FILES['firmae']['name']);
                        $source_file = $_FILES['firmae']['tmp_name'];

                        $fecha = date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "Firma_" . $fecha . "_" . rand(10, 199);
                        $nombre = $nombre_soli . "." . $ext;

                        $dato['firma'] = $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "ADM_TABLAS/ADM_FINANZAS/EMPRESA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            echo "Archivo subido correctamente";
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                    if ($_FILES['logoe']['name'] != "") {
                        $path = $_FILES['logoe']['name'];
                        $temp = explode(".", $_FILES['logoe']['name']);
                        $source_file = $_FILES['logoe']['tmp_name'];

                        $fecha = date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "Logo_" . $fecha . "_" . rand(10, 199);
                        $nombre = $nombre_soli . "." . $ext;

                        $dato['logo'] = $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "ADM_TABLAS/ADM_FINANZAS/EMPRESA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            echo "Archivo subido correctamente";
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                    if ($_FILES['piee']['name'] != "") {
                        $path = $_FILES['piee']['name'];
                        $temp = explode(".", $_FILES['piee']['name']);
                        $source_file = $_FILES['piee']['tmp_name'];

                        $fecha = date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "PiePagina_" . $fecha . "_" . rand(10, 199);
                        $nombre = $nombre_soli . "." . $ext;

                        $dato['pie'] = $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "ADM_TABLAS/ADM_FINANZAS/EMPRESA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            echo "Archivo subido correctamente";
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            }
            Empresas::findOrFail($request->id_empresa)->update($dato);
        }
    }

    public function Delete_Empresa(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Empresas::findOrFail($request->id_empresa)->update($dato);
    }

    public function Genero()
    {
        $dato['list_genero'] = Genero::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Genero.index', $dato);
    }

    public function Modal_Genero()
    {
        return view('rrhh.administracion.colaborador.Genero.modal_registrar');
    }

    public function Insert_Genero(Request $request)
    {
        $request->validate([
            'cod_genero' => 'required',
            'nom_genero' => 'required',
        ], [
            'cod_genero' => 'Debe ingresar código de género',
            'nom_genero' => 'Debe ingresar nombre de genero',
        ]);
        $valida = Genero::where('cod_genero', $request->cod_genero)
            ->where('nom_genero', $request->nom_genero)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_genero'] = $request->input("cod_genero");
            $dato['nom_genero'] = $request->input("nom_genero");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Genero::create($dato);
        }
    }

    public function Modal_Update_Genero($id_genero)
    {
        $dato['get_id'] = Genero::where('id_genero', $id_genero)
            ->get();
        return view('rrhh.administracion.colaborador.Genero.modal_editar', $dato);
    }

    public function Update_Genero(Request $request)
    {
        $request->validate([
            'cod_genero' => 'required',
            'nom_genero' => 'required',
        ], [
            'cod_genero' => 'Debe ingresar código de género',
            'nom_genero' => 'Debe ingresar nombre de genero',
        ]);
        $valida = Genero::where('cod_genero', $request->cod_genero)
            ->where('nom_genero', $request->nom_genero)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_genero'] = $request->input("cod_genero");
            $dato['nom_genero'] = $request->input("nom_genero");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Genero::findOrFail($request->input("id_genero"))->update($dato);
        }
    }

    public function Delete_Genero(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Genero::findOrFail($request->input("id_genero"))->update($dato);
    }

    public function Accesorio()
    {
        $dato['list_accesorio'] = Accesorio::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Accesorio.index', $dato);
    }

    public function Modal_Accesorio()
    {
        return view('rrhh.administracion.colaborador.Accesorio.modal_registrar');
    }

    public function Insert_Accesorio(Request $request)
    {
        $request->validate([
            'nom_accesorio' => 'required',
        ], [
            'nom_accesorio.required' => 'Debe ingresar nombre de accesorio',
        ]);
        $valida = Accesorio::where('nom_accesorio', $request->nom_accesorio)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['nom_accesorio'] = $request->input("nom_accesorio");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Accesorio::create($dato);
        }
    }

    public function Modal_Update_Accesorio($id_accesorio)
    {
        $dato['get_id'] = Accesorio::where('id_accesorio', $id_accesorio)
            ->get();
        return view('rrhh.administracion.colaborador.Accesorio.modal_editar', $dato);
    }

    public function Update_Accesorio(Request $request)
    {
        $request->validate([
            'nom_accesorio' => 'required',
        ], [
            'nom_accesorio.required' => 'Debe ingresar nombre de accesorio',
        ]);
        $valida = Accesorio::where('nom_accesorio', $request->nom_accesorio)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['nom_accesorio'] = $request->input("nom_accesorio");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Accesorio::findOrFail($request->input("id_accesorio"))->update($dato);
        }
    }

    public function Delete_Accesorio(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Accesorio::findOrFail($request->input("id_accesorio"))->update($dato);
    }

    public function Talla()
    {
        $dato['list_talla'] = Talla::where('talla.estado', 1)
            ->leftJoin('accesorio', 'accesorio.id_accesorio', '=', 'talla.id_accesorio')
            ->get();

        return view('rrhh.administracion.colaborador.Talla.index', $dato);
    }

    public function Modal_Talla()
    {
        $dato['list_accesorio'] = Accesorio::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Talla.modal_registrar', $dato);
    }

    public function Insert_Talla(Request $request)
    {
        $request->validate([
            'id_accesorio' => 'not_in:0',
            'cod_talla' => 'required',
            'nom_talla' => 'required',
        ], [
            'id_accesorio' => 'Debe seleccionar accesorio',
            'cod_talla' => 'Debe ingresar código de talla',
            'nom_talla' => 'Debe ingresar nombre de talla',
        ]);
        $valida = Talla::where('id_accesorio', $request->id_accesorio)
            ->where('cod_talla', $request->cod_talla)
            ->where('nom_talla', $request->nom_talla)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['id_accesorio'] = $request->input('id_accesorio');
            $dato['cod_talla'] = $request->input("cod_talla");
            $dato['nom_talla'] = $request->input("nom_talla");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Talla::create($dato);
        }
    }

    public function Modal_Update_Talla($id_talla)
    {
        $dato['get_id'] = Talla::where('id_talla', $id_talla)
            ->get();
        $dato['list_accesorio'] = Accesorio::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Talla.modal_editar', $dato);
    }

    public function Update_Talla(Request $request)
    {
        $request->validate([
            'id_accesorio' => 'required',
            'cod_talla' => 'required',
            'nom_talla' => 'required',
        ], [
            'id_accesorio' => 'Debe seleccionar accesorio',
            'cod_talla' => 'Debe ingresar código de género',
            'nom_talla' => 'Debe ingresar nombre de talla',
        ]);
        $valida = Talla::where('id_accesorio', $request->id_accesorio)
            ->where('cod_talla', $request->cod_talla)
            ->where('nom_talla', $request->nom_talla)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['id_accesorio'] = $request->input('id_accesorio');
            $dato['cod_talla'] = $request->input("cod_talla");
            $dato['nom_talla'] = $request->input("nom_talla");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Talla::findOrFail($request->input("id_talla"))->update($dato);
        }
    }

    public function Delete_Talla(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Talla::findOrFail($request->input("id_talla"))->update($dato);
    }

    public function Grado_Instruccion()
    {
        $dato['list_grado_instruccion'] = GradoInstruccion::where('estado', 1)
            ->get();

        return view('rrhh.administracion.colaborador.GradoInstruccion.index', $dato);
    }

    public function Modal_Grado_Instruccion()
    {
        return view('rrhh.administracion.colaborador.GradoInstruccion.modal_registrar');
    }

    public function Insert_Grado_Instruccion(Request $request)
    {
        $request->validate([
            'cod_grado_instruccion' => 'required',
            'nom_grado_instruccion' => 'required',
        ], [
            'cod_grado_instruccion' => 'Debe ingresar código de grado_instruccion',
            'nom_grado_instruccion' => 'Debe ingresar nombre de grado_instruccion',
        ]);
        $valida = GradoInstruccion::where('cod_grado_instruccion', $request->cod_grado_instruccion)
            ->where('nom_grado_instruccion', $request->nom_grado_instruccion)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_grado_instruccion'] = $request->input("cod_grado_instruccion");
            $dato['nom_grado_instruccion'] = $request->input("nom_grado_instruccion");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            GradoInstruccion::create($dato);
        }
    }

    public function Modal_Update_Grado_Instruccion($id_grado_instruccion)
    {
        $dato['get_id'] = GradoInstruccion::where('id_grado_instruccion', $id_grado_instruccion)
            ->get();
        return view('rrhh.administracion.colaborador.GradoInstruccion.modal_editar', $dato);
    }

    public function Update_Grado_Instruccion(Request $request)
    {
        $request->validate([
            'cod_grado_instruccion' => 'required',
            'nom_grado_instruccion' => 'required',
        ], [
            'cod_grado_instruccion' => 'Debe ingresar código de género',
            'nom_grado_instruccion' => 'Debe ingresar nombre de grado_instruccion',
        ]);
        $valida = GradoInstruccion::where('cod_grado_instruccion', $request->cod_grado_instruccion)
            ->where('nom_grado_instruccion', $request->nom_grado_instruccion)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['cod_grado_instruccion'] = $request->input("cod_grado_instruccion");
            $dato['nom_grado_instruccion'] = $request->input("nom_grado_instruccion");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            GradoInstruccion::findOrFail($request->input("id_grado_instruccion"))->update($dato);
        }
    }

    public function Delete_Grado_Instruccion(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        GradoInstruccion::findOrFail($request->input("id_grado_instruccion"))->update($dato);
    }

    public function Zona()
    {
        $dato['list_zona'] = Zona::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Zona.index', $dato);
    }

    public function Modal_Zona()
    {
        return view('rrhh.administracion.colaborador.Zona.modal_registrar');
    }

    public function Insert_Zona(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'descripcion' => 'required',
        ], [
            'numero' => 'Debe ingresar numero de zona',
            'descripcion' => 'Debe ingresar nombre de zona',
        ]);
        $valida = Zona::where('numero', $request->numero)
            ->where('descripcion', $request->descripcion)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['numero'] = $request->input("numero");
            $dato['descripcion'] = $request->input("descripcion");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Zona::create($dato);
        }
    }

    public function Modal_Update_Zona($id_zona)
    {
        $dato['get_id'] = Zona::where('id_zona', $id_zona)
            ->get();
        return view('rrhh.administracion.colaborador.Zona.modal_editar', $dato);
    }

    public function Update_Zona(Request $request)
    {
        $request->validate([
            'numeroe' => 'required',
            'descripcione' => 'required',
        ], [
            'numeroe' => 'Debe ingresar numero de zona',
            'descripcione' => 'Debe ingresar nombre de zona',
        ]);
        $valida = Zona::where('numero', $request->numeroe)
            ->where('descripcion', $request->descripcione)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['numero'] = $request->input("numeroe");
            $dato['descripcion'] = $request->input("descripcione");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Zona::findOrFail($request->input("id_zona"))->update($dato);
        }
    }

    public function Delete_Zona(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Zona::findOrFail($request->input("id_zona"))->update($dato);
    }

    public function Excel_ZonaPL()
    {
        $data = Zona::where('estado', 1)
            ->get();
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('T6 Zona');
        $sheet->setCellValue('A1', 'TABLA 6: "ZONA"');
        $sheet->setCellValue('A3', 'N°');
        $sheet->setCellValue('B3', 'DESCRIPCIÓN');
        $sheet->mergeCells("A1:B1");

        //border
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("A3:B3")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle('A1:B3')->getFont()->setBold(true);
        $start = 3;
        foreach ($data as $d) {
            $start = $start + 1;

            $spreadsheet->getActiveSheet()->setCellValue("A{$start}", $d['numero']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$start}", $d['descripcion']);


            $sheet->getStyle("A{$start}:B{$start}")->applyFromArray($styleThinBlackBorderOutline);
        }
        $sheet->getStyle("A1")->getFont()->setSize(12);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:B3')->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(55);
        $curdate = date('d-m-Y');
        $filename = 'T6 Zona_' . $curdate;
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function Comision_AFP()
    {
        $dato['list_comision'] = ComisionAFP::where('afp.estado', 1)
            ->leftJoin('sistema_pensionario', 'sistema_pensionario.id_sistema_pensionario', '=', 'afp.id_sistema_pensionario')
            ->get();
        return view('rrhh.administracion.colaborador.Comision.index', $dato);
    }

    public function Modal_Comision_AFP()
    {
        $list_sistema_pensionario = DB::table('sistema_pensionario')
            ->select('*')
            ->get();
        return view('rrhh.administracion.colaborador.Comision.modal_registrar', compact('list_sistema_pensionario'));
    }

    public function Insert_Comision_AFP(Request $request)
    {
        $request->validate([
            'id_sistema_pensionario' => 'not_in:0',
            'cod_comision' => 'required',
            'nom_comision' => 'required',
        ], [
            'id_sistema_pensionario' => 'Debe seleccionar sistema pensionario',
            'cod_comision' => 'Debe ingresar código de comision',
            'nom_comision' => 'Debe ingresar nombre de comision',
        ]);
        $valida = ComisionAFP::where('id_sistema_pensionario', $request->id_sistema_pensionario)
            ->where('cod_afp', $request->cod_comision)
            ->where('nom_afp', $request->nom_comision)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['id_sistema_pensionario'] = $request->input("id_sistema_pensionario");
            $dato['cod_afp'] = $request->input("cod_comision");
            $dato['nom_afp'] = $request->input("nom_comision");
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            ComisionAFP::create($dato);
        }
    }

    public function Modal_Update_Comision_AFP($id_afp)
    {
        $dato['list_sistema_pensionario'] = DB::table('sistema_pensionario')
            ->select('*')
            ->get();
        $dato['get_id'] = ComisionAFP::where('id_afp', $id_afp)
            ->get();
        return view('rrhh.administracion.colaborador.Comision.modal_editar', $dato);
    }

    public function Update_Comision_AFP(Request $request)
    {
        $request->validate([
            'id_sistema_pensionario' => 'not_in:0',
            'cod_comision' => 'required',
            'nom_comision' => 'required',
        ], [
            'id_sistema_pensionario' => 'Debe seleccionar sistema pensionario',
            'cod_comision' => 'Debe ingresar código de comision',
            'nom_comision' => 'Debe ingresar nombre de comision',
        ]);
        $valida = ComisionAFP::where('id_sistema_pensionario', $request->id_sistema_pensionario)
            ->where('cod_afp', $request->cod_comision)
            ->where('nom_afp', $request->nom_comision)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['id_sistema_pensionario'] = $request->input("id_sistema_pensionario");
            $dato['cod_afp'] = $request->input("cod_comision");
            $dato['nom_afp'] = $request->input("nom_comision");
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            ComisionAFP::findOrFail($request->input("id_comision"))->update($dato);
        }
    }

    public function Delete_Comision_AFP(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        ComisionAFP::findOrFail($request->input("id_comision"))->update($dato);
    }

    public function Turno()
    {
        $dato['list_turno'] = Turno::where('estado', 1)
            ->get();
        return view('rrhh.administracion.colaborador.Turno.index', $dato);
    }

    public function Modal_Turno()
    {
        $dato['list_base'] = Base::get_list_todas_bases_agrupadas();
        return view('rrhh.administracion.colaborador.Turno.modal_registrar', $dato);
    }

    public function Insert_Turno(Request $request)
    {
        $request->validate([
            'base' => 'required',
            'entrada' => 'required',
            'salida' => 'required',
            't_refrigerio' => 'required',
        ], [
            'base' => 'Debe seleccionar base',
            'entrada' => 'Debe ingresar entrada',
            'salida' => 'Debe ingresar salida',
            't_refrigerio' => 'Debe seleccionar tipo de refrigerio',
        ]);
        $valida = Turno::where('base', $request->base)
            ->where('entrada', $request->entrada)
            ->where('salida', $request->salida)
            ->where('t_refrigerio', $request->t_refrigerio)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['base'] = $request->input("base");
            $dato['entrada'] = $request->input("entrada");
            $dato['salida'] = $request->input("salida");
            $dato['t_refrigerio'] = $request->input("t_refrigerio");
            $dato['ini_refri'] = $request->input("ini_refri");
            $dato['fin_refri'] = $request->input("fin_refri");
            $dato['estado_registro'] = 1;
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;
            Turno::create($dato);
        }
    }

    public function Modal_Update_Turno($id_turno)
    {
        $dato['get_id'] = Turno::where('id_turno', $id_turno)
            ->get();
        $dato['list_base'] = Base::get_list_todas_bases_agrupadas();
        return view('rrhh.administracion.colaborador.Turno.modal_editar', $dato);
    }

    public function Update_Turno(Request $request)
    {
        $request->validate([
            'basee' => 'required',
            'entradae' => 'required',
            'salidae' => 'required',
            't_refrigerioe' => 'required',
        ], [
            'basee' => 'Debe seleccionar base',
            'entradae' => 'Debe ingresar entrada',
            'salidae' => 'Debe ingresar salida',
            't_refrigerioe' => 'Debe seleccionar tipo de refrigerio',
        ]);
        $valida = Turno::where('base', $request->basee)
            ->where('entrada', $request->entradae)
            ->where('salida', $request->salidae)
            ->where('t_refrigerio', $request->t_refrigerioe)
            ->where('estado_registro', $request->estado_registroe)
            ->where('estado', 1)
            ->exists();
        if ($valida) {
            echo "error";
        } else {
            $dato['base'] = $request->input("basee");
            $dato['entrada'] = $request->input("entradae");
            $dato['salida'] = $request->input("salidae");
            $dato['t_refrigerio'] = $request->input("t_refrigerioe");
            $dato['ini_refri'] = $request->input("ini_refrie");
            $dato['fin_refri'] = $request->input("fin_refrie");
            $dato['estado_registro'] = $request->estado_registroe;
            if ($dato['estado_registro'] == "") {
                $dato['estado_registro'] = 2;
            }
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Turno::findOrFail($request->input("id_turno"))->update($dato);
        }
    }

    public function Delete_Turno(Request $request)
    {
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Turno::findOrFail($request->input("id_turno"))->update($dato);
    }

    public function Horario(){
        $dato['list_base'] = Base::get_list_base_pendiente();
        return view('rrhh.administracion.colaborador.Horario.index',$dato);
    }

    public function Lista_Horario(Request $request){
        $cod_base = $request->cod_base;
        $dato['list_horario'] = Horario::get_list_horario_modulo($cod_base);
        return view('rrhh.administracion.colaborador.Horario.lista',$dato);
    }

    public function Modal_Horario(){
        $dato['list_base'] = Base::get_list_base_pendiente();
        return view('rrhh.administracion.colaborador.Horario.vista_reg', $dato);
    }

    public function Busca_Turno_XBase(Request $request){
        $cod_base = $request->input("cod_base");
        $list_turno = Turno::get_list_turno_xbase($cod_base);
        $select="<option value='0'>Seleccione</option>";
        foreach($list_turno as $list){
            $select=$select."<option value='".$list['id_turno']."'>".$list['option_select']."</option>";
        }
        echo $select;
    }

    public function Insert_Horario(Request $request){
        $request->validate([
            'cod_base_i' => 'required',
            'nombre_i' => 'required',
        ],[
            'cod_base_i' => 'Debe ingresar entrada',
            'nombre_i' => 'Debe ingresar salida',
        ]);
        $valida = Horario::where('nombre', $request->nombre_i)
                ->where('cod_base', $request->cod_base_i)
                ->where('estado', 1)
                ->exists();
        if ($valida){
            echo "error";
        }else{
            $dato['nombre']= $request->input("nombre_i");
            $dato['cod_base']= $request->input("cod_base_i");
            if($request->input("ch_feriado_i")){
                $dato['feriado'] = 1;
            }else{
                $dato['feriado'] = "";
            }
            $anio=date('Y');
            $query_id = Horario::get();
            $totalRows_t = count($query_id);
            $aniof=substr($anio, 2,2);
            if($totalRows_t<9){
                $codigofinal="H".$aniof."0000".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                    $codigofinal="H".$aniof."000".($totalRows_t+1);
            }
            if($totalRows_t>98 && $totalRows_t<999){
                $codigofinal="H".$aniof."00".($totalRows_t+1);
            }
            if($totalRows_t>998 && $totalRows_t<9999){
                $codigofinal="H".$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>9998){
                $codigofinal="H".$aniof.($totalRows_t+1);
            }
            $dato['cod_horario'] = $codigofinal;
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['user_reg'] = session('usuario')->id_usuario;

            $horario = Horario::create($dato);

            $dato['id_horario'] = $horario->id_horario;

            
            $dato['ch_lunes']= $request->input("ch_dia_laborado_lu_i");
            if($dato['ch_lunes']==1){
                $dato['id_turno'] = $request->input("id_turno_lu_i");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['dia'] = 1;
                $dato['nom_dia'] = "Lunes";
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_lu_i");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_lu_i");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_lu_i");  
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_lu_i");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_lu_i");
                }else{
                    $dato['hora_descanso_e'] = "00:00:00";
                    $dato['hora_descanso_s'] = "00:00:00";
                }
                $dato['estado'] = 1;
                $dato['fec_reg'] = now();
                $dato['fec_act'] = now();
                $dato['user_act'] = session('usuario')->id_usuario;
                $dato['user_reg'] = session('usuario')->id_usuario;
                HorarioDia::create($dato);
            }

            $dato['ch_martes']= $request->input("ch_dia_laborado_ma_i");
            if($dato['ch_martes']==1){
                $dato['id_turno']= $request->input("id_turno_ma_i");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['dia'] = 2;
                $dato['nom_dia'] = "Martes";
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_ma_i");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_ma_i");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_ma_i");  
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_ma_i");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_ma_i");
                }else{
                    $dato['hora_descanso_e'] = "00:00:00";
                    $dato['hora_descanso_s'] = "00:00:00";
                }
                HorarioDia::create($dato);
            }

            $dato['ch_miercoles']= $request->input("ch_dia_laborado_mi_i");
            if($dato['ch_miercoles']==1){
                $dato['id_turno']= $request->input("id_turno_mi_i");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['dia'] = 3;
                $dato['nom_dia'] = "Miércoles";
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_mi_i");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_mi_i");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_mi_i");  
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_mi_i");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_mi_i");
                }else{
                    $dato['hora_descanso_e'] = "00:00:00";
                    $dato['hora_descanso_s'] = "00:00:00";
                }
                HorarioDia::create($dato);
            }

            $dato['ch_jueves']= $request->input("ch_dia_laborado_ju_i");
            if($dato['ch_jueves']==1){
                $dato['id_turno']= $request->input("id_turno_ju_i");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['dia'] = 4;
                $dato['nom_dia'] = "Jueves";
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_ju_i");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_ju_i");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_ju_i");  
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_ju_i");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_ju_i");
                }else{
                    $dato['hora_descanso_e'] = "00:00:00";
                    $dato['hora_descanso_s'] = "00:00:00";
                }
                HorarioDia::create($dato);
            }

            $dato['ch_viernes']= $request->input("ch_dia_laborado_vi_i");
            if($dato['ch_viernes']==1){
                $dato['id_turno']= $request->input("id_turno_vi_i");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['dia'] = 5;
                $dato['nom_dia'] = "Viernes";
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_vi_i");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_vi_i");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_vi_i");  
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_vi_i");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_vi_i");
                }else{
                    $dato['hora_descanso_e'] = "00:00:00";
                    $dato['hora_descanso_s'] = "00:00:00";
                }
                HorarioDia::create($dato);
            }

            $dato['ch_sabado']= $request->input("ch_dia_laborado_sa_i");
            if($dato['ch_sabado']==1){
                $dato['id_turno']= $request->input("id_turno_sa_i");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['dia'] = 6;
                $dato['nom_dia'] = "Sábado";
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_sa_i");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_sa_i");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_sa_i");  
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_sa_i");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_sa_i");
                }else{
                    $dato['hora_descanso_s'] = "00:00:00";
                    $dato['hora_descanso_e'] = "00:00:00";
                }
                HorarioDia::create($dato);
            }

            $dato['ch_domingo']= $request->input("ch_dia_laborado_do_i");
            if($dato['ch_domingo']==1){
                $dato['id_turno']= $request->input("id_turno_do_i");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['dia'] = 7;
                $dato['nom_dia'] = "Domingo";
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_do_i");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_do_i");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_do_i");  
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_do_i");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_do_i");
                }else{
                    $dato['hora_descanso_e'] = "00:00:00";
                    $dato['hora_descanso_s'] = "00:00:00";
                }
                HorarioDia::create($dato);
            }
            
            $data = ToleranciaHorario::consulta_tolerancia_horario_activo();
            if(count($data)>0){
                $minutos = $data[0]['minutos'];
            }else{
                $minutos = 0;
            }
            
            HorarioDia::where('estado', 1)
            ->update([
                'hora_entrada_desde' => DB::raw("DATE_FORMAT(DATE_SUB(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_entrada_hasta' => DB::raw("DATE_FORMAT(DATE_ADD(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_salida_desde' => DB::raw("DATE_FORMAT(DATE_SUB(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_salida_hasta' => DB::raw("DATE_FORMAT(DATE_ADD(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_descanso_e_desde' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_SUB(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'hora_descanso_e_hasta' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_ADD(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'hora_descanso_s_desde' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_SUB(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'hora_descanso_s_hasta' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_ADD(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'fec_act' => now(),
            ]);
        }
    }

    public function Modal_Update_Horario($id_horario){
        $dato['get_id'] = Horario::where('id_horario', $id_horario)
                        ->get();/*
        print_r($dato['get_id']);
        print_r('base', $dato['cod_base']);*/
        $dato['get_detalle'] = HorarioDia::where('id_horario', $id_horario)
                        ->where('estado', 1)
                        ->orderBy('dia', 'ASC')
                        ->get()
                        ->toArray();
        //print_r($dato['get_detalle']);
        $dato['list_base'] = Base::get_list_base_pendiente();
        $dato['list_turno'] = Turno::get_list_turno_xbase($dato['get_id']);
        return view('rrhh.administracion.colaborador.Horario.vista_edit',$dato);
    }

    public function Update_Horario(Request $request){
        $request->validate([
            'cod_base_u' => 'required',
            'nombre_u' => 'required',
        ],[
            'cod_base_u' => 'Debe ingresar entrada',
            'nombre_u' => 'Debe ingresar salida',
        ]);
        $valida = Horario::where('nombre', $request->nombre_u)
                ->where('cod_base', $request->cod_base_u)
                ->where('id_horario', '!=', $request->id_horario)
                ->where('estado', 1)
                ->exists();
        if ($valida){
            echo "error";
        }else{
            $dato['nombre']= $request->input("nombre_u");
            $dato['cod_base']= $request->input("cod_base_u");
            if($request->input("ch_feriado_u")){
                $dato['feriado'] = 1;
            }else{
                $dato['feriado'] = "";
            }
            Horario::findOrFail($request->id_horario)->update($dato);

            $dato['ch_lunes']= $request->input("ch_dia_laborado_lu_u");
            $dato['dia'] = 1;
            if($dato['ch_lunes']==1){
                $dato['id_lunes']= $request->input("id_lunes");
                $dato['id_turno']= $request->input("id_turno_lu_u");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_lu_u");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_lu_u");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_lu_u");  
                $dato['hora_descanso_e'] = "";
                $dato['hora_descanso_s'] = "";
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_lu_u");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_lu_u");
                }

                if($dato['id_lunes']!=""){
                    HorarioDia::findOrFail($request->id_lunes)->update([
                        'id_turno' => $request->id_turno_lu_u,
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    HorarioDia::create([
                        'id_horario' => $request->id_horario,
                        'id_turno' => $dato['id_turno'],
                        'dia' => 1,
                        'nom_dia' => "Lunes",
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                HorarioDia::where('id_horario', $request->id_horario)
                        ->where('dia', 1)
                        ->update([
                            'estado' => 2,
                            'fec_eli' => now(),
                            'user_eli' => session('usuario')->id_usuario,
                        ]);
            }

            $dato['ch_martes']= $request->input("ch_dia_laborado_ma_u");
            $dato['dia'] = 2;
            if($dato['ch_martes']==1){
                $dato['id_martes']= $request->input("id_martes");
                $dato['id_turno']= $request->input("id_turno_ma_u");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_ma_u");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_ma_u");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_ma_u");  
                $dato['hora_descanso_e'] = "";
                $dato['hora_descanso_s'] = "";
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_ma_u");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_ma_u");
                }
                if($dato['id_martes']!=""){
                    HorarioDia::findOrFail($request->id_martes)->update([
                        'id_turno' => $request->id_turno_ma_u,
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    HorarioDia::create([
                        'id_horario' => $request->id_horario,
                        'id_turno' => $dato['id_turno'],
                        'dia' => 2,
                        'nom_dia' => "Martes",
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                HorarioDia::where('id_horario', $request->id_horario)
                        ->where('dia', 2)
                        ->update([
                            'estado' => 2,
                            'fec_eli' => now(),
                            'user_eli' => session('usuario')->id_usuario,
                        ]);
            }
            

            $dato['ch_miercoles']= $request->input("ch_dia_laborado_mi_u");
            $dato['dia'] = 3;

            if($dato['ch_miercoles']==1){
                $dato['id_miercoles']= $request->input("id_miercoles");
                $dato['id_turno']= $request->input("id_turno_mi_u");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_mi_u");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_mi_u");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_mi_u");  
                $dato['hora_descanso_e'] = "";
                $dato['hora_descanso_s'] = "";
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_mi_u");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_mi_u");
                }
                if($dato['id_miercoles']!=""){
                    HorarioDia::findOrFail($request->id_miercoles)->update([
                        'id_turno' => $request->id_turno_mi_u,
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    HorarioDia::create([
                        'id_horario' => $request->id_horario,
                        'id_turno' => $dato['id_turno'],
                        'dia' => 3,
                        'nom_dia' => "Miércoles",
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:0000:00:00",
                        'hora_descanso_s' => "00:00:0000:00:00",
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                HorarioDia::where('id_horario', $request->id_horario)
                        ->where('dia', 3)
                        ->update([
                            'estado' => 2,
                            'fec_eli' => now(),
                            'user_eli' => session('usuario')->id_usuario,
                        ]);
            }

            $dato['ch_jueves']= $request->input("ch_dia_laborado_ju_u");
            $dato['dia'] = 4;
            if($dato['ch_jueves']==1){
                $dato['id_turno']= $request->input("id_turno_ju_u");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['id_jueves']= $request->input("id_jueves");
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_ju_u");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_ju_u");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_ju_u");  
                $dato['hora_descanso_e'] = "";
                $dato['hora_descanso_s'] = "";
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_ju_u");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_ju_u");
                }
                if($dato['id_jueves']!=""){
                    HorarioDia::findOrFail($request->id_jueves)->update([
                        'id_turno' => $request->id_turno_ju_u,
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    HorarioDia::create([
                        'id_horario' => $request->id_horario,
                        'id_turno' => $dato['id_turno'],
                        'dia' => 4,
                        'nom_dia' => "Jueves",
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                HorarioDia::where('id_horario', $request->id_horario)
                        ->where('dia', 4)
                        ->update([
                            'estado' => 2,
                            'fec_eli' => now(),
                            'user_eli' => session('usuario')->id_usuario,
                        ]);
            }
            
            $dato['ch_viernes']= $request->input("ch_dia_laborado_vi_u");
            $dato['dia'] = 5;
            if($dato['ch_viernes']==1){
                $dato['id_viernes']= $request->input("id_viernes");
                $dato['id_turno']= $request->input("id_turno_vi_u");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_vi_u");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_vi_u");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_vi_u");  
                $dato['hora_descanso_e'] = "";
                $dato['hora_descanso_s'] = "";
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_vi_u");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_vi_u");
                }
                if($dato['id_viernes']!=""){
                    HorarioDia::findOrFail($request->id_viernes)->update([
                        'id_turno' => $request->id_turno_vi_u,
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    HorarioDia::create([
                        'id_horario' => $request->id_horario,
                        'id_turno' => $dato['id_turno'],
                        'dia' => 5,
                        'nom_dia' => "Viernes",
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                HorarioDia::where('id_horario', $request->id_horario)
                        ->where('dia', 5)
                        ->update([
                            'estado' => 2,
                            'fec_eli' => now(),
                            'user_eli' => session('usuario')->id_usuario,
                        ]);
            }

            $dato['ch_sabado']= $request->input("ch_dia_laborado_sa_u");
            $dato['dia'] = 6;
            if($dato['ch_sabado']==1){
                $dato['id_sabado']= $request->input("id_sabado");
                $dato['id_turno']= $request->input("id_turno_sa_u");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_sa_u");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_sa_u");
                $dato['con_descanso'] = $data[0]['t_refrigerio'];//$this->input->post("con_descanso_sa_u");  
                $dato['hora_descanso_e'] = "";
                $dato['hora_descanso_s'] = "";
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_sa_u");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_sa_u");
                }
                if($dato['id_sabado']!=""){
                    HorarioDia::findOrFail($request->id_sabado)->update([
                        'id_turno' => $request->id_turno_sa_u,
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    HorarioDia::create([
                        'id_horario' => $request->id_horario,
                        'id_turno' => $dato['id_turno'],
                        'dia' => 6,
                        'nom_dia' => "Sábado",
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                HorarioDia::where('id_horario', $request->id_horario)
                        ->where('dia', 6)
                        ->update([
                            'estado' => 2,
                            'fec_eli' => now(),
                            'user_eli' => session('usuario')->id_usuario,
                        ]);
            }
            
            $dato['ch_domingo']= $request->input("ch_dia_laborado_do_u");
            $dato['dia'] = 7;
            if($dato['ch_domingo']==1){
                $dato['id_domingo']= $request->input("id_domingo");
                $dato['id_turno']= $request->input("id_turno_do_u");
                $data = Turno::get_turno_para_horario($dato['id_turno']);
                $dato['hora_entrada'] = $data[0]['entrada'];//$this->input->post("hora_entrada_do_u");
                $dato['hora_salida'] = $data[0]['salida'];//$this->input->post("hora_salida_do_u");
                $dato['con_descanso'] = $request->input("con_descanso_do_u");  
                $dato['hora_descanso_e'] = "";
                $dato['hora_descanso_s'] = "";
                if($dato['con_descanso']==1){
                    $dato['hora_descanso_e'] = $data[0]['ini_refri'];//$this->input->post("hora_edescanso_do_u");
                    $dato['hora_descanso_s'] = $data[0]['fin_refri'];//$this->input->post("hora_sdescanso_do_u");
                }
                if($dato['id_domingo']!=""){
                    HorarioDia::findOrFail($request->id_domingo)->update([
                        'id_turno' => $request->id_turno_do_u,
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    HorarioDia::create([
                        'id_horario' => $request->id_horario,
                        'id_turno' => $dato['id_turno'],
                        'dia' => 7,
                        'nom_dia' => "Domingo",
                        'hora_entrada' => $data[0]['entrada'],
                        'hora_salida' => $data[0]['salida'],
                        'con_descanso' => $data[0]['t_refrigerio'],  
                        'hora_descanso_e' => "00:00:00",
                        'hora_descanso_s' => "00:00:00",
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                HorarioDia::where('id_horario', $request->id_horario)
                        ->where('dia', 7)
                        ->update([
                            'estado' => 2,
                            'fec_eli' => now(),
                            'user_eli' => session('usuario')->id_usuario,
                        ]);
            }
            $data = ToleranciaHorario::consulta_tolerancia_horario_activo();
            if(count($data)>0){
                $minutos = $data[0]['minutos'];
            }else{
                $minutos = 0;
            }
            
            HorarioDia::where('estado', 1)
            ->update([
                'hora_entrada_desde' => DB::raw("DATE_FORMAT(DATE_SUB(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_entrada_hasta' => DB::raw("DATE_FORMAT(DATE_ADD(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_salida_desde' => DB::raw("DATE_FORMAT(DATE_SUB(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_salida_hasta' => DB::raw("DATE_FORMAT(DATE_ADD(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                'hora_descanso_e_desde' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_SUB(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'hora_descanso_e_hasta' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_ADD(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'hora_descanso_s_desde' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_SUB(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'hora_descanso_s_hasta' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_ADD(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                'fec_act' => now(),
            ]);
        }
    }

    public function Delete_Horario(Request $request){
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Horario::findOrFail($request->input("id_horario"))->update($dato);
        HorarioDia::where('id_horario',$request->input("id_horario"))
                ->where('estado', 1)
                ->update($dato);
    }
    /*---------------------------------------------------------Paolo*/


    // -------------------------------BRYAN------------------------------------
    public function index_ubi()
    {
        return view('rrhh.administracion.colaborador.ubicacion.index');
    }
    public function list_ubi()
    {
        $list_ubicacion = Ubicacion::with('sede')
            ->select('id_ubicacion', 'cod_ubi', 'id_sede')
            ->where('estado', 1)
            ->get();

        return view('rrhh.administracion.colaborador.ubicacion.lista', compact('list_ubicacion'));
    }


    public function create_ubi()
    {
        $list_sede = SedeLaboral::select('id', 'descripcion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.ubicacion.modal_registrar', compact('list_sede'));
    }

    public function store_ubi(Request $request)
    {
        $request->validate([
            'codigoe' => 'required',
            'sedee' => 'required',
        ], [
            'codigoe.required' => 'Debe ingresar código.',
        ]);

        $valida = Ubicacion::where('cod_ubi', $request->codigoe)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            Ubicacion::create([
                'cod_ubi' => $request->codigoe,
                'id_sede' => $request->sedee ?? 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ubi($id)
    {
        $list_sede = SedeLaboral::select('id', 'descripcion')->where('estado', 1)->get();
        $get_id = Ubicacion::findOrFail($id);
        return view('rrhh.administracion.colaborador.ubicacion.modal_editar', compact('get_id', 'list_sede'));
    }

    public function update_ubi(Request $request, $id)
    {
        $request->validate([
            'codigoe' => 'required',
            'id_sede' => 'required|not_in:0',
        ], [
            'codigoe.required' => 'Debe ingresar el código.',
            'id_sede.required' => 'Debe seleccionar una sede.',
            'id_sede.not_in' => 'Debe seleccionar una sede válida.',
        ]);
        // Verificación de existencia de un registro con el mismo código pero diferente ID
        $valida = Ubicacion::where('cod_ubi', $request->codigoe)
            ->where('estado', 1)
            ->where('id_ubicacion', '!=', $id)
            ->exists();

        if ($valida) {
            // Redirigir con error si el código ya está en uso
            return back()->withErrors(['codigoe' => 'El código ya está en uso por otro registro.']);
        } else {
            // Actualización del registro
            $ubicacion = Ubicacion::findOrFail($id);
            $ubicacion->update([
                'id_sede' => $request->id_sede,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            // Redirigir con éxito
            return back()->with('success', 'Registro actualizado correctamente.');
        }
    }



    public function destroy_ubi($id)
    {
        Ubicacion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
    // AGREGANDO ALGO
}

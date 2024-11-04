<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AsuntoSoporte;
use App\Models\Base;
use App\Models\BiReporte;
use App\Models\Capacitacion;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\ElementoSoporte;
use App\Models\Especialidad;
use App\Models\Gerencia;
use App\Models\Mes;
use App\Models\NivelJerarquico;
use App\Models\Procesos;
use App\Models\ProcesosHistorial;
use App\Models\Puesto;
use App\Models\SeguimientoCoordinador;
use App\Models\SupervisionTienda;
use App\Models\TipoPortal;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Notificacion;
use App\Models\SedeLaboral;
use App\Models\Soporte;
use App\Models\SoporteAreaEspecifica;
use App\Models\SoporteNivel;
use App\Models\SoporteTipo;
use App\Models\SubGerencia;
use App\Models\Ubicacion;

use App\Models\User;

class SoporteConfController extends Controller
{

    public function indexsopasunto_conf()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.administracion.asunto_soporte.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function indexubicaciones_conf()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.administracion.ubicacion.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_asu_conf()
    {
        return view('soporte.administracion.asunto_soporte.asunto.index');
    }

    public function index_ele_conf()
    {
        return view('soporte.administracion.asunto_soporte.elemento.index');
    }

    public function index_esp_conf()
    {
        return view('soporte.administracion.asunto_soporte.especialidad.index');
    }

    public function index_area_esp_conf()
    {
        return view('soporte.administracion.ubicacion.area_especifica.index');
    }

    public function list_asunto_conf()
    {
        $list_asunto = AsuntoSoporte::select(
            'soporte_asunto.idsoporte_asunto',
            'soporte_asunto.nombre AS asunto_nombre',
            'soporte_asunto.descripcion',
            'soporte_asunto.fec_reg',
            'soporte_tipo.nombre AS nom_tiposoporte',
            'soporte_elemento.nombre AS nom_elemento',
            DB::raw("GROUP_CONCAT(DISTINCT area.nom_area SEPARATOR ', ') AS nom_areas") // Concatenar nombres de áreas
        )
            ->leftJoin('soporte_tipo', 'soporte_asunto.idsoporte_tipo', '=', 'soporte_tipo.idsoporte_tipo')
            ->leftJoin('soporte_elemento', 'soporte_asunto.idsoporte_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftJoin('area', function ($join) {
                $join->on(DB::raw("FIND_IN_SET(area.id_area, soporte_asunto.id_area)"), '>', DB::raw('0'));
            })
            ->where('soporte_asunto.estado', 1)
            ->groupBy(
                'soporte_asunto.idsoporte_asunto',
                'soporte_asunto.nombre',
                'soporte_asunto.descripcion',
                'soporte_asunto.fec_reg',
                'soporte_tipo.nombre',
                'soporte_elemento.nombre'
            ) // Agrupamos todas las columnas seleccionadas que no son agregadas
            ->orderBy('soporte_asunto.fec_reg', 'DESC')
            ->get();

        return view('soporte.administracion.asunto_soporte.asunto.lista', compact('list_asunto'));
    }



    public function create_asunto_conf()
    {
        $list_elementos = ElementoSoporte::select('soporte_elemento.idsoporte_elemento', 'soporte_elemento.nombre', 'soporte_elemento.descripcion')
            ->where('soporte_elemento.estado', 1)
            ->get();
        $list_tipo = SoporteTipo::select('soporte_tipo.idsoporte_tipo', 'soporte_tipo.nombre')
            ->get();
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->whereIn('id_area', [41, 25])
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();
        return view('soporte.administracion.asunto_soporte.asunto.modal_registrar', compact('list_elementos', 'list_tipo', 'list_area'));
    }


    public function store_asunto_conf(Request $request)
    {
        $request->validate([
            'id_elemento' => 'gt:0',
            'tipo_soporte' => 'gt:0',
            'nom_asunt' => 'required|max:95',
            'id_areae' => 'required|array|min:1',
        ], [
            'id_elemento.gt' => 'Debe seleccionar Elemento.',
            'tipo_soporte.gt' => 'Debe seleccionar Tipo de Soporte.',
            'nom_asunt.max' => 'Nombre debe tener como máximo 95 caracteres.',
            'id_areae.required' => 'Debe seleccionar al menos una área.',
        ]);

        $id_area_string = implode(',', $request->id_areae);
        // Determinar si el id_area_string tiene una coma
        $responsable_multiple = (strpos($id_area_string, ',') !== false) ? 1 : 0;
        // Crear el nuevo registro
        AsuntoSoporte::create([
            'id_area' => $id_area_string,
            'idsoporte_elemento' => $request->id_elemento,
            'idsoporte_tipo' => $request->tipo_soporte,
            'nombre' => $request->nom_asunt,
            'descripcion' => $request->descripciona ?? '',
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'responsable_multiple' => $responsable_multiple,
            'evidencia_adicional' =>  $request->requires_evidencer

        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }


    public function edit_asunto_conf($id)
    {
        $list_elementos = ElementoSoporte::select('soporte_elemento.idsoporte_elemento', 'soporte_elemento.nombre', 'soporte_elemento.descripcion')
            ->where('soporte_elemento.estado', 1)
            ->get();
        $list_tipo = SoporteTipo::select('soporte_tipo.idsoporte_tipo', 'soporte_tipo.nombre')
            ->get();
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->whereIn('id_area', [41, 25])
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();
        $get_id = AsuntoSoporte::findOrFail($id);
        // dd($get_id);
        return view('soporte.administracion.asunto_soporte.asunto.modal_editar', compact('get_id', 'list_elementos', 'list_tipo', 'list_area'));
    }


    public function update_asunto_conf(Request $request, $id)
    {
        $request->validate([
            'nom_asunte' => 'required|max:95',
            'id_areaee' => 'required|array|min:1',
        ], [
            'id_areaee.required' => 'Debe seleccionar al menos una área.',
            'nom_asunte.max' => 'Nombre debe tener como máximo 95 caracteres.',
        ]);

        $id_area_string = implode(',', $request->id_areaee);
        // Determinar si el id_area_string tiene una coma
        $responsable_multiple = (strpos($id_area_string, ',') !== false) ? 1 : 0;

        AsuntoSoporte::findOrFail($id)->update([
            'id_area' => $id_area_string,
            'idsoporte_elemento' => $request->id_elementoe,
            'idsoporte_tipo' => $request->tipo_soportee,
            'nombre' => $request->nom_asunte,
            'descripcion' => $request->descripcione ?? '',
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'responsable_multiple' => $responsable_multiple,
            'evidencia_adicional' =>  $request->requires_evidence
        ]);

        return redirect()->back()->with('success', 'Reporte actualizado con éxito.'); // Asegúrate de redirigir después de la actualización
    }


    public function destroy_asunto_conf($id)
    {
        AsuntoSoporte::where('idsoporte_asunto', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }









    public function list_elemento_conf()
    {
        $list_elementos = ElementoSoporte::select('soporte_elemento.idsoporte_elemento', 'soporte_elemento.fec_reg', 'soporte_elemento.nombre', 'soporte_elemento.descripcion')
            ->where('soporte_elemento.estado', 1)
            ->orderBy('fec_reg', 'DESC')
            ->get();

        return view('soporte.administracion.asunto_soporte.elemento.lista', compact('list_elementos'));
    }

    public function create_elemento_conf()
    {
        $list_especialidad = Especialidad::select('especialidad.id', 'especialidad.nombre')
            ->where('especialidad.estado', 1)
            ->get();

        return view('soporte.administracion.asunto_soporte.elemento.modal_registrar', compact('list_especialidad'));
    }

    public function store_elemento_conf(Request $request)
    {
        $request->validate([
            'id_espe' => 'gt:0',
            'nom_ele' => 'required',

        ], [
            'id_espe.gt' => 'Debe seleccionar especialidad.',
            'nom_ele.required' => 'Debe ingresar nombre de elemento.',

        ]);
        // dd($request->all());
        ElementoSoporte::create([
            'id_especialidad' => $request->id_espe,
            'nombre' => $request->nom_ele,
            'descripcion' => $request->descripcione ?? '',
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }

    public function edit_elemento_conf($id)
    {
        $list_especialidad = Especialidad::select('especialidad.id', 'especialidad.nombre')
            ->where('especialidad.estado', 1)
            ->get();
        $get_id = ElementoSoporte::findOrFail($id);
        // dd($list_especialidad);
        return view('soporte.administracion.asunto_soporte.elemento.modal_editar', compact('get_id', 'list_especialidad'));
    }


    public function update_elemento_conf(Request $request, $id)
    {
        $request->validate([
            'nom_elee' => 'required|max:60',

        ], [
            'nom_elee.max' => 'Nombre debe tener como máximo 60 caracteres.',
        ]);

        ElementoSoporte::findOrFail($id)->update([
            'id_especialidad' => $request->id_espee,
            'nombre' => $request->nom_elee,
            'descripcion' => $request->descripcione ?? '',
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }


    public function destroy_elemento_conf($id)
    {
        // Actualizar el estado de 'soporte_elemento'
        $elemento = ElementoSoporte::where('idsoporte_elemento', $id)->firstOrFail();
        $elemento->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
        // Ahora actualizar los registros en la tabla 'especialidad' relacionados con 'id_especialidad'
        AsuntoSoporte::where('idsoporte_elemento', $id)
            ->update([
                'estado' => 2
            ]);
    }









    public function list_especialidad_conf()
    {
        $list_especialidad = Especialidad::select(
            'especialidad.id',
            'especialidad.nombre',
            'especialidad.fec_reg',
        )
            ->where('especialidad.estado', 1)
            ->groupBy('especialidad.id', 'especialidad.nombre', 'especialidad.fec_reg') // Agrupar por los campos de especialidad
            ->orderBy('fec_reg', 'DESC')
            ->get();

        return view('soporte.administracion.asunto_soporte.especialidad.lista', compact('list_especialidad'));
    }


    public function create_especialidad_conf()
    {
        return view('soporte.administracion.asunto_soporte.especialidad.modal_registrar');
    }

    public function store_especialidad_conf(Request $request)
    {
        $request->validate([
            'nom_esp' => 'required',

        ], [
            'nom_esp.required' => 'Debe ingresar nombre de especialidad.',

        ]);

        // dd($request->all());
        Especialidad::create([
            'nombre' => $request->nom_esp,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }


    public function edit_especialidad_conf($id)
    {
        $get_id = Especialidad::findOrFail($id);
        return view('soporte.administracion.asunto_soporte.especialidad.modal_editar', compact('get_id'));
    }


    public function update_especialidad_conf(Request $request, $id)
    {
        $request->validate([
            'nom_espe' => 'required',
        ], [
            'nom_espe.required' => 'Debe seleccionar nombre.',
        ]);

        Especialidad::findOrFail($id)->update([
            'nombre' => $request->nom_espe,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_especialidad_conf($id)
    {
        // Actualizar el estado de 'Especialidad'
        Especialidad::where('id', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);

        // Obtener los registros de 'ElementoSoporte' relacionados con la especialidad
        $elementos = ElementoSoporte::where('id_especialidad', $id)->get();

        // Actualizar el estado de 'ElementoSoporte'
        foreach ($elementos as $elemento) {
            $elemento->update([
                'estado' => 2
            ]);

            // Actualizar el estado de 'AsuntoSoporte' relacionado con el 'ElementoSoporte'
            AsuntoSoporte::where('idsoporte_elemento', $elemento->idsoporte_elemento)
                ->update([
                    'estado' => 2
                ]);
        }
    }









    //  ÁREA ESPECÍFICA
    public function list_area_esp_conf()
    {
        $list_area_especificas = SoporteAreaEspecifica::select(
            'soporte_area_especifica.idsoporte_area_especifica',
            'soporte_area_especifica.nombre',
            'soporte_area_especifica.fec_reg',
        )
            ->where('soporte_area_especifica.estado', 1)
            ->orderBy('fec_reg', 'DESC')
            ->get();

        return view('soporte.administracion.ubicacion.area_especifica.lista', compact('list_area_especificas'));
    }


    public function create_area_esp_conf()
    {
        $list_nivel = SoporteNivel::select('idsoporte_nivel', 'nombre')
            ->where('estado', 1)
            ->distinct('nombre')
            ->get();

        $list_sede = SedeLaboral::select('id', 'descripcion')
            ->where('estado', 1)
            ->whereNotIn('id', [3, 5]) // Excluir los id EXT y REMOTO
            ->get();

        return view('soporte.administracion.ubicacion.area_especifica.modal_registrar', compact('list_nivel', 'list_sede'));
    }

    public function store_area_esp_conf(Request $request)
    {
        $request->validate([
            'sede_laboral' => 'gt:0',
            'soporte_nivel' =>  'gt:0',

        ], [
            'sede_laboral.gt' => 'Debe seleccionar al menos una sede.',
            'soporte_nivel.gt' => 'Debe seleccionar al menos un nivel.',

        ]);

        // dd($request->all());
        SoporteAreaEspecifica::create([
            'id_soporte_nivel' => $request->soporte_nivel,
            'nombre' => $request->nom_area_esp,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }


    public function edit_area_esp_conf($id)
    {
        $list_nivel = SoporteNivel::select('idsoporte_nivel', 'nombre')
            ->where('estado', 1)
            ->distinct('nombre')
            ->get();

        $list_sede = SedeLaboral::select('id', 'descripcion')
            ->where('estado', 1)
            ->whereNotIn('id', [3, 5])
            ->get();

        $get_id = SoporteAreaEspecifica::listAreaEspecifica($id);
        // dd($get_id);
        return view('soporte.administracion.ubicacion.area_especifica.modal_editar', compact('get_id', 'list_nivel', 'list_sede'));
    }


    public function update_area_esp_conf(Request $request, $id)
    {
        $request->validate([
            'sede_laborale' => 'gt:0',
            'soporte_nivele' =>  'gt:0',

        ], [
            'sede_laboral.gt' => 'Debe seleccionar al menos una sede.',
            'soporte_nivel.gt' => 'Debe seleccionar al menos un nivel.',

        ]);

        SoporteAreaEspecifica::findOrFail($id)->update([
            'id_soporte_nivel' => $request->soporte_nivele,
            'nombre' => $request->nom_area_espe,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_area_esp_conf($id)
    {
        SoporteAreaEspecifica::where('idsoporte_area_especifica', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }


    public function getAreaEspecificaPorSede(Request $request)
    {
        $sedeId = $request->input('sede');
        // Obtiene toda la lista de soporte_nivel que coincida con id_sede_laboral
        $niveles = SoporteNivel::where('id_sede_laboral', $sedeId)
            ->where('estado', 1)
            ->get();
        return response()->json($niveles);
    }
}

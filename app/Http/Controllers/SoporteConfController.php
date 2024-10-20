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
use App\Models\SoporteTipo;
use App\Models\SubGerencia;
use App\Models\Ubicacion;

use App\Models\User;

class SoporteConfController extends Controller
{

    public function indexsop_conf()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.administracion.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_asu_conf()
    {
        return view('soporte.administracion.asunto.asunto.index');
    }

    public function index_ele_conf()
    {
        return view('soporte.administracion.asunto.elemento.index');
    }

    public function index_esp_conf()
    {
        return view('soporte.administracion.asunto.especialidad.index');
    }

    public function list_asunto_conf()
    {
        $list_asunto = AsuntoSoporte::select(
            'soporte_asunto.idsoporte_asunto',
            'soporte_asunto.nombre AS asunto_nombre',
            'soporte_asunto.descripcion',
            'soporte_asunto.fec_reg',
            'soporte_tipo.nombre AS nom_tiposoporte',
            'soporte_elemento.nombre AS nom_elemento'

        )
            ->leftJoin('soporte_tipo', 'soporte_asunto.idsoporte_tipo', '=', 'soporte_tipo.idsoporte_tipo')
            ->leftJoin('soporte_elemento', 'soporte_asunto.idsoporte_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->where('soporte_asunto.estado', 1)
            ->orderBy('fec_reg', 'DESC')
            ->get();

        return view('soporte.administracion.asunto.asunto.lista', compact('list_asunto'));
    }

    public function create_asunto_conf()
    {
        $list_elementos = ElementoSoporte::select('soporte_elemento.idsoporte_elemento', 'soporte_elemento.nombre', 'soporte_elemento.descripcion')
            ->where('soporte_elemento.estado', 1)
            ->get();
        $list_tipo = SoporteTipo::select('soporte_tipo.idsoporte_tipo', 'soporte_tipo.nombre')
            ->get();
        return view('soporte.administracion.asunto.asunto.modal_registrar', compact('list_elementos', 'list_tipo'));
    }


    public function store_asunto_conf(Request $request)
    {
        $request->validate([
            'id_elemento' => 'gt:0',
            'tipo_soporte' => 'gt:0',
            'nom_asunt' => 'required',

        ], [
            'id_elemento.gt' => 'Debe seleccionar Elemento.',
            'tipo_soporte.gt' => 'Debe seleccionar Tipo de Soporte.',
            'nom_asunt.required' => 'Debe ingresar nombre de especialidad.',

        ]);
        // dd($request->all());
        AsuntoSoporte::create([
            'idsoporte_elemento' => $request->id_elemento,
            'idsoporte_tipo' => $request->tipo_soporte,
            'nombre' => $request->nom_asunt,
            'descripcion' => $request->descripciona ?? '',
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
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
        $get_id = AsuntoSoporte::findOrFail($id);
        // dd($get_id);
        return view('soporte.administracion.asunto.asunto.modal_editar', compact('get_id', 'list_elementos', 'list_tipo'));
    }


    public function update_asunto_conf(Request $request, $id)
    {
        $request->validate([
            'nom_asunte' => 'required',
            'descripcione' => 'required',
        ], [
            'nom_asunte.required' => 'Debe seleccionar nombre.',
            'descripcione.required' => 'Debe seleccionar descripción.',
        ]);

        AsuntoSoporte::findOrFail($id)->update([
            'idsoporte_elemento' => $request->id_elementoe,
            'idsoporte_tipo' => $request->tipo_soportee,
            'nombre' => $request->nom_asunte,
            'descripcion' => $request->descripcione ?? '',
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
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

        return view('soporte.administracion.asunto.elemento.lista', compact('list_elementos'));
    }

    public function create_elemento_conf()
    {
        $list_especialidad = Especialidad::select('especialidad.id', 'especialidad.nombre')
            ->where('especialidad.estado', 1)
            ->get();

        return view('soporte.administracion.asunto.elemento.modal_registrar', compact('list_especialidad'));
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
        return view('soporte.administracion.asunto.elemento.modal_editar', compact('get_id', 'list_especialidad'));
    }


    public function update_elemento_conf(Request $request, $id)
    {
        $request->validate([
            'nom_elee' => 'required',
            'descripcione' => 'required',
        ], [
            'nom_elee.required' => 'Debe seleccionar nombre.',
            'descripcione.required' => 'Debe seleccionar descripción.',
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
            DB::raw("GROUP_CONCAT(area.nom_area SEPARATOR ', ') as nom_areas")
        )
            ->leftJoin('area', DB::raw("FIND_IN_SET(area.id_area, especialidad.id_area)"), '>', DB::raw("'0'"))
            ->where('especialidad.estado', 1)
            ->groupBy('especialidad.id', 'especialidad.nombre', 'especialidad.fec_reg') // Agrupar por los campos de especialidad
            ->orderBy('fec_reg', 'DESC')
            ->get();

        return view('soporte.administracion.asunto.especialidad.lista', compact('list_especialidad'));
    }


    public function create_especialidad_conf()
    {
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->whereIn('id_area', [41, 25])
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();

        return view('soporte.administracion.asunto.especialidad.modal_registrar', compact('list_area'));
    }

    public function store_especialidad_conf(Request $request)
    {
        $request->validate([
            'id_areae' => 'required|array|min:1', // Verifica que sea un array y que tenga al menos 1 elemento
            'nom_esp' => 'required',

        ], [
            'id_areae.required' => 'Debe seleccionar al menos una área.',
            'nom_esp.required' => 'Debe ingresar nombre de especialidad.',

        ]);
        $id_area_string = implode(',', $request->id_areae);

        // dd($request->all());
        Especialidad::create([
            'id_area' => $id_area_string,
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
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->whereIn('id_area', [41, 25])
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();

        $get_id = Especialidad::findOrFail($id);
        return view('soporte.administracion.asunto.especialidad.modal_editar', compact('get_id', 'list_area'));
    }


    public function update_especialidad_conf(Request $request, $id)
    {
        $request->validate([
            'id_areaee' => 'required|array|min:1',
            'nom_espe' => 'required',
        ], [
            'id_areaee.required' => 'Debe seleccionar al menos una área.',
            'nom_espe.required' => 'Debe seleccionar nombre.',
        ]);
        $id_area_string = implode(',', $request->id_areaee);

        Especialidad::findOrFail($id)->update([
            'id_area' => $id_area_string,
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
}

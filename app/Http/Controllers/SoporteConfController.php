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
use App\Models\SoporteUbicacion1;
use App\Models\SoporteUbicacion2;
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
        $list_asunto = AsuntoSoporte::select('soporte_asunto.idsoporte_asunto', 'soporte_asunto.nombre', 'soporte_asunto.descripcion')
            ->where('soporte_asunto.estado', 1)
            ->get();
        return view('soporte.administracion.asunto.asunto.lista', compact('list_asunto'));
    }

    public function create_asunto_conf()
    {
        $list_elementos = ElementoSoporte::select('soporte_elemento.idsoporte_elemento', 'soporte_elemento.nombre', 'soporte_elemento.descripcion')
            ->where('soporte_elemento.estado', 1)
            ->get();
        return view('soporte.administracion.asunto.asunto.modal_registrar', compact('list_elementos'));
    }


    public function store_asunto_conf(Request $request)
    {
        $request->validate([
            'id_elemento' => 'gt:0',
            'nom_asunt' => 'required',

        ], [
            'id_elemento.gt' => 'Debe seleccionar area.',
            'nom_asunt.required' => 'Debe ingresar nombre de especialidad.',

        ]);
        // dd($request->all());
        AsuntoSoporte::create([
            'idsoporte_elemento' => $request->id_elemento,
            'nombre' => $request->nom_asunt,
            'descripcion' => $request->descripciona ?? '',
            'estado' => 1,
            'estado_registro' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
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
        $list_elementos = ElementoSoporte::select('soporte_elemento.idsoporte_elemento', 'soporte_elemento.nombre', 'soporte_elemento.descripcion')
            ->where('soporte_elemento.estado', 1)
            ->get();
        return view('soporte.administracion.asunto.elemento.lista', compact('list_elementos'));
    }

    public function create_elemento_conf()
    {
        $list_especialidad = Especialidad::select('especialidad.id', 'especialidad.nombre')
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

    public function destroy_elemento_conf($id)
    {
        ElementoSoporte::where('idsoporte_elemento', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }







    public function list_especialidad_conf()
    {
        $list_especialidad = Especialidad::select('especialidad.id', 'especialidad.nombre')
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
            'id_areae' => 'gt:0',
            'nom_esp' => 'required',

        ], [
            'id_areae.gt' => 'Debe seleccionar area.',
            'nom_esp.required' => 'Debe ingresar nombre de especialidad.',

        ]);
        // dd($request->all());
        Especialidad::create([
            'id_area' => $request->id_areae,
            'nombre' => $request->nom_esp,
            // 'estado' => 1,
            // 'estado_registro' => 1,
            // 'fec_reg' => now(),
            // 'user_reg' => session('usuario')->id_usuario,
            // 'fec_act' => now(),
            // 'user_act' => session('usuario')->id_usuario
        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }

    public function destroy_especialidad_conf($id)
    {

        Especialidad::where('especialidad', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

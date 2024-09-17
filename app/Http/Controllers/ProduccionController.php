<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AsignacionVisita;
use App\Models\FichaTecnicaProduccion;
use App\Models\Gerencia;
use App\Models\Notificacion;
use App\Models\ProcesosHistorial;
use App\Models\ProcesoVisita;
use App\Models\ProveedorGeneral;
use App\Models\Puesto;
use App\Models\TipoPortal;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduccionController extends Controller
{
    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_gerencia = Gerencia::where('estado', 1)->orderBy('nom_gerencia', 'ASC')->get();

        return view('manufactura.produccion.asignacion_visitas.index', compact('list_notificacion', 'list_gerencia'));
    }

    public function index_av()
    {
        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.index');
    }


    public function list_av(Request $request)
    {
        // Obtener las fechas del request, con valores predeterminados si no se proporcionan
        $fini = $request->input('fini', date('Y-m-01')); // Primer día del mes actual
        $ffin = $request->input('ffin', date('Y-m-t')); // Último día del mes actual

        // Obtener la lista de asignaciones filtrada por fecha
        $list_asignacion = AsignacionVisita::getListAsignacion($fini, $ffin);

        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.lista', compact('list_asignacion'));
    }


    public function create_av()
    {
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        $list_inspector = User::select(
            'id_usuario',
            DB::raw("CONCAT(usuario_apater, ' ', usuario_amater, ' ', usuario_nombres) AS nombre_completo")
        )
            ->where('estado', 1)
            ->where('id_area', 2)
            ->orderBy('usuario_nombres', 'ASC')
            ->distinct('usuario_nombres')
            ->get();

        $list_proveedor = ProveedorGeneral::select(
            'id_proveedor',
            DB::raw("CONCAT(nombre_proveedor, ' - ', ruc_proveedor, ' - ', responsable) AS nombre_proveedor_completo")
        )
            ->where('estado', 1)
            // ->where('id_proveedor_mae', 2)
            ->orderBy('ruc_proveedor', 'ASC')
            ->distinct('ruc_proveedor')
            ->get();

        $list_ficha_tecnica = FichaTecnicaProduccion::select('id_ft_produccion', 'modelo')
            ->where('estado', 1)
            ->orderBy('modelo', 'ASC')
            ->distinct('modelo')
            ->get();


        $list_proceso_visita = ProcesoVisita::select('id_procesov', 'nom_proceso')
            ->where('estado', 1)
            ->orderBy('nom_proceso', 'ASC')
            ->distinct('nom_proceso')
            ->get();

        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.modal_registrar', compact('list_area', 'list_inspector', 'list_proveedor', 'list_ficha_tecnica', 'list_proceso_visita'));
    }


    public function store_av(Request $request)
    {
        $request->validate([
            'id_inspector' => 'required',
            'inspector_acompaniante' => 'required',
            'id_ptpartida' => 'required',
            'id_ptllegada' => 'required',
            'id_modelo' => 'required',
            'id_proceso' => 'required',
            'tableData' => 'required|json'
        ], [
            'id_inspector.required' => 'Debe ingresar inspector.',
            'inspector_acompaniante.required' => 'Debe ingresar inspector acompañante.',
            'id_ptpartida.required' => 'Debe ingresar punto partida.',
            'id_ptllegada.required' => 'Debe ingresar punto llegada.',
            'id_modelo.required' => 'Debe ingresar modelo.',
            'id_proceso.required' => 'Debe ingresar proceso.',
            'tableData.required' => 'Debe enviar datos de la tabla.',
            'tableData.json' => 'Los datos de la tabla deben estar en formato JSON.'
        ]);

        // Obtener los datos de la tabla
        $tableData = json_decode($request->input('tableData'), true);
        // Validar y procesar los datos adicionales del formulario
        $inspectoresAcompaniante = $request->inspector_acompaniante ? implode(',', $request->inspector_acompaniante) : '';
        $inspector = Usuario::where('id_usuario', $request->id_inspector)->first();
        $idPuestoInspector = $inspector ? $inspector->id_puesto : null;
        // Obtener el último código de asignación
        $ultimoCodAsignacion = AsignacionVisita::orderBy('cod_asignacion', 'desc')->value('cod_asignacion');
        // Obtener el último código de asignación
        $ultimoCodAsignacion = AsignacionVisita::orderBy('cod_asignacion', 'desc')->value('cod_asignacion');
        if ($ultimoCodAsignacion) {
            $numero = (int)substr($ultimoCodAsignacion, 1); // Convertir la parte numérica a entero
        } else {
            $numero = 0; // Si no hay código anterior, comenzar desde cero
        }
        // Procesar los datos de la tabla y guardarlos
        foreach ($tableData as $index => $data) {
            // Obtener los valores de proveedor para partida y llegada dentro del bucle
            $proveedorpar = ProveedorGeneral::where('id_proveedor', $data['partida'])->first();
            $proveedorlle = ProveedorGeneral::where('id_proveedor', $data['llegada'])->first();
            $tipo_punto_partida = $proveedorpar ? $proveedorpar->id_proveedor_mae : null;
            $tipo_punto_llegada = $proveedorlle ? $proveedorlle->id_proveedor_mae : null;

            $nuevoNumero = str_pad($numero + 1 + $index, 5, '0', STR_PAD_LEFT); // Asegurarse de que tenga 5 dígitos
            $codAsignacion = 'V' . $nuevoNumero;
            // Crear un nuevo registro en la tabla asignacion_visita con datos modificados según $data
            AsignacionVisita::create([
                'cod_asignacion' => $codAsignacion, // Usar un nuevo código de asignación para cada fila
                'id_inspector' => $request->id_inspector, // Usar el inspector del formulario
                'id_puesto_inspector' => $idPuestoInspector, // Usar el puesto de inspector del formulario
                'fecha' => $request->fecha, // Usar la fecha del formulario
                'punto_partida' => $data['partida'], // Usar el valor de la tabla para el punto de partida
                'punto_llegada' => $data['llegada'], // Usar el valor de la tabla para el punto de llegada
                'tipo_punto_partida' => $tipo_punto_partida, // Usar el tipo de punto de partida del proveedor
                'tipo_punto_llegada' => $tipo_punto_llegada, // Usar el tipo de punto de llegada del proveedor
                'id_modelo' => $data['modelo'], // Usar el modelo del formulario
                'id_proceso' => $data['proceso'], // Usar el proceso del formulario
                'observacion_otros' => '', // Campo vacío
                'id_tipo_transporte' => 0, // Valor por defecto
                'costo' => $request->costo ?? 0.00, // Usar el costo del formulario o 0.00 por defecto
                'inspector_acompaniante' => $inspectoresAcompaniante, // Usar los inspectores acompañantes del formulario
                'observacion' => '', // Campo vacío
                'estado_registro' => 1, // Valor por defecto
                'estado' => 1, // Valor por defecto
                'fec_reg' => now(), // Fecha actual
                'user_reg' => session('usuario')->id_usuario, // Usuario que registra
                'fec_act' => now(), // Fecha actual
                'user_act' => session('usuario')->id_usuario, // Usuario que actualiza
                'user_eli' => 0, // Valor por defecto
            ]);
        }

        return response()->json(['message' => 'Registros creados con éxito.']);
    }

    public function destroy_av($id)
    {

        AsignacionVisita::where('id_asignacion_visita', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function edit_av($id)
    {
        $get_id = AsignacionVisita::where('id_asignacion_visita', $id)
            ->firstOrFail();

        $list_inspector = User::select(
            'id_usuario',
            DB::raw("CONCAT(usuario_apater, ' ', usuario_amater, ' ', usuario_nombres) AS nombre_completo")
        )
            ->where('estado', 1)
            ->where('id_area', 2)
            ->orderBy('usuario_nombres', 'ASC')
            ->distinct('usuario_nombres')
            ->get();
        $list_proveedor = ProveedorGeneral::select(
            'id_proveedor',
            DB::raw("CONCAT(nombre_proveedor, ' - ', ruc_proveedor, ' - ', responsable) AS nombre_proveedor_completo")
        )
            ->where('estado', 1)
            // ->where('id_proveedor_mae', 2)
            ->orderBy('ruc_proveedor', 'ASC')
            ->distinct('ruc_proveedor')
            ->get();

        $list_ficha_tecnica = FichaTecnicaProduccion::select('id_ft_produccion', 'modelo')
            ->where('estado', 1)
            ->orderBy('modelo', 'ASC')
            ->distinct('modelo')
            ->get();


        $list_proceso_visita = ProcesoVisita::select('id_procesov', 'nom_proceso')
            ->where('estado', 1)
            ->orderBy('nom_proceso', 'ASC')
            ->distinct('nom_proceso')
            ->get();

        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.modal_editar', compact(
            'get_id',
            'list_inspector',
            'list_proveedor',
            'list_ficha_tecnica',
            'list_proceso_visita'
        ));
    }
}

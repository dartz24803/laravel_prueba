<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AsignacionVisita;
use App\Models\AsignacionVisitaTransporte;
use App\Models\FichaTecnicaProduccion;
use App\Models\Gerencia;
use App\Models\Notificacion;
use App\Models\ProcesosHistorial;
use App\Models\ProcesoVisita;
use App\Models\ProveedorGeneral;
use App\Models\Puesto;
use App\Models\SubGerencia;
use App\Models\TipoPortal;
use App\Models\TipoTransporteProduccion;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduccionController extends Controller
{
    public function indexav()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(4);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_gerencia = Gerencia::where('estado', 1)->orderBy('nom_gerencia', 'ASC')->get();

        return view('manufactura.produccion.asignacion_visitas.index', compact('list_notificacion', 'list_gerencia', 'list_subgerencia'));
    }

    public function indexrev()
    {
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(4);
        return view('manufactura.produccion.registro_visitas.index', compact('list_notificacion', 'list_subgerencia'));
    }
    public function indexft()
    {
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(4);
        return view('manufactura.produccion.ficha_tecnica.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_rv()
    {
        return view('manufactura.produccion.registro_visitas.registrar_visitas.index');
    }

    public function index_av()
    {
        return view('manufactura.produccion.asignacion_visitas.asignar_visitas.index');
    }
    public function index_ft()
    {
        return view('manufactura.produccion.ficha_tecnica.registrar_ficha_tecnica.index');
    }

    public function list_av(Request $request)
    {
        // Obtener las fechas del request, con valores predeterminados si no se proporcionan
        $fini = $request->input('fini', date('Y-m-01')); // Primer día del mes actual
        $ffin = $request->input('ffin', date('Y-m-t')); // Último día del mes actual
        // Obtener la lista de asignaciones filtrada por fecha
        $list_asignacion = AsignacionVisita::getListAsignacion($fini, $ffin, 0);
        // dd($list_asignacion);
        return view('manufactura.produccion.asignacion_visitas.asignar_visitas.lista', compact('list_asignacion'));
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
            ->whereIn('id_area', [28,27,47,48,49])
            ->orderBy(DB::raw("CONCAT(usuario_apater, ' ', usuario_amater, ' ', usuario_nombres)"), 'ASC') // Ordenar por nombre completo
            ->distinct()
            ->get();

        $list_proveedor = ProveedorGeneral::select(
            'id_proveedor',
            'ruc_proveedor',
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

        return view('manufactura.produccion.asignacion_visitas.asignar_visitas.modal_registrar', compact('list_area', 'list_inspector', 'list_proveedor', 'list_ficha_tecnica', 'list_proceso_visita'));
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
        foreach ($tableData as $index => $data) {
            if ($data['partida'] == 9999) {
                $tipo_punto_partida = 1;
            } else {
                $proveedorpar = ProveedorGeneral::where('id_proveedor', $data['partida'])->first();
                $tipo_punto_partida = $proveedorpar ? $proveedorpar->id_proveedor_mae : null;
            }
            if ($data['llegada'] == 9999) {
                $tipo_punto_llegada = 1;
            } else {
                $proveedorlle = ProveedorGeneral::where('id_proveedor', $data['llegada'])->first();
                $tipo_punto_llegada = $proveedorlle ? $proveedorlle->id_proveedor_mae : null;
            }

            $nuevoNumero = str_pad($numero + 1 + $index, 5, '0', STR_PAD_LEFT); // Asegurar 5 dígitos
            $codAsignacion = 'V' . $nuevoNumero;

            // Crear un nuevo registro en la tabla asignacion_visita
            AsignacionVisita::create([
                'cod_asignacion' => $codAsignacion,
                'id_inspector' => $request->id_inspector,
                'id_puesto_inspector' => $idPuestoInspector,
                'fecha' => $request->fecha,
                'punto_partida' => $data['partida'],
                'punto_llegada' => $data['llegada'],
                'tipo_punto_partida' => $tipo_punto_partida,
                'tipo_punto_llegada' => $tipo_punto_llegada,
                'id_modelo' => $data['modelo'],
                'id_proceso' => $data['proceso'],
                'observacion_otros' => '',
                'id_tipo_transporte' => 0,
                'costo' => $request->costo ?? 0.00,
                'inspector_acompaniante' => $inspectoresAcompaniante,
                'observacion' => '',
                'estado_registro' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'user_eli' => 0,
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
            ->whereIn('id_area', [28,27,47,48,49])
            ->orderBy(DB::raw("CONCAT(usuario_apater, ' ', usuario_amater, ' ', usuario_nombres)"), 'ASC') // Ordenar por nombre completo
            ->distinct()
            ->get();
        // dd($list_inspector);

        $list_proveedor = ProveedorGeneral::select(
            'id_proveedor',
            'ruc_proveedor',
            DB::raw("CONCAT(nombre_proveedor, ' - ', ruc_proveedor, ' - ', responsable) AS nombre_proveedor_completo")
        )
            ->where('estado', 1)
            ->orderBy('ruc_proveedor', 'ASC')  // Ordena por la columna que ahora está en la selección
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


        return view('manufactura.produccion.asignacion_visitas.asignar_visitas.modal_editar', compact(
            'get_id',
            'list_inspector',
            'list_proveedor',
            'list_ficha_tecnica',
            'list_proceso_visita',
        ));
    }

    public function detalle_av($id)
    {
        $get_id = AsignacionVisita::where('id_asignacion_visita', $id)
            ->firstOrFail();
        // dd($get_id);

        $list_tipo_transporte = TipoTransporteProduccion::select(
            'id_tipo_transporte',
            'nom_tipo_transporte'
        )
            ->where('estado', 1)
            ->orderBy('nom_tipo_transporte', 'ASC')
            ->distinct('nom_tipo_transporte')
            ->get();

        $list_visita_transporte = AsignacionVisitaTransporte::select(
            'asignacion_visita_transporte.id_tipo_transporte',
            'tipo_transporte_produccion.nom_tipo_transporte',
            'asignacion_visita_transporte.costo',
            'asignacion_visita_transporte.descripcion',

        )
            ->join('tipo_transporte_produccion', 'asignacion_visita_transporte.id_tipo_transporte', '=', 'tipo_transporte_produccion.id_tipo_transporte')
            ->where('asignacion_visita_transporte.estado', 1)
            ->where('asignacion_visita_transporte.id_asignacion_visita', $id) // Filtrar por id_asignacion_visita
            ->get();



        return view('manufactura.produccion.asignacion_visitas.asignar_visitas.modal_detalle', compact(
            'get_id',
            'list_tipo_transporte',
            'list_visita_transporte'
        ));
    }

    public function ListaAsignacionVisitas($fecha, $fecha_fin)
    {
        $list_asignacion = AsignacionVisita::getListAsignacion($fecha, $fecha_fin, 0);

        return view('manufactura.produccion.asignacion_visitas.asignar_visitas.lista', compact('list_asignacion'));
    }


    public function update_av(Request $request, $id)
    {
        $request->validate([
            'id_inspectore' => 'required',
            'id_ptpartidae' => 'required',
            'id_ptllegadae' => 'required',
            'id_modeloe' => 'required',


        ], [
            'id_inspectore.required' => 'Debe seleccionar inspector.',
            'id_ptpartidae.required' => 'Debe seleccionar punto partida.',
            'id_ptllegadae.required' => 'Debe seleccionar punto llegada.',
            'id_modeloe.required' => 'Debe seleccionar modelo.',

        ]);

        AsignacionVisita::findOrFail($id)->update([
            'fecha' => $request->fechae,
            'id_inspector' => $request->id_inspectore,
            'punto_partida' => $request->id_ptpartidae,
            'punto_llegada' => $request->id_ptllegadae,
            'id_modelo' => $request->id_modeloe,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario

        ]);
    }

    public function iniciar_rv(Request $request, $id)
    {
        AsignacionVisita::findOrFail($id)->update([
            'estado_registro' => 2,
            'fec_ini_visita' => now(),
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario

        ]);
    }

    public function finalizar_rv(Request $request, $id)
    {
        AsignacionVisita::findOrFail($id)->update([
            'estado_registro' => 3,
            'fec_fin_visita' => now(),
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }


    public function update_detalle_av(Request $request, $id)
    {
        // Eliminar los registros existentes relacionados con la id_asignacion_visita
        AsignacionVisitaTransporte::where('id_asignacion_visita', $id)->delete();

        // Obtener los datos de entrada
        $ncostos = $request->input('ncosto', []);
        $descripciones = $request->input('descripcion', []);
        $id_tipotransportes = $request->input('id_tipotransporte', []);

        $hora_inicio_almuerzo = $request->input('hora_inicio_almuerzo');
        $hora_fin_almuerzo = $request->input('hora_fin_almuerzo');
        $observacion = $request->input('observacion');
        $almuerzo = $request->has('almuerzo') ? 1 : 0;

        // Crear nuevos registros solo si $ncostos no está vacío
        if (!empty($ncostos)) {
            foreach ($ncostos as $index => $ncosto) {
                AsignacionVisitaTransporte::create([
                    'id_asignacion_visita' => $id,
                    'id_tipo_transporte' =>  $id_tipotransportes[$index] ?? '',
                    'costo' => $ncosto,
                    'descripcion' => $descripciones[$index] ?? '',
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }

        // Actualizar la información de Almuerzo siempre que haya datos
        if (!empty($hora_inicio_almuerzo) || !empty($hora_fin_almuerzo) || !empty($observacion) || !isset($request->almuerzo)) {
            AsignacionVisita::findOrFail($id)->update([
                'ini_alm' => $hora_inicio_almuerzo,
                'fin_alm' => $hora_fin_almuerzo,
                'observacion' => $observacion,
                'ch_alm' => $almuerzo,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }



    // REGISTRO DE VISITAS

    public function list_rv(Request $request)
    {
        $idUsuario = session('usuario')->id_usuario;
        // Obtener las fechas del request, con valores predeterminados si no se proporcionan
        $fini = $request->input('fini', date('Y-m-01')); // Primer día del mes actual
        $ffin = $request->input('ffin', date('Y-m-t')); // Último día del mes actual
        // Obtener la lista de asignaciones filtrada por fecha
        $list_asignacion = AsignacionVisita::getListAsignacion($fini, $ffin, $idUsuario);
        // dd($list_asignacion);
        return view('manufactura.produccion.registro_visitas.registrar_visitas.lista', compact('list_asignacion'));
    }

    public function ListaRegistroVisitas($fecha, $fecha_fin)
    {
        $idUsuario = session('usuario')->id_usuario;

        $list_asignacion = AsignacionVisita::getListAsignacion($fecha, $fecha_fin, $idUsuario);

        return view('manufactura.produccion.asignacion_visitas.asignar_visitas.lista', compact('list_asignacion'));
    }

    public function detalle_rv($id)
    {
        $get_id = AsignacionVisita::where('id_asignacion_visita', $id)
            ->firstOrFail();
        // dd($get_id);

        $list_tipo_transporte = TipoTransporteProduccion::select(
            'id_tipo_transporte',
            'nom_tipo_transporte'
        )
            ->where('estado', 1)
            ->orderBy('nom_tipo_transporte', 'ASC')
            ->distinct('nom_tipo_transporte')
            ->get();

        $list_visita_transporte = AsignacionVisitaTransporte::select(
            'asignacion_visita_transporte.id_tipo_transporte',
            'tipo_transporte_produccion.nom_tipo_transporte',
            'asignacion_visita_transporte.costo',
            'asignacion_visita_transporte.descripcion',

        )
            ->join('tipo_transporte_produccion', 'asignacion_visita_transporte.id_tipo_transporte', '=', 'tipo_transporte_produccion.id_tipo_transporte')
            ->where('asignacion_visita_transporte.estado', 1)
            ->where('asignacion_visita_transporte.id_asignacion_visita', $id) // Filtrar por id_asignacion_visita
            ->get();

        return view('manufactura.produccion.registro_visitas.registrar_visitas.modal_detalle', compact(
            'get_id',
            'list_tipo_transporte',
            'list_visita_transporte'
        ));
    }

    // FICHA TÉCNICA
    public function list_ft(Request $request)
    {
        $list_ficha_tecnica = FichaTecnicaProduccion::select(
            'ficha_tecnica_produccion.id_ft_produccion',
            'ficha_tecnica_produccion.fec_reg',
            'ficha_tecnica_produccion.user_reg',
            'ficha_tecnica_produccion.modelo',
            'ficha_tecnica_produccion.img_ft_produccion',
            DB::raw("CONCAT(users.usuario_nombres, ' ', users.usuario_apater, ' ', users.usuario_amater) AS nombre_completo")
        )
            ->join('users', 'ficha_tecnica_produccion.user_reg', '=', 'users.id_usuario')
            ->where('ficha_tecnica_produccion.estado', 1)
            ->orderBy('ficha_tecnica_produccion.modelo', 'ASC')
            ->distinct('ficha_tecnica_produccion.modelo')
            ->get();
        // dd($list_ficha_tecnica);
        return view('manufactura.produccion.ficha_tecnica.registrar_ficha_tecnica.lista', compact('list_ficha_tecnica'));
    }

    public function create_ft()
    {
        $list_ficha_tecnica = FichaTecnicaProduccion::select(
            'id_ft_produccion',
            'fec_reg',
            'user_reg',
            'modelo',
            'img_ft_produccion',
        )
            ->where('estado', 1)
            ->orderBy('modelo', 'ASC')
            ->distinct('modelo')->get();

        return view('manufactura.produccion.ficha_tecnica.registrar_ficha_tecnica.modal_registrar', compact('list_ficha_tecnica'));
    }

    public function image_ft($id)
    {
        $get_id = FichaTecnicaProduccion::where('id_ft_produccion', $id)->firstOrFail();
        // Construye la URL completa de la imagen
        $imageUrl = null;
        if ($get_id->nom_img_ft_produccion) {
            $imageUrl = "https://lanumerounocloud.com/intranet/PRODUCCION/ficha_tecnica/" . $get_id->nom_img_ft_produccion;
        }
        return view('manufactura.produccion.ficha_tecnica.registrar_ficha_tecnica.modal_imagen', compact('get_id', 'imageUrl'));
    }

    public function destroy_ft($id)
    {

        FichaTecnicaProduccion::where('id_ft_produccion', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function store_ft(Request $request)
    {
        $request->validate([
            'modelo' => 'required',
        ], [
            'modelo.required' => 'Debe ingresar nombre Modelo.',
        ]);
        // Conectar al servidor FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
        // Conexión a FTP SERVER
        if ($con_id && $lr) {
            ftp_pasv($con_id, true);
            // Subir archivo 1
            if (!empty($_FILES["archivo1"]["name"])) {

                $source_file = $_FILES['archivo1']['tmp_name'];
                $nombre = $_FILES["archivo1"]["name"];
                $nombimageUrl = "https://lanumerounocloud.com/intranet/PRODUCCION/ficha_tecnica/" . $nombre;

                $subio = ftp_put($con_id, "PRODUCCION/ficha_tecnica/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $archivo = $nombre;
                } else {
                    echo "Archivo 1 no subido correctamente";
                }
            }
            ftp_close($con_id); // Cerrar conexión FTP
        } else {
            echo "No se conectó al servidor FTP";
        }

        // Crear un nuevo registro en la tabla asignacion_visita
        FichaTecnicaProduccion::create([
            'modelo' =>  $request->modelo,
            'nom_img_ft_produccion' => $nombre,
            'img_ft_produccion' => $nombimageUrl,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'user_eli' => 0,
        ]);


        return response()->json(['message' => 'Registros creados con éxito.']);
    }
}

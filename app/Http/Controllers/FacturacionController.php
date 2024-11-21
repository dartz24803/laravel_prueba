<?php

namespace App\Http\Controllers;

use App\Models\CajaChicaPago;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TbContabilidad;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(8);
        return view('finanzas.tesoreria.facturacion.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list(Request $request)
    {
        // $list_tbcontabilidad = TbContabilidad::obtenerYInsertarStock();
        return view('finanzas.tesoreria.facturacion.lista');
    }


    public function facturados_list(Request $request)
    {
        $idsSeleccionados = $request->input('ids');
        // dd($idsSeleccionados);  
        TbContabilidad::marcarComoCerrados($idsSeleccionados);
        return response()->json(['message' => 'Facturación exitosa']);
    }

    public function list_datatable(Request $request)
    {
        // Obtener los parámetros enviados por DataTables
        $draw = intval($request->input('draw'));
        $start = intval($request->input('start')); // Índice inicial (para paginación)
        $length = intval($request->input('length')); // Cantidad de registros por página
        $search = $request->input('search')['value'] ?? ''; // Valor de búsqueda
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $estado = $request->input('estado');
        $filters = [
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => $estado,
            'search' => $search
        ];
        // Realizar la consulta usando el "scopeFiltros" en el modelo 
        $query = TbContabilidad::filtros($filters);
        // Obtener el total de registros antes de aplicar la paginación
        $totalRecords = $query->count();
        // Obtener los datos paginados
        $data = $query->skip($start)->take($length)->get();
        // Responder con los datos en formato JSON que DataTables espera
        return response()->json([
            'draw' => $draw,                         // Identificador único de la solicitud
            'recordsTotal' => $totalRecords,         // Total de registros en la base de datos
            'recordsFiltered' => $totalRecords,      // Total de registros después de filtrar
            'data' => $data                          // Los registros para la página actual
        ]);
    }

    public function actualizarTabla(Request $request)
    {
        TbContabilidad::sincronizarContabilidad();
    }
}

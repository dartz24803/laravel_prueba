<?php

namespace App\Http\Controllers;

use App\Models\CajaChicaPago;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TbContabilidad;
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

    // public function list(Request $request)
    // {
    //     // Obtener la página actual y el número de registros por página
    //     // $perPage = $request->input('perPage', 50); 
    //     $list_tbcontabilidad = TbContabilidad::obtenerYInsertarStock();
    //     // dd($list_tbcontabilidad);
    //     // Pasa los datos a la vista
    //     return view('finanzas.tesoreria.facturacion.lista', compact('list_tbcontabilidad'));
    // }
    public function list(Request $request)
    {

        // Pasa los datos a la vista
        return view('finanzas.tesoreria.facturacion.lista');
    }

    public function list_datatable(Request $request)
    {

        // Obtener los parámetros enviados por DataTables
        $draw = intval($request->input('draw'));
        $start = intval($request->input('start')); // Índice inicial (para paginación)
        $length = intval($request->input('length')); // Cantidad de registros por página
        $search = $request->input('search')['value'] ?? ''; // Valor de búsqueda
        // Construir la consulta base
        $query = TbContabilidad::query(); // No hay filtro por 'guia_remision'
        // dd($query->toSql());
        // Filtrar los datos si hay una búsqueda
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('estilo', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }
        // Obtener el total de registros antes de aplicar la paginación
        $totalRecords = $query->count();
        // dd($totalRecords);
        // Obtener los datos paginados
        $data = $query->skip($start)->take($length)->get();
        // dd($data);
        // Responder con los datos en formato JSON que DataTables espera
        return response()->json([
            'draw' => $draw,                         // Identificador único de la solicitud
            'recordsTotal' => $totalRecords,         // Total de registros en la base de datos
            'recordsFiltered' => $totalRecords,      // Total de registros después de filtrar
            'data' => $data                          // Los registros para la página actual
        ]);
    }
}

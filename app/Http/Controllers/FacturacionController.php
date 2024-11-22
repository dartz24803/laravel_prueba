<?php

namespace App\Http\Controllers;

use App\Models\CajaChicaPago;
use App\Models\Empresas;
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
        return view('finanzas.contabilidad.facturacion.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function obtenerSkus(Request $request)
    {
        $search = $request->input('search'); // Buscar por este término
        $query = TbContabilidad::query();

        if ($search) {
            $query->where('sku', 'like', "%{$search}%"); // Filtrar por el término de búsqueda en el campo SKU
        }

        // Paginar resultados (por ejemplo, 100 registros por llamada)
        $skus = $query->select('sku') // Seleccionar solo el campo SKU
            ->distinct() // Asegurar que no haya duplicados
            ->limit(100) // Limitar la cantidad de resultados
            ->get();

        // Formatear para Select2
        $results = $skus->map(function ($sku) {
            return [
                'id' => $sku->sku,
                'text' => $sku->sku,
            ];
        });

        return response()->json(['results' => $results]);
    }


    public function list()
    {
        // Obtener la lista de empresas con los campos id_empresa y nom_empresa
        $empresas = Empresas::select('id_empresa', 'nom_empresa')
            ->whereIn('id_empresa', [29, 28, 33, 31, 34, 27, 32, 30]) // Filtrar por los IDs específicos
            ->get();
        // Obtener la lista de SKU únicos desde la tabla tb_contabilidad donde cerrado = 0
        $skus = TbContabilidad::select('sku')
            ->where('cerrado', 0)
            ->distinct()
            ->limit(100)
            ->get();

        // Retornar la vista con las empresas y los SKUs
        return view('finanzas.contabilidad.facturacion.lista', compact('empresas', 'skus'));
    }


    public function facturados_ver(Request $request)
    {
        $idsSeleccionados = $request->input('ids');
        $list_previsualizacion_por_facturar = TbContabilidad::filtrarCerrados($idsSeleccionados);
        // Devolver los registros actualizados en el JSON de respuesta
        return response()->json([
            'updated_records' => $list_previsualizacion_por_facturar
        ]);
    }


    public function facturar_cerrar(Request $request)
    {
        $idsSeleccionados = $request->input('ids');
        // Llamar a la función de marcar como cerrados y obtener los registros actualizados
        $registros = TbContabilidad::marcarComoCerrados($idsSeleccionados);
        // Verificar si los registros fueron actualizados correctamente
        if ($registros) {
            return response()->json([
                'success' => true,
                'message' => 'Los datos se exportaron correctamente.',
                'data' => $registros // opcional: incluir los registros procesados si es necesario
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al exportar los datos.'
            ]);
        }
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
        $filtroSku = $request->input('filtroSku');
        $filtroEmpresa = $request->input('filtroEmpresa');
        $filters = [
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'estado' => $estado,
            'sku' => $filtroSku,
            'empresa' => $filtroEmpresa,
            'search' => $search,

        ];
        // dd($filters);
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

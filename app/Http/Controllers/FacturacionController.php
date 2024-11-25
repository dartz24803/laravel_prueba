<?php

namespace App\Http\Controllers;

use App\Models\CajaChicaPago;
use App\Models\Empresas;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TbContabilidad;
use App\Models\TbContabilidadCerrados;
use App\Models\TbContabilidadCerradosParcial;
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
        $filas = $request->input('filas'); // Recibimos las filas enviadas desde el frontend
        // Iterar sobre las filas recibidas
        foreach ($filas as $fila) {
            $id = $fila['id']; // ID de la fila
            $parcial = $fila['parcial']; // Estado parcial
            // Buscar el registro original en la tabla tb_contabilidad
            $registro = TbContabilidad::find($id);
            if ($registro) {
                if ($parcial == 1) {
                    // Caso parcial = 1, insertar en tb_contabilidad_cerrados_parcial
                    TbContabilidadCerradosParcial::create([
                        'estilo' => $registro->estilo,
                        'color' => $registro->color,
                        'talla' => $registro->talla,
                        'sku' => $registro->sku,
                        'descripcion' => $registro->descripcion,
                        'costo_precio' => $registro->costo_precio,
                        'empresa' => $registro->empresa,
                        'alm_dsc' => $registro->alm_dsc,
                        'alm_ln1' => $registro->alm_ln1,
                        'alm_discotela' => $registro->alm_discotela,
                        'alm_pb' => $registro->alm_pb,
                        'alm_mad' => $registro->alm_mad,
                        'alm_fam' => $registro->alm_fam,
                        'fecha_documento' => $registro->fecha_documento,
                        'guia_remision' => $registro->guia_remision,
                        'base' => $registro->base,
                        'enviado' => $fila['enviado'],
                        'cia' => $registro->cia,
                        'estado' => $registro->estado,
                        'stock' => $registro->stock,
                        'cerrado' => 0 // Cambiar el campo cerrado a 0
                    ]);
                    // Actualizar el campo 'enviado' en la tabla tb_contabilidad haciendo la resta
                    $registro->enviado = $registro->enviado - $fila['enviado'];
                    $registro->save();
                } else {
                    // Caso parcial = 0, insertar en tb_contabilidad_cerrados y actualizar tb_contabilidad
                    TbContabilidadCerrados::create([
                        'estilo' => $registro->estilo,
                        'color' => $registro->color,
                        'talla' => $registro->talla,
                        'sku' => $registro->sku,
                        'descripcion' => $registro->descripcion,
                        'costo_precio' => $registro->costo_precio,
                        'empresa' => $registro->empresa,
                        'alm_dsc' => $registro->alm_dsc,
                        'alm_ln1' => $registro->alm_ln1,
                        'alm_discotela' => $registro->alm_discotela,
                        'alm_pb' => $registro->alm_pb,
                        'alm_mad' => $registro->alm_mad,
                        'alm_fam' => $registro->alm_fam,
                        'fecha_documento' => $registro->fecha_documento,
                        'guia_remision' => $registro->guia_remision,
                        'base' => $registro->base,
                        'enviado' => $registro->enviado,
                        'cia' => $registro->cia,
                        'estado' => $registro->estado,
                        'stock' => $registro->stock,
                        'cerrado' => 1 // Cambiar el campo cerrado a 1
                    ]);
                    // Actualizar el campo cerrado en tb_contabilidad
                    $registro->cerrado = 1;
                    $registro->save();
                }
            } else {
                // Manejo de error si el registro no existe
                return response()->json([
                    'success' => false,
                    'message' => "El registro con ID $id no existe en la tabla tb_contabilidad."
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Los datos se procesaron correctamente.'
        ]);
    }


    public function list_datatable(Request $request)
    {
        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $search = $request->input('search')['value'] ?? '';
        $order = $request->input('order'); // Parámetros de ordenamiento
        $columns = $request->input('columns'); // Información de las columnas

        $query = TbContabilidad::filtros([
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
            'estado' => $request->input('estado'),
            'sku' => $request->input('filtroSku'),
            'empresa' => $request->input('filtroEmpresa'),
            'search' => $search
        ]);

        // Manejo de ordenamiento
        if ($order) {
            $columnIndex = $order[0]['column']; // Índice de la columna
            $columnName = $columns[$columnIndex]['data']; // Nombre de la columna
            $columnSortOrder = $order[0]['dir']; // Dirección (asc o desc)

            if ($columnName) {
                $query->orderBy($columnName, $columnSortOrder);
            }
        }

        $totalRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }


    public function actualizarTabla(Request $request)
    {

        TbContabilidad::sincronizarContabilidad();
    }
}

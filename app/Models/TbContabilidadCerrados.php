<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TbContabilidadCerrados extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'tb_contabilidad_cerrados'; // Ejemplo: si el esquema es 'dbo'

    // Clave primaria
    protected $primaryKey = 'id';

    // Campos asignables en masa
    protected $fillable = [
        'estilo',
        'color',
        'talla',
        'sku',
        'descripcion',
        'costo_precio',
        'empresa',
        'alm_ln1',
        'alm_dsc',
        'alm_discotela',
        'alm_pb',
        'alm_fam',
        'alm_mad',
        'fecha_documento',
        'guia_remision',
        'enviado',
        'estado',
        'base',
        'cia',
        'stock',
        'fecha_cerrado_total',
        'cerrado'
    ];

    // Campos de timestamp automáticos
    public $timestamps = false;

    // Si necesitas formatear las fechas
    protected $casts = [
        'fecha_documento' => 'date',
        'costo_precio' => 'decimal:2',
    ];




    public static function filtrarCerradosExcel($fechaInicio, $fechaFin)
    {
        // Filtrar solo por rango de fechas en fecha_documento y stock = 1
        $registros = self::whereBetween('fecha_documento', [$fechaInicio, $fechaFin])
            ->where('stock', 1)
            ->get();

        return $registros;
    }


    public static function filtrarCerrados(array $ids)
    {
        $registros = self::whereIn('id', $ids)->get();
        return $registros;
    }


    public function scopeFiltros($query, $filters)
    {
        // Filtrar por fecha si se pasan las fechas
        if (isset($filters['fecha_inicio']) && isset($filters['fecha_fin'])) {
            $fechaInicio = $filters['fecha_inicio'] . ' 00:00:00';
            $fechaFin = $filters['fecha_fin'] . ' 23:59:59';
            $query->whereBetween('fecha_cerrado_total', [$fechaInicio, $fechaFin]);
        }

        // Filtrar por estado de stock
        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('stock', $filters['estado']);
        }
        // Filtrar solo los registros donde 'cerrado' es igual a 0
        $query->where('cerrado', 1);
        // Filtrar por SKU si se pasa un valor
        if (isset($filters['sku']) && $filters['sku'] !== '') {
            $query->where('sku', 'like', "%{$filters['sku']}%");
        }
        // Filtrar por Empresa si se pasa un valor
        if (isset($filters['empresa']) && $filters['empresa'] !== '') {
            $query->where('empresa', 'like', "%{$filters['empresa']}%");
        }
        // Filtrar por búsqueda de texto
        if (isset($filters['search']) && $filters['search'] !== '') {
            $query->where(function ($q) use ($filters) {
                $search = $filters['search'];
                if (strlen($search) > 3) {
                    $q->where('sku', 'like', "$search%")
                        ->orWhere('guia_remision', 'like', "$search%")
                        ->orWhere('estilo', 'like', "$search%")
                        ->orWhere('color', 'like', "$search%")
                        ->orWhere('descripcion', 'like', "%$search%");
                }
            });
        }

        if (!empty($filters['almacen'])) {
            $query->where($filters['almacen'], '>', 0)
                ->where(function ($q) use ($filters) {
                    $almacenes = ['alm_dsc', 'alm_discotela', 'alm_pb', 'alm_mad', 'alm_fam'];
                    foreach ($almacenes as $almacen) {
                        if ($almacen !== $filters['almacen']) {
                            $q->where($almacen, 0);
                        }
                    }
                });
        }

        return $query;
    }

    public static function sincronizarContabilidad()
    {
        try {
            set_time_limit(300); // Aumentar el tiempo de ejecución
            // Obtener el primer día del AÑO actual
            $fechaInicioAno = Carbon::now()->startOfYear()->toDateString();
            // $fechaInicioAno = Carbon::now()->subMonth()->startOfMonth()->toDateString();

            // Paso 1: Obtener los registros existentes en MySQL con claves compuestas
            $mysqlRecords = DB::table('tb_contabilidad')
                ->where('fecha_documento', '>=', $fechaInicioAno)
                ->select('guia_remision', 'sku') // Seleccionar sólo los campos necesarios
                ->get()
                ->map(function ($record) {
                    return $record->guia_remision . '|' . $record->sku; // Crear clave compuesta
                })
                ->toArray(); // Convertir a un arreglo para búsqueda eficiente
            $mysqlRecordsSet = array_flip($mysqlRecords); // Convertir en un conjunto para búsqueda rápida
            // Paso 2: Obtener datos de SQL Server
            $data_sql = DB::connection('sqlsrv_dbmsrt')->select("
                SELECT 
                    s.Estilo,
                    s.Descripcion,
                    s.SKU,
                    s.Color,
                    s.Talla,
                    ISNULL(alm_discotela.STK, 0) AS ALM_DISCOTELA,
                    ISNULL(alm_dsc.STK, 0) AS ALM_DSC,
                    ISNULL(alm_ln1.STK, 0) AS ALM_LN1,
                    ISNULL(alm_pb.STK, 0) AS ALM_PB,
                    ISNULL(alm_fam.STK, 0) AS ALM_FAM,
                    ISNULL(alm_mad.STK, 0) AS ALM_MAD,
                    egr.CIA,
                    CASE 
                        WHEN CHARINDEX(' \\ ', egr.Origen_Destino) > 0 THEN 
                            SUBSTRING(egr.Origen_Destino, 1, CHARINDEX(' \\ ', egr.Origen_Destino) - 1)
                        ELSE 'Valor inválido'
                    END AS Empresa,
                    CASE 
                        WHEN CHARINDEX(' \\ ', egr.Origen_Destino) > 0 THEN 
                            SUBSTRING(egr.Origen_Destino, CHARINDEX(' \\ ', egr.Origen_Destino) + 2, LEN(egr.Origen_Destino))
                        ELSE 'Valor inválido'
                    END AS Base,
                    egr.Fecha_Documento,
                    egr.Referencia_1 AS Guía_de_Remisión,
                    ISNULL(egr.Enviado, 0) AS Enviado,
                    ISNULL(c.Costo_Prom, 0) AS Costo_Prom,
                    CASE 
                        WHEN ISNULL(alm_discotela.STK, 0) = 0 
                            AND ISNULL(alm_dsc.STK, 0) = 0 
                            AND ISNULL(alm_ln1.STK, 0) = 0 
                            AND ISNULL(alm_pb.STK, 0) = 0 
                        THEN 'sin Stock'
                        ELSE 'con Stock'
                    END AS Estado
                FROM 
                    (SELECT Estilo, Descripcion, Articulo AS SKU, Color, Talla 
                    FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local LIKE 'ALM%') s
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                    FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM DISCOTELA' GROUP BY Articulo) alm_discotela ON s.SKU = alm_discotela.SKU
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                    FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM DSC' GROUP BY Articulo) alm_dsc ON s.SKU = alm_dsc.SKU
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                    FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM LN1' GROUP BY Articulo) alm_ln1 ON s.SKU = alm_ln1.SKU
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                    FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM PB' GROUP BY Articulo) alm_pb ON s.SKU = alm_pb.SKU
                LEFT JOIN 
                    (SELECT Estilo, Costo_Prom FROM DBMSTR.dbo.TABLA_PREC) c ON s.Estilo = c.Estilo
                LEFT JOIN 
                    (SELECT 
                        CIA,
                        Barra AS SKU,
                        Origen_Destino,
                        Fecha_Documento,
                        Referencia_1,
                        CASE 
                            WHEN CIA = 'LN1' THEN SUM(Salidas) 
                            ELSE 0 
                        END AS Enviado
                    FROM 
                        DBMSTR.dbo.A1KARDEX_TOTAL 
                    WHERE 
                        Fecha_Documento >= ? 
                        AND motivo = '(24) -VENTAS ALMACEN'
                    GROUP BY 
                        CIA, Barra, Origen_Destino, Fecha_Documento, Referencia_1) egr ON s.SKU = egr.SKU
                WHERE 
                    egr.Referencia_1 IS NOT NULL
                ORDER BY s.SKU
            ", [$fechaInicioAno]);

            // Paso 3: Filtrar registros que no están en MySQL
            $datosAInsertar = [];
            foreach ($data_sql as $row) {
                // dd($row);
                $compositeKey = $row->Guía_de_Remisión . '|' . $row->SKU; // Crear clave compuesta
                if (!isset($mysqlRecordsSet[$compositeKey])) {
                    $datosAInsertar[] = [
                        'estilo' => $row->Estilo,
                        'descripcion' => $row->Descripcion,
                        'sku' => $row->SKU,
                        'color' => $row->Color,
                        'talla' => $row->Talla,
                        'alm_discotela' => $row->ALM_DISCOTELA,
                        'alm_dsc' => $row->ALM_DSC,
                        'alm_ln1' => $row->ALM_LN1,
                        'alm_pb' => $row->ALM_PB,
                        'alm_fam' => $row->ALM_FAM,
                        'alm_mad' => $row->ALM_MAD,
                        'cia' => $row->CIA,
                        'empresa' => $row->Empresa,
                        'base' => $row->Base,
                        'fecha_documento' => $row->Fecha_Documento,
                        'guia_remision' => $row->Guía_de_Remisión,
                        'enviado' => $row->Enviado,
                        'costo_precio' => $row->Costo_Prom,
                        'estado' => $row->Estado,
                    ];
                }
            }
            // dd(count($datosAInsertar));
            // Paso 4: Insertar en lotes
            if (!empty($datosAInsertar)) {
                try {
                    DB::table('tb_contabilidad')->insert($datosAInsertar);
                } catch (\Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            }
            return response()->json(['message' => 'Sincronización completada', 'insertados' => count($datosAInsertar)]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TbContabilidad extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'tb_contabilidad'; // Ejemplo: si el esquema es 'dbo'

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
        'cerrado'
    ];

    // Campos de timestamp automáticos
    public $timestamps = false;

    // Si necesitas formatear las fechas
    protected $casts = [
        'fecha_documento' => 'date',
        'costo_precio' => 'decimal:2',
    ];





    public static function filtrarCerrados(array $ids)
    {
        $registros = self::whereIn('id', $ids)->get();
        return $registros;
    }

    public static function filtrarCerradosExcel($fechaInicio, $fechaFin)
    {
        // Filtrar solo por rango de fechas en fecha_documento y stock = 1
        $registros = self::whereBetween('fecha_documento', [$fechaInicio, $fechaFin])
            ->where('stock', 1)
            ->get();

        return $registros;
    }


    public function scopeFiltros($query, $filters)
    {
        if (!empty($filters['fecha_inicio']) && !empty($filters['fecha_fin'])) {
            $query->whereBetween('fecha_documento', [
                $filters['fecha_inicio'] . ' 00:00:00',
                $filters['fecha_fin'] . ' 23:59:59',
            ]);
        }
        if (!empty($filters['estado'])) {
            $query->where('stock', $filters['estado']);
        }
        $query->where('cerrado', 0);
        if (!empty($filters['sku'])) {
            $query->where('sku', 'like', "%{$filters['sku']}%");
        }
        if (!empty($filters['empresa'])) {
            $query->where('empresa', 'like', "%{$filters['empresa']}%");
        }
        if (!empty($filters['search']) && strlen($filters['search']) > 3) {
            $query->where(function ($q) use ($filters) {
                $search = $filters['search'];
                $q->where('sku', 'like', "$search%")
                    ->orWhere('guia_remision', 'like', "$search%")
                    ->orWhere('estilo', 'like', "$search%")
                    ->orWhere('color', 'like', "$search%")
                    ->orWhere('descripcion', 'like', "%$search%");
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
            set_time_limit(600); // 10 minutos
            $fechaInicioAnoMysql = Carbon::now()->startOfYear()->toDateString();
            $fechaInicioAno = Carbon::now()->setMonth(7)->day(1)->toDateString();
            $mysqlRecords = DB::table('tb_contabilidad')
                ->where('fecha_documento', '>=', $fechaInicioAnoMysql)
                ->select('guia_remision', 'sku', 'empresa')
                ->get()
                ->map(function ($record) {
                    return $record->guia_remision . '|' . $record->sku . '|' . $record->empresa;
                })
                ->toArray(); // Convertir a un arreglo para búsqueda eficiente
            $mysqlRecordsCerrados = DB::table('tb_contabilidad_cerrados')
                ->where('fecha_documento', '>=', $fechaInicioAnoMysql)
                ->select('guia_remision', 'sku', 'empresa')
                ->get()
                ->map(function ($record) {
                    return $record->guia_remision . '|' . $record->sku . '|' . $record->empresa;
                })
                ->toArray();
            $combinedRecords = array_merge($mysqlRecords, $mysqlRecordsCerrados);
            $mysqlRecordsSet = array_flip($combinedRecords);
            $data_sql = DB::connection('sqlsrv_dbmsrt')->select("
                SELECT DISTINCT
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
                            AND ISNULL(alm_fam.STK, 0) = 0 
                            AND ISNULL(alm_mad.STK, 0) = 0 
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
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                    FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM FAM' GROUP BY Articulo) alm_fam ON s.SKU = alm_fam.SKU
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                    FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM MAD' GROUP BY Articulo) alm_mad ON s.SKU = alm_mad.SKU
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
            $datosAInsertar = [];
            foreach ($data_sql as $row) {
                $compositeKey = $row->Guía_de_Remisión . '|' . $row->SKU . '|' . $row->Empresa;
                if (!isset($mysqlRecordsSet[$compositeKey])) {
                    $datosAInsertar[] = [
                        'estilo' => $row->Estilo,
                        'color' => $row->Color,
                        'talla' => $row->Talla,
                        'sku' => $row->SKU,
                        'descripcion' => $row->Descripcion,
                        'costo_precio' => $row->Costo_Prom,
                        'empresa' => $row->Empresa,
                        'alm_discotela' => (int) $row->ALM_DISCOTELA,  // Convertir a entero
                        'alm_dsc' => (int) $row->ALM_DSC,  // Convertir a entero
                        'alm_ln1' => (int) $row->ALM_LN1,  // Convertir a entero
                        'alm_pb' => (int) $row->ALM_PB,  // Convertir a entero
                        'alm_fam' => (int) $row->ALM_FAM,  // Convertir a entero
                        'alm_mad' => (int) $row->ALM_MAD,  // Convertir a entero
                        'cia' => $row->CIA,
                        'base' => $row->Base,
                        'fecha_documento' => $row->Fecha_Documento,
                        'guia_remision' => $row->Guía_de_Remisión,
                        'enviado' => (int) $row->Enviado,  // Convertir a entero
                        'estado' => $row->Estado,
                        'stock' => ($row->Estado == 'sin Stock') ? 0 : 1, // Verificar stock
                    ];
                }
            }
            $totalInserted = 0; // Inicializar el contador
            if (!empty($datosAInsertar)) {
                foreach ($datosAInsertar as $dato) {
                    try {
                        TbContabilidad::create($dato);
                        $totalInserted++;
                    } catch (\Exception $e) {
                        // Manejar errores específicos si es necesario
                    }
                }
            }
            $cantidadRegistrosUpdate = DB::table('tb_contabilidad')
                ->count();
            DB::table('tb_contabilidad_configuracion')
                ->where('tipo', 1) //CONFIGURACIÓN DE REGISTROS 
                ->update([
                    'fecha_actualizacion' => now(),
                    'estado' => 1,
                    'cantidad_registros' => $cantidadRegistrosUpdate,
                ]);
            return $totalInserted;
        } catch (\Exception $e) {
            throw new \Exception("Error al sincronizar datos: " . $e->getMessage());
        }
    }


    public static function sincronizarEnviadosContabilidad()

    {
        try {
            set_time_limit(600);
            // Obtener el primer día del AÑO actual
            $fechaInicioAnoMysql = Carbon::now()->startOfYear()->toDateString();
            // Obtener el primer día de Julio del año actual
            $fechaInicioAno = Carbon::now()->setMonth(7)->day(1)->toDateString();
            // Paso 1: Obtener los registros existentes en MySQL con claves compuestas de la tabla tb_contabilidad
            $mysqlRecords = DB::table('tb_contabilidad')
                ->where('fecha_documento', '>=', $fechaInicioAnoMysql)
                ->select('guia_remision', 'sku', 'empresa', 'enviado')
                ->get()
                ->map(function ($record) {
                    return $record->guia_remision . '|' . $record->sku . '|' . $record->empresa;
                })
                ->toArray(); // Convertir a un arreglo para búsqueda eficiente

            // Usar solo los registros de tb_contabilidad
            $mysqlRecordsSet = array_flip($mysqlRecords);

            // Paso 2: Obtener datos de SQL Server
            $data_sql = DB::connection('sqlsrv_dbmsrt')->select("
            SELECT DISTINCT
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
                        AND ISNULL(alm_fam.STK, 0) = 0 
                        AND ISNULL(alm_mad.STK, 0) = 0 
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
                (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM FAM' GROUP BY Articulo) alm_fam ON s.SKU = alm_fam.SKU
            LEFT JOIN 
                (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK 
                FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM MAD' GROUP BY Articulo) alm_mad ON s.SKU = alm_mad.SKU
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

            $datosAActualizar = [];
            $keys = [];
            $batchSize = 1000;  // Número máximo de elementos por consulta
            $keysChunks = array_chunk($keys, $batchSize);
            $mysqlRecords = collect();
            foreach ($keysChunks as $chunk) {
                $records = DB::table('tb_contabilidad')
                    ->whereIn(DB::raw('CONCAT(guia_remision, "|", sku, "|", empresa)'), $chunk)
                    ->select('guia_remision', 'sku', 'empresa', 'alm_discotela', 'alm_dsc', 'alm_pb', 'alm_ln1', 'alm_fam', 'alm_mad')
                    ->get();
                $mysqlRecords = $mysqlRecords->merge($records);
            }

            $mysqlRecords = $mysqlRecords->keyBy(function ($item) {
                return $item->guia_remision . '|' . $item->sku . '|' . $item->empresa;
            });

            // Procesar cada fila de datos y comparar con los valores de MySQL
            foreach ($data_sql as $row) {
                $compositeKey = $row->Guía_de_Remisión . '|' . $row->SKU . '|' . $row->Empresa;
                // Verificar si el registro existe en los registros de MySQL
                if (isset($mysqlRecords[$compositeKey])) {

                    $almDiscotelaActual = (int) $row->ALM_DISCOTELA;
                    $almDscActual = (int) $row->ALM_DSC;
                    $almPbActual = (int) $row->ALM_PB;
                    $almLn1Actual = (int) $row->ALM_LN1;
                    $almFamActual = (int) $row->ALM_FAM;
                    $almMadActual = (int) $row->ALM_MAD;
                    // Obtener los valores de los almacenes actuales en MySQL
                    $almDiscotelaMysql = (int) $mysqlRecords[$compositeKey]->alm_discotela;
                    $almDscMysql = (int) $mysqlRecords[$compositeKey]->alm_dsc;
                    $almPbMysql = (int) $mysqlRecords[$compositeKey]->alm_pb;
                    $almLn1Mysql = (int) $mysqlRecords[$compositeKey]->alm_ln1;
                    $almFamMysql = (int) $mysqlRecords[$compositeKey]->alm_fam;
                    $almMadMysql = (int) $mysqlRecords[$compositeKey]->alm_mad;
                    // Comparar los valores y agregar a la lista de actualización si es necesario
                    if (
                        $almDiscotelaActual !== $almDiscotelaMysql ||
                        $almDscActual !== $almDscMysql ||
                        $almPbActual !== $almPbMysql ||
                        $almLn1Actual !== $almLn1Mysql ||
                        $almFamActual !== $almFamMysql ||
                        $almMadActual !== $almMadMysql
                    ) {

                        $datosAActualizar[] = [
                            'guia_remision' => $row->Guía_de_Remisión,
                            'sku' => $row->SKU,
                            'empresa' => $row->Empresa,
                            'alm_discotela' => $almDiscotelaActual,
                            'alm_dsc' => $almDscActual,
                            'alm_pb' => $almPbActual,
                            'alm_ln1' => $almLn1Actual,
                            'alm_fam' => $almFamActual,
                            'alm_mad' => $almMadActual,
                        ];
                    }
                }
            }
            // dd(count($datosAActualizar));

            // Paso 4: Actualizar en MySQL
            $totalUpdated = 0;
            if (count($datosAActualizar) > 0) {
                foreach ($datosAActualizar as $dato) {
                    DB::table('tb_contabilidad')
                        ->where('guia_remision', $dato['guia_remision'])
                        ->where('sku', $dato['sku'])
                        ->where('empresa', $dato['empresa'])
                        ->update([
                            'alm_discotela' => $dato['alm_discotela'],
                            'alm_dsc' => $dato['alm_dsc'],
                            'alm_pb' => $dato['alm_pb'],
                            'alm_ln1' => $dato['alm_ln1'],
                            'alm_fam' => $dato['alm_fam'],
                            'alm_mad' => $dato['alm_mad'],
                        ]);
                }
            }
            // Actualizar configuración
            $cantidadRegistrosUpdate = DB::table('tb_contabilidad')
                ->count();
            DB::table('tb_contabilidad_configuracion')
                ->where('tipo', 2) //CONFIGURACIÓN PARA ACTUALIZAR "enviados"
                ->update([
                    'fecha_actualizacion' => now(),
                    'estado' => 1,
                    'cantidad_registros' => $cantidadRegistrosUpdate,
                ]);

            // Retornar el total de registros actualizados
            return $totalUpdated;
        } catch (\Exception $e) {
            throw new \Exception("Error al sincronizar datos: " . $e->getMessage());
        }
    }
}

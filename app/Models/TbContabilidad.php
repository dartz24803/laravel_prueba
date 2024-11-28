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
        // Filtrar por fecha si se pasan las fechas
        if (isset($filters['fecha_inicio']) && isset($filters['fecha_fin'])) {
            $fechaInicio = $filters['fecha_inicio'] . ' 00:00:00';
            $fechaFin = $filters['fecha_fin'] . ' 23:59:59';
            $query->whereBetween('fecha_documento', [$fechaInicio, $fechaFin]);
        }

        // Filtrar por estado de stock
        if (isset($filters['estado']) && $filters['estado'] !== '') {
            $query->where('stock', $filters['estado']);
        }
        // Filtrar solo los registros donde 'cerrado' es igual a 0
        $query->where('cerrado', 0);
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
        // Filtros adicionales de almacenes
        if (isset($filters['alm_dsc']) && $filters['alm_dsc'] == 1) {
            $query->where('alm_dsc', '>', 0)
                ->where('alm_discotela', 0)
                ->where('alm_pb', 0)
                ->where('alm_mad', 0)
                ->where('alm_fam', 0);
        }

        if (isset($filters['alm_discotela']) && $filters['alm_discotela'] == 1) {
            $query->where('alm_discotela', '>', 0)
                ->where('alm_dsc', 0)
                ->where('alm_pb', 0)
                ->where('alm_mad', 0)
                ->where('alm_fam', 0);
        }

        if (isset($filters['alm_pb']) && $filters['alm_pb'] == 1) {
            $query->where('alm_pb', '>', 0)
                ->where('alm_dsc', 0)
                ->where('alm_discotela', 0)
                ->where('alm_mad', 0)
                ->where('alm_fam', 0);
        }

        if (isset($filters['alm_mad']) && $filters['alm_mad'] == 1) {
            $query->where('alm_mad', '>', 0)
                ->where('alm_dsc', 0)
                ->where('alm_discotela', 0)
                ->where('alm_pb', 0)
                ->where('alm_fam', 0);
        }

        if (isset($filters['alm_fam']) && $filters['alm_fam'] == 1) {
            $query->where('alm_fam', '>', 0)
                ->where('alm_dsc', 0)
                ->where('alm_discotela', 0)
                ->where('alm_pb', 0)
                ->where('alm_mad', 0);
        }
        return $query;
    }

    public static function sincronizarContabilidad()
    {
        try {
            set_time_limit(600); // 10 minutos

            // Obtener el primer día del AÑO actual
            $fechaInicioAnoMysql = Carbon::now()->startOfYear()->toDateString();
            // Obtener el primer día de Julio del año actual
            $fechaInicioAno = Carbon::now()->setMonth(7)->day(1)->toDateString();
            // Paso 1: Obtener los registros existentes en MySQL con claves compuestas de la tabla tb_contabilidad
            $mysqlRecords = DB::table('tb_contabilidad')
                ->where('fecha_documento', '>=', $fechaInicioAnoMysql)
                ->select('guia_remision', 'sku', 'empresa') // Seleccionar también el campo 'empresa'
                ->get()
                ->map(function ($record) {
                    return $record->guia_remision . '|' . $record->sku . '|' . $record->empresa; // Crear clave compuesta con 'empresa'
                })
                ->toArray(); // Convertir a un arreglo para búsqueda eficiente
            $mysqlRecordsCerrados = DB::table('tb_contabilidad_cerrados')
                ->where('fecha_documento', '>=', $fechaInicioAnoMysql)
                ->select('guia_remision', 'sku', 'empresa') // Seleccionar también el campo 'empresa'
                ->get()
                ->map(function ($record) {
                    return $record->guia_remision . '|' . $record->sku . '|' . $record->empresa; // Crear clave compuesta con 'empresa'
                })
                ->toArray(); // Convertir a un arreglo para búsqueda eficiente
            $combinedRecords = array_merge($mysqlRecords, $mysqlRecordsCerrados);
            $mysqlRecordsSet = array_flip($combinedRecords);
            // dd(count($mysqlRecordsSet));
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

            // Paso 3: Filtrar registros que no están en MySQL
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
            // Paso 4: Insertar en lotes
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
            // Actualizar configuración

            DB::table('tb_contabilidad_configuracion')
                ->where('tipo', 1)
                ->update([
                    'fecha_actualizacion' => now(),
                    'estado' => 1,
                    'cantidad_registros' => count($mysqlRecords),
                ]);


            // Retornar el total de registros insertados
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

            // Paso 3: Filtrar registros que han cambiado en "enviado"
            $datosAActualizar = [];
            foreach ($data_sql as $row) {


                $compositeKey = $row->Guía_de_Remisión . '|' . $row->SKU . '|' . $row->Empresa;

                if (isset($mysqlRecordsSet[$compositeKey])) {
                    // Verificar si el valor de "enviado" ha cambiado
                    $enviadoActual = (int) $row->Enviado;
                    $enviadoMysql = DB::table('tb_contabilidad')
                        ->where('guia_remision', $row->Guía_de_Remisión)
                        ->where('sku', $row->SKU)
                        ->where('empresa', $row->Empresa)
                        ->value('enviado');

                    if ($enviadoActual !== $enviadoMysql) {

                        // Solo actualizar si ha cambiado
                        $datosAActualizar[] = [
                            'guia_remision' => $row->Guía_de_Remisión,
                            'sku' => $row->SKU,
                            'empresa' => $row->Empresa,
                            'enviado' => $enviadoActual,
                        ];
                    }
                }
            }
            // Paso 4: Actualizar en MySQL
            $totalUpdated = 0; // Inicializar el contador
            if (!empty($datosAActualizar)) {

                foreach ($datosAActualizar as $dato) {
                    try {
                        DB::table('tb_contabilidad')
                            ->where('guia_remision', $dato['guia_remision'])
                            ->where('sku', $dato['sku'])
                            ->where('empresa', $dato['empresa'])
                            ->update([
                                'enviado' => $dato['enviado'],
                            ]);
                        $totalUpdated++;
                    } catch (\Exception $e) {
                        // Manejar errores específicos si es necesario
                    }
                }
            }
            // Actualizar configuración
            DB::table('tb_contabilidad_configuracion')
                ->where('tipo', 2)
                ->update([
                    'fecha_actualizacion' => now(),
                    'estado' => 1,
                    'cantidad_registros' => 0,
                ]);

            // Retornar el total de registros actualizados
            return $totalUpdated;
        } catch (\Exception $e) {
            throw new \Exception("Error al sincronizar datos: " . $e->getMessage());
        }
    }
}

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
        'alm_ln1',
        'alm_dsc',
        'alm_discotela',
        'alm_pb',
        'alm_fam',
        'enviado',
        'empresa',
        'alm_mad',
        'fecha_documento',
        'guia_remision',
    ];

    // Campos de timestamp automáticos
    public $timestamps = true;

    // Si necesitas formatear las fechas
    protected $casts = [
        'fecha_documento' => 'date',
        'costo_precio' => 'decimal:2',
    ];

    // Conexión a la base de datos de SQL Server

    // Función estática para obtener y insertar datos
    public static function obtenerYInsertarStock()
    {
        try {
            ini_set('max_execution_time', 180);
            $batchSize = 10;  // Definir tamaño de lote
            $offset = 0;       // Comenzamos con un offset de 0
            $totalInsertados = 0; // Para llevar cuenta de cuántos registros se insertan

            // Bucle para paginar los resultados
            while (true) {
                // 1. Consulta SQL con OFFSET y FETCH para obtener 100 registros
                $query = "
                SELECT 
                    s.Estilo,
                    s.Descripcion,
                    s.SKU,
                    s.Color,
                    s.Talla,
                    ISNULL(alm_discotela.STK, 0) AS [ALM_DISCOTELA],
                    ISNULL(alm_dsc.STK, 0) AS [ALM_DSC],
                    ISNULL(alm_ln1.STK, 0) AS [ALM_LN1],
                    ISNULL(alm_pb.STK, 0) AS [ALM_PB],
                    egr.CIA,
                    egr.Empresa,
                    egr.Base,
                    egr.Fecha_Documento,
                    egr.[Guía_de_Remisión],
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
                    (SELECT Estilo, Descripcion, Articulo AS SKU, Color, Talla FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local LIKE 'ALM%') s
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM DISCOTELA' GROUP BY Articulo) alm_discotela ON s.SKU = alm_discotela.SKU
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM DSC' GROUP BY Articulo) alm_dsc ON s.SKU = alm_dsc.SKU
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM LN1' GROUP BY Articulo) alm_ln1 ON s.SKU = alm_ln1.SKU
                LEFT JOIN 
                    (SELECT Articulo AS SKU, SUM(Stock_Total) AS STK FROM DBMSTR.dbo.SIG_Stock_x_Articulo WHERE Local = 'ALM PB' GROUP BY Articulo) alm_pb ON s.SKU = alm_pb.SKU
                LEFT JOIN 
                    (SELECT Estilo, Costo_Prom FROM DBMSTR.dbo.TABLA_PREC) c ON s.Estilo = c.Estilo
                LEFT JOIN 
                    (
                        SELECT 
                            CIA,
                            Barra AS SKU,
                            SUBSTRING(Origen_Destino, 1, CHARINDEX(' \ ', Origen_Destino) - 1) AS Empresa,
                            SUBSTRING(Origen_Destino, CHARINDEX(' \ ', Origen_Destino) + 2, LEN(Origen_Destino)) AS Base,
                            Fecha_Documento,
                            Referencia_1 AS [Guía_de_Remisión],
                            CASE 
                                WHEN CIA = 'LN1' THEN SUM(Salidas) 
                                ELSE 0 
                            END AS Enviado
                        FROM 
                            DBMSTR.dbo.A1KARDEX_TOTAL KX
                        LEFT JOIN 
                            DBMSTR.dbo.MAESTRO_PARA_30D MAE ON KX.Barra = MAE.SKU
                        WHERE 
                            Fecha_Documento >= '2024-01-01' 
                            AND motivo = '(24) -VENTAS ALMACEN'
                        GROUP BY 
                            CIA, Barra, 
                            SUBSTRING(Origen_Destino, 1, CHARINDEX(' \ ', Origen_Destino) - 1),
                            SUBSTRING(Origen_Destino, CHARINDEX(' \ ', Origen_Destino) + 2, LEN(Origen_Destino)),
                            Fecha_Documento, Referencia_1
                    ) egr ON s.SKU = egr.SKU
                WHERE 
                    egr.[Guía_de_Remisión] IS NOT NULL  -- Filtramos los registros con Guía_de_Remisión no nula
                ORDER BY s.SKU
                OFFSET $offset ROWS FETCH NEXT $batchSize ROWS ONLY;
                ";


                // 2. Ejecutar la consulta con paginación
                $resultados = DB::connection('sqlsrv_dbmsrt')->select($query);
                // dd($resultados);
                // 3. Si no hay más resultados, salir del bucle
                if (empty($resultados)) {
                    break;
                }

                // 4. Procesar los resultados
                // 4. Procesar los resultados
                $batch = []; // Inicializamos el arreglo de batch
                foreach ($resultados as $item) {
                    // Validar que 'Guía de Remisión' no sea null antes de insertar

                    // Validar que no exista un registro con los mismos "guia_remision", "sku" y "fecha_documento"
                    $existe = DB::table('tb_contabilidad')
                        ->where('guia_remision', $item->Guía_de_Remisión)
                        ->where('sku', $item->SKU)
                        ->where('fecha_documento', $item->Fecha_Documento)
                        ->exists();

                    if (!$existe) {
                        // Llenamos el batch con los datos
                        $batch[] = [
                            'estilo' => $item->Estilo,
                            'descripcion' => $item->Descripcion,
                            'sku' => $item->SKU,
                            'color' => $item->Color,
                            'talla' => $item->Talla,
                            'costo_precio' => $item->Costo_Prom,
                            'alm_dsc' => $item->ALM_DSC,
                            'enviado' => $item->Enviado,
                            'alm_ln1' => $item->ALM_LN1,
                            'empresa' => $item->Empresa ?? null,
                            'alm_discotela' => $item->ALM_DISCOTELA,
                            'alm_pb' => $item->ALM_PB,
                            'fecha_documento' => $item->Fecha_Documento ?? null,
                            'guia_remision' => $item->Guía_de_Remisión ?? null,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString(),
                            'base' => $item->Base ?? null
                        ];
                    }
                }
                // 5. Insertar los registros en la base de datos (insertar solo lo acumulado en $batch)
                if (!empty($batch)) {
                    DB::table('tb_contabilidad')->insert($batch);
                    $totalInsertados += count($batch);
                    // dd($totalInsertados);
                }
                // 6. Actualizar el offset para la siguiente página de resultados
                $offset += $batchSize;
            }

            return "Datos insertados exitosamente. Total de registros insertados: $totalInsertados";
        } catch (\Exception $e) {
            // Manejo de errores
            dd('Error al insertar los datos: ', $e->getMessage());
        }
    }


    public static function obtenerRegistros()
    {
        // Retorna todos los registros de la tabla sin los corchetes para SQL Server
        return self::all(); // Esta consulta devuelve todos los registros de la tabla tb_contabilidad
    }
}

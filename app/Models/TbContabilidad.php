<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TbContabilidad extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'tb_contabilidad';

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
        'alm_dsc',
        'alm_discot_ela',
        'alm_pb',
        'alm_fam',
        'alm_mad',
        'fecha_documento',
        'guia_remision',
    ];

    // Campos de timestamp automáticos
    public $timestamps = true;

    // Opcional: si necesitas formatear las fechas
    protected $casts = [
        'fecha_documento' => 'date',
        'costo_precio' => 'decimal:2',
    ];




    public static function transferData()
    {
        try {
            // Consulta a SQL Server
            $data = DB::connection('sqlsrv_dbmsrt')->select("
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
                    egr.Fecha_Documento,
                    egr.[Guía de Remisión],
                    ISNULL(c.Costo_Prom, 0) AS Costo_Prom
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
                            Fecha_Documento,
                            Referencia_1 AS [Guía de Remisión],
                            Barra AS SKU
                        FROM DBMSTR.dbo.A1KARDEX_TOTAL
                        WHERE Fecha_Documento >= '2024-01-01' AND motivo = '(24) -VENTAS ALMACEN'
                    ) egr ON s.SKU = egr.SKU
            ");

            // Inserción en MySQL
            foreach ($data as $row) {
                self::create([
                    'estilo' => $row->Estilo,
                    'color' => $row->Color,
                    'talla' => $row->Talla,
                    'sku' => $row->SKU,
                    'descripcion' => $row->Descripcion,
                    'costo_precio' => $row->Costo_Prom,
                    'alm_dsc' => $row->ALM_DSC,
                    'alm_discot_ela' => $row->ALM_DISCOTELA,
                    'alm_pb' => $row->ALM_PB,
                    'fecha_documento' => $row->Fecha_Documento,
                    'guia_remision' => $row->{'Guía de Remisión'},
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            return response()->json(['message' => 'Datos transferidos correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

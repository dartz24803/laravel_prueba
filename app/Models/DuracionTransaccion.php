<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DuracionTransaccion extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv_dbmsrt';
    protected $table = 'SIG_Tiempos_Atencion_Caja';

    public $timestamps = false; 

    protected $fillable = [
        'CodEmpresa',
        'CodLocal',
        'NombreBase',
        'NroCaja',
        'NomCajero',
        'IDCajero',
        'CodigoDocu',
        'NombreDocu',
        'SerieDocu',
        'NumeroDocu',
        'FechaDocu',
        'HoraInicio',
        'HoraFinal',
        'Cantidad',
        'DNI_Cajero'
    ];

    public static function get_list_duracion_transaccion($dato) 
    {
        $sql = "SELECT FechaDocu,FORMAT(FechaDocu,'dd-MM-yyyy') AS fecha,NombreBase,NomCajero,Cantidad,
                CONVERT(VARCHAR(8), HoraInicio, 108) AS hora_inicial,
                CONVERT(VARCHAR(8), HoraFinal, 108) AS hora_final, 
                DATEDIFF(MINUTE,HoraInicio,HoraFinal) AS diferencia,
                DATEDIFF(SECOND, HoraInicio, HoraFinal) / 60 AS min,
                DATEDIFF(SECOND, HoraInicio, HoraFinal) % 60 AS seg,
                DATEDIFF(MINUTE,HoraInicio,HoraFinal) as diferencia
                FROM SIG_Tiempos_Atencion_Caja 
                WHERE FechaDocu BETWEEN ? AND ?
                ORDER BY NombreBase ASC,FechaDocu ASC";
        $query = DB::connection('sqlsrv_dbmsrt')->select($sql, [$dato['fecha_inicio'],$dato['fecha_fin']]);
        return $query;
    }
}

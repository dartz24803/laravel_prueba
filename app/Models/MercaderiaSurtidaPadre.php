<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MercaderiaSurtidaPadre extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'mercaderia_surtida_padre';

    public $timestamps = false; 

    protected $fillable = [
        'base',
        'estilo',
        'fecha',
    ];

    public static function get_list_mercaderia_surtida_padre_vendedor($dato)
    {
        $sql = "SELECT mp.id,mp.estilo 
                FROM mercaderia_surtida_padre mp
                WHERE mp.base=? AND (SELECT COUNT(1) FROM mercaderia_surtida ms
                WHERE ms.id_padre=mp.id)>0";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base']]);
        return $query;
    }
}

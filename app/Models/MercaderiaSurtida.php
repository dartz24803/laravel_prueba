<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MercaderiaSurtida extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'mercaderia_surtida';

    public $timestamps = false; 

    protected $fillable = [
        'id_padre',
        'tipo',
        'base',
        'anio',
        'semana',
        'sku',
        'estilo',
        'tipo_usuario',
        'tipo_prenda',
        'color',
        'talla',
        'descripcion',
        'cantidad',
        'stk_almacen',
        'stk_tienda',
        'estado',
        'fecha',
        'usuario',
    ];

    public static function get_list_mercaderia_surtida($dato)
    {
        $sql = "SELECT ms.id,ms.sku,ms.color,ms.talla,
                (SELECT SUM(mn.Total) FROM vw_mercaderia_nueva mn
                WHERE mn.codigo_barra=ms.sku AND mn.id_base=?) AS cantidad,
                ms.cantidad AS requerimiento,ms.estilo,ms.tipo_usuario,ms.descripcion,
                ms.stk_almacen,ms.stk_tienda
                FROM mercaderia_surtida ms
                WHERE ms.tipo=1 AND ms.base=? AND ms.anio='".date('Y')."' AND
                ms.semana='".date('W')."' AND ms.estilo=? AND ms.estado=0";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base'],$dato['cod_base'],$dato['estilo']]);
        return $query;
    }

    public static function get_list_mercaderia_surtida_vendedor($dato)
    {
        $sql = "SELECT ms.id,ms.sku,ms.color,ms.talla,
                (SELECT SUM(mn.Total) FROM vw_mercaderia_nueva mn
                WHERE mn.codigo_barra=ms.sku AND mn.id_base=?) AS cantidad,
                ms.cantidad AS requerimiento,ms.estilo,ms.tipo_usuario,ms.descripcion,
                ms.stk_almacen,ms.stk_tienda,CASE WHEN ms.estado=0 THEN 'Pendiente'
                WHEN ms.estado=1 THEN 'Surtido' ELSE '' END AS nom_estado
                FROM mercaderia_surtida ms
                WHERE ms.tipo=1 AND ms.base=? AND ms.anio='".date('Y')."' AND
                ms.semana='".date('W')."' AND ms.estilo=?";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base'],$dato['cod_base'],$dato['estilo']]);
        return $query;
    }

    public static function get_list_requerimiento_reposicion_vendedor($dato=null)
    {
        if(isset($dato['id_padre'])){
            $sql = "SELECT id,sku,estilo,color,talla,descripcion,cantidad,stk_almacen,
                    stk_tienda,CASE WHEN estado=0 THEN 'Pendiente'
                    WHEN estado=1 THEN 'Surtido' ELSE '' END AS nom_estado
                    FROM mercaderia_surtida
                    WHERE id_padre=?";
            $query = DB::connection('sqlsrv')->select($sql, [$dato['id_padre']]);
        }else{
            $sql = "SELECT id,sku,estilo,color,talla,descripcion,cantidad,stk_almacen,
                    stk_tienda,CASE WHEN estado=0 THEN 'Pendiente'
                    WHEN estado=1 THEN 'Surtido' ELSE '' END AS nom_estado
                    FROM mercaderia_surtida
                    WHERE tipo=2 AND base=?";
            $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base']]);
        }
        return $query;
    }
}

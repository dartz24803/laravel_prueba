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
                ms.semana='".date('W')."' AND ms.estilo=? AND ms.estado=0
                ORDER BY ms.fecha DESC";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base'],$dato['cod_base'],$dato['estilo']]);
        return $query;
    }

    public static function get_list_merc_surt_vendedor($dato)
    {
        $sql = "SELECT ms.id,ms.sku,ms.color,ms.talla,
                (SELECT SUM(mn.Total) FROM vw_mercaderia_nueva mn
                WHERE mn.codigo_barra=ms.sku AND mn.id_base=?) AS cantidad,
                ms.cantidad AS requerimiento,ms.estilo,ms.tipo_usuario,ms.descripcion,
                ms.stk_almacen,ms.stk_tienda,CASE WHEN ms.estado=0 THEN 'Pendiente'
                WHEN ms.estado=1 THEN 'Surtido' ELSE '' END AS nom_estado
                FROM mercaderia_surtida ms
                WHERE ms.tipo=1 AND ms.base=? AND ms.anio='".date('Y')."' AND
                ms.semana='".date('W')."' AND ms.estilo=?
                ORDER BY ms.fecha DESC";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base'],$dato['cod_base'],$dato['estilo']]);
        return $query;
    }

    public static function get_list_tusu_merc_surt_vendedor($dato)
    {
        $sql = "SELECT tipo_usuario
                FROM mercaderia_surtida
                WHERE tipo=1 AND base=? AND anio='".date('Y')."' AND
                semana='".date('W')."' AND estilo=?
                GROUP BY tipo_usuario";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base'],$dato['estilo']]);
        return $query;
    }

    public static function get_list_tusu_req_repo($dato)
    {
        $sql = "SELECT tipo_usuario
                FROM mercaderia_surtida 
                WHERE tipo=3 AND base=? AND estado=0
                GROUP BY tipo_usuario";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base']]);
        return $query;
    }

    public static function get_list_req_repo_vend($dato=null)
    {
        if(isset($dato['id_padre'])){
            $sql = "SELECT id,sku,estilo,tipo_usuario,tipo_prenda,color,talla,descripcion,
                    cantidad,stk_almacen,stk_tienda,CASE WHEN estado=0 THEN 'Pendiente'
                    WHEN estado=1 THEN 'Surtido' ELSE '' END AS nom_estado
                    FROM mercaderia_surtida
                    WHERE id_padre=?
                    ORDER BY fecha DESC";
            $query = DB::connection('sqlsrv')->select($sql, [$dato['id_padre']]);
        }elseif(isset($dato['estilo'])){
            $parte = "";
            if(isset($dato['tipo_usuario']) && $dato['tipo_usuario']!="0"){
                $parte = "AND tipo_usuario=?";
            }
            $sql = "SELECT id_padre AS id,estilo,tipo_usuario
                    FROM mercaderia_surtida
                    WHERE tipo=3 AND base=? $parte
                    GROUP BY id_padre,estilo,tipo_usuario
                    ORDER BY id DESC";
            $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base'],$dato['tipo_usuario']]);        
        }else{
            $sql = "SELECT id,sku,estilo,tipo_usuario,tipo_prenda,color,talla,descripcion,
                    cantidad,stk_almacen,stk_tienda,CASE WHEN estado=0 THEN 'Pendiente'
                    WHEN estado=1 THEN 'Surtido' ELSE '' END AS nom_estado
                    FROM mercaderia_surtida
                    WHERE tipo=2 AND base=?
                    ORDER BY fecha DESC";
            $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base']]);
        }
        return $query;
    }

    public static function get_list_tusu_req_repo_vend($dato=null)
    {
        if(isset($dato['estilo'])){
            $sql = "SELECT tipo_usuario
                    FROM mercaderia_surtida
                    WHERE tipo=3 AND base=?
                    GROUP BY tipo_usuario";
            $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base']]);        
        }else{
            $sql = "SELECT tipo_usuario
                    FROM mercaderia_surtida
                    WHERE tipo=2 AND base=?
                    GROUP BY tipo_usuario";
            $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base']]);
        }
        return $query;
    }

    public static function get_list_req_repo_vend_x_est($dato)
    {
        $parte = "";
        if($dato['tipo_usuario']!="0"){
            $parte = "AND tipo_usuario=?";
        }
        $sql = "SELECT id_padre AS id,estilo,tipo_usuario
                FROM mercaderia_surtida
                WHERE tipo=3 AND base=? $parte AND estado=0
                GROUP BY id_padre,estilo,tipo_usuario
                ORDER BY id_padre DESC";
        $query = DB::connection('sqlsrv')->select($sql, [$dato['cod_base'],$dato['tipo_usuario']]);
        return $query;
    }
}

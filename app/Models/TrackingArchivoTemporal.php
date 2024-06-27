<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrackingArchivoTemporal extends Model
{
    use HasFactory;

    protected $table = 'tracking_archivo_temporal';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'tipo',
        'id_producto',
        'archivo'
    ];

    public static function get_list_tracking_archivo_temporal($dato){
        $id_usuario = session('usuario')->id_usuario;
        if(isset($dato['id'])){
            $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo
                    FROM tracking_archivo_temporal
                    WHERE id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }elseif(isset($dato['id_producto'])){
            $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo 
                    FROM tracking_archivo_temporal
                    WHERE id_usuario=$id_usuario AND id_producto=".$dato['id_producto'];
            $query = DB::select($sql);
            return $query;
        }else{
            $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo 
                    FROM tracking_archivo_temporal
                    WHERE id_usuario=$id_usuario AND tipo=".$dato['tipo'];
            $query = DB::select($sql);
            return $query;
        }
    }
}
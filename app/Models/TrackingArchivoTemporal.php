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
        'archivo'
    ];

    public static function get_list_tracking_archivo_temporal($id=null,$tipo=null){
        $id_usuario = session('usuario')->id;
        if(isset($id)){
            $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo
                    FROM tracking_archivo_temporal
                    WHERE id=$id";
            $query = DB::select($sql);
            return $query[0];
        }else{
            $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo 
                    FROM tracking_archivo_temporal
                    WHERE id_usuario=$id_usuario AND tipo=$tipo";
            $query = DB::select($sql);
            return $query;
        }
    }
}
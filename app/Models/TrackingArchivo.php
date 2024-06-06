<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrackingArchivo extends Model
{
    use HasFactory;

    protected $table = 'tracking_archivo';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'tipo',
        'archivo'
    ];

    public static function get_list_tracking_archivo($dato){
        $sql = "SELECT *,SUBSTRING_INDEX(archivo,'/',-1) AS nom_archivo
                FROM tracking_archivo
                WHERE id_tracking=".$dato['id_tracking']." AND tipo=".$dato['tipo'];
        $query = DB::select($sql);
        return $query[0];
    }
}

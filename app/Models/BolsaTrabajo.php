<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BolsaTrabajo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'bolsa_trabajo';

    protected $primaryKey = 'id_bolsa_trabajo';

    protected $fillable = [
        'cod_base',
        'orden',
        'url',
        'imagen',
        'publicado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_anuncio_intranet(){
        $sql = "SELECT id_bolsa_trabajo,cod_base,orden,url,CASE WHEN publicado=1 THEN 'Si'
        ELSE 'No' END AS publicado,imagen
        FROM bolsa_trabajo
        WHERE estado=1";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}

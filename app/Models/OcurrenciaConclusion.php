<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OcurrenciaConclusion extends Model
{
    use HasFactory;

    protected $table = 'conclusion';
    protected $primaryKey = 'id_conclusion';

    public $timestamps = false;

    protected $fillable = [
        'cod_conclusion',
        'nom_conclusion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'digitos'
    ];

    public static function get_list_conclusion()
    {
        $sql = "SELECT id_conclusion,nom_conclusion FROM conclusion
                ORDER BY nom_conclusion ASC";
        $query = DB::select($sql);
        return $query;
    }
}

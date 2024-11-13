<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subitem extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'subitem';

    // Llave primaria de la tabla
    protected $primaryKey = 'id_subitem';

    // Deshabilitar timestamps automáticos ya que la tabla no tiene las columnas por defecto
    public $timestamps = false;

    // Definir los atributos asignables
    protected $fillable = [
        'id_item',
        'nom_subitem',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    static function get_list_area_subitem($id_area){
        $sql = "SELECT su.id_subitem,su.nom_subitem 
                FROM subitem su
                LEFT JOIN item it ON it.id_item=su.id_item
                WHERE it.id_area=$id_area AND su.estado=1";
                
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}

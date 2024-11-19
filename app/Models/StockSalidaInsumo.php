<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StockSalidaInsumo extends Model
{
    use HasFactory;

    protected $table = 'stock_salida_insumo';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'nom_insumo', 
        'total'
    ];

    public static function get_list_stock_salida_insumo()
    {
        if(session('usuario')->id_puesto=="31" || session('usuario')->id_puesto=="32" || session('usuario')->id_puesto==314){
            $parte = "cod_base='".session('usuario')->centro_labores."' AND";
        }else{
            $parte = "";
        }
        $sql = "SELECT * FROM stock_salida_insumo 
                WHERE $parte cod_base NOT IN ('B13', 'B14')";
        $query = DB::select($sql);
        return $query;
    }
}

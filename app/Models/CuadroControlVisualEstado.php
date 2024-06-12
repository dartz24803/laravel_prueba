<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CuadroControlVisualEstado extends Model
{
    use HasFactory;

    protected $table = 'cuadro_control_visual_estado';

    protected $fillable = [
        'id_usuario',
        'estado',
        'fec_reg',
        'user_reg',
    ];
    
    function validar_presente($id_usuario){
        $sql = "SELECT COUNT(*) AS contador FROM cuadro_control_visual_estado WHERE estado = 1 AND id_usuario = $id_usuario AND DATE(fec_reg) = CURDATE();";
        $result = DB::select($sql);
        if (!empty($result)) {
            // Accede al primer elemento del array y luego al campo 'contador'
            return $result[0]->contador + 1;
        } else {
            return 0;
        }
    }
}

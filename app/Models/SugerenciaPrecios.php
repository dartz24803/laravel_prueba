<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SugerenciaPrecios extends Model
{
    use HasFactory;

    // Tabla asociada al modelo
    protected $table = 'requerimiento_prenda_detalle';

    // Clave primaria
    protected $primaryKey = 'id_requerimientod';

    // La clave primaria es auto-incrementable
    public $incrementing = true;

    // El modelo no usa timestamps por defecto
    public $timestamps = false;

    // Campos asignables en masa
    protected $fillable = [
        'id_requerimiento',
        'codigo',
        'empresa',
        'costo',
        'pc',
        'pv',
        'pp',
        'pc_b4',
        'pv_b4',
        'pp_b4',
        'tipo_usuario',
        'tipo_prenda',
        'autogenerado',
        'estilo',
        'descripcion',
        'color',
        'talla',
        'total',
        'OBS',
        'stock',
        'B01',
        'B02',
        'B03',
        'B04',
        'B05',
        'B06',
        'B07',
        'B08',
        'B09',
        'B10',
        'B11',
        'B12',
        'B13',
        'B14',
        'B15',
        'B16',
        'B17',
        'B18',
        'BEC',
        'REQ',
        'OFC',
        'anio',
        'mes',
        'ubicacion',
        'observacion',
        'cantidad_envio',
        'estado_requerimiento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    // Especificar los campos de fecha
    protected $dates = ['fec_reg', 'fec_act', 'fec_eli'];

    static function get_list_sugerencia_precio_modulo($dato)
    {
        $parte_base = "";
        if ($dato['base'] != "0") {
            $parte_base = "AND RIGHT(sp.cod_base,3) = :base";
        }

        $parte_categoria = "";

        $sql = "SELECT 
                RIGHT(sp.cod_base,3) AS cod_base, 
                '' AS categoria, 
                sp.estilo, 
                sp.precio_vigente, 
                sp.precio_sug, 
                sp.precio_sug_2x, 
                sp.precio_sug_3x, 
                cp.nom_comentario_precios AS motivo, 
                '' AS comentario
            FROM sugerencia_precios sp
            LEFT JOIN comentario_precios cp 
                ON sp.id_comentario_precios = cp.id_comentario_precios
            WHERE sp.id_sugerencia_precios > 0 
            $parte_base 
            $parte_categoria";

        $params = [];
        if ($dato['base'] != "0") {
            $params['base'] = $dato['base'];
        }

        $query = DB::select($sql, $params);
        return $query;
    }
}

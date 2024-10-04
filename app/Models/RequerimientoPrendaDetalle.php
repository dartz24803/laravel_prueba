<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequerimientoPrendaDetalle extends Model
{
    use HasFactory;

    // Especifica la tabla asociada al modelo
    protected $table = 'requerimiento_prenda_detalle';

    // Especifica la clave primaria
    protected $primaryKey = 'id_requerimientod';

    // Si la clave primaria no es auto-incrementable
    public $incrementing = true;

    // Especifica si el modelo debe manejar marcas de tiempo
    public $timestamps = true;

    // Define los campos que son asignables en masa
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

    // Si tienes campos de fecha que necesitas para la conversión automática, puedes especificarlos aquí
    protected $dates = [
        'fec_reg',
        'fec_act',
        'fec_eli',
    ];

    static public function getListRequerimientoPrenda($dato)
    {

        $sql = "SELECT c.id_requerimientod, c.codigo, c.tipo_usuario, c.estilo, 
                    c.descripcion, c.color, c.talla, c.OFC AS cant_solicitado,
                    CASE WHEN m.cantidad IS NULL THEN '0' ELSE m.cantidad END AS empaquetado,
                    CASE WHEN m.cantidad IS NULL THEN c.OFC ELSE c.OFC - m.cantidad END AS saldo,
                    CASE 
                        WHEN c.estado_requerimiento = 1 THEN 'Solicitado'
                        WHEN c.estado_requerimiento = 2 THEN 'Empaquetado'
                        WHEN c.estado_requerimiento = 3 THEN 'Enviado a Oficina'
                        WHEN c.estado_requerimiento = 4 THEN 'Foto Tomada' 
                    END AS desc_estado_requerimiento,
                    c.estado_requerimiento, m.observacion, m.observacion_validaf, m.foto,
                    '0' AS nuevo, c.observacion AS obs_comercial, m.observacion AS obs_logistica,
                    c.ubicacion
                    FROM requerimiento_prenda_detalle c
                    LEFT JOIN mercaderia_fotografia m ON c.codigo = m.codigo 
                    AND c.mes = '" . $dato['mes'] . "' AND c.anio = '" . $dato['anio'] . "'
                    WHERE c.estado = 1 AND c.mes = '" . $dato['mes'] . "' AND c.anio = '" . $dato['anio'] . "'";

        // Ejecutar la consulta y obtener resultados
        $query = DB::select($sql);
        return $query;
    }
}

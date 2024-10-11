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
    public $timestamps = false;

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

        $query = DB::select($sql);
        return $query;
    }


    static function delete_requerimiento_temporal()
    {
        $id_usuario = session('usuario')->id_usuario;

        $sql = "DELETE FROM requerimiento_temporal WHERE user_reg=$id_usuario";
        DB::statement($sql);
    }


    static function valida_mercaderia_fotografia($dato)
    {
        $query = DB::table('requerimiento_prenda_detalle')
            ->where('codigo', $dato['codigo'])
            ->where('mes', $dato['mes'])
            ->where('anio', $dato['anio'])
            ->where('estado', 1)
            ->where('estado_requerimiento', 1)
            ->get()
            ->toArray();

        return $query;
    }

    static function insert_mercaderia_fotografia_temporal($dato)
    {
        $id_usuario = session('usuario')->id_usuario;

        DB::table('requerimiento_temporal')->insert([
            'codigo'       => $dato['codigo'],
            'tipo_usuario' => $dato['usuario'],
            'estilo'       => $dato['estilo'],
            'descripcion'  => $dato['descripcion'],
            'color'        => $dato['color'],
            'talla'        => $dato['talla'],
            'stock'        => $dato['cantidad'],
            'ubicacion'    => $dato['ubicacion'],
            'observacion'  => $dato['observacion'],
            'mes'          => 0,
            'anio'         => $dato['anio'],
            'duplicado'    => $dato['duplicado'],
            'user_reg'     => $id_usuario,
            'estado'       => 1,
            'fec_reg'      => now(),  // Usamos `now()` para obtener la fecha y hora actual en Laravel
            'pv_b4' => 0,
            'tipo_prenda' => 0,
            'autogenerado' => 0,
            'total' => 0,
            'OBS' => 0,
            'stock' => 0,
            'B01' => 0,
            'B02' => 0,
            'B03' => 0,
            'B04' => 0,
            'B05' => 0,
            'B06' => 0,
            'B07' => 0,
            'B08' => 0,
            'B09' => 0,
            'B10' => 0,
            'B11' => 0,
            'B12' => 0,
            'B13' => 0,
            'B14' => 0,
            'B15' => 0,
            'B16' => 0,
            'B17' => 0,
            'B18' => 0,
            'BEC' => 0,
            'REQ' => 0,
            'OFC' => 0,
            'caracter' => 0,
        ]);
    }

    static function get_list_mercaderia_fotografia()
    {
        $id_usuario = session('usuario')->id_usuario;

        $query = DB::table('requerimiento_temporal as t')
            ->select(
                't.*',
                DB::raw("CASE WHEN t.duplicado = 0 THEN 'No Encontrado' WHEN t.caracter != '' THEN t.caracter END as observacion")
            )
            ->where(function ($query) use ($id_usuario) {
                $query->where('t.user_reg', $id_usuario)
                    ->where('t.estado', 1)
                    ->where('t.duplicado', 1);
            })
            ->orWhere(function ($query) use ($id_usuario) {
                $query->where('t.user_reg', $id_usuario)
                    ->where('t.estado', 1)
                    ->whereNull('t.caracter');
            })
            ->get()
            ->toArray();

        return $query;
    }

    static function update_mercaderia_fotografia($dato)
    {
        $id_usuario = session('usuario')->id_usuario;

        DB::table('requerimiento_prenda_detalle')
            ->where('codigo', $dato['codigo'])
            ->where('mes', $dato['mes'])
            ->where('anio', $dato['anio'])
            ->where('estado', 1)
            ->where('estado_requerimiento', 1)
            ->update([
                'estado_requerimiento' => 2,
                'user_act' => $id_usuario,
                'fec_act' => now(),  // Usamos `now()` para obtener la fecha actual
            ]);
    }

    static function insert_mercaderia_fotografia($dato)
    {
        $id_usuario = session('usuario')->id_usuario;

        // Primera inserción: stock > 0
        DB::insert("
        INSERT INTO mercaderia_fotografia (observacion_validaf, foto, user_validaf, codigo, usuario, estilo, descripcion, color, talla, cantidad, ubicacion, observacion, mes, anio, estado_requerimiento, estado, fec_reg, user_reg)
        SELECT 0, 0, 0, codigo, tipo_usuario, estilo, descripcion, color, talla, stock, ubicacion, observacion, mes, anio, 2, 1, NOW(), ?
        FROM requerimiento_temporal
        WHERE user_reg = ? AND estado = 1 AND stock > 0
    ", [$id_usuario, $id_usuario]);

        // Segunda inserción: stock = 0
        DB::insert("
        INSERT INTO mercaderia_fotografia (estado_requerimiento, observacion_validaf, foto, user_validaf, codigo, usuario, estilo, descripcion, color, talla, cantidad, ubicacion, observacion, mes, anio, estado, fec_reg, user_reg)
        SELECT 0, 0, 0, 0, codigo, tipo_usuario, estilo, descripcion, color, talla, stock, ubicacion, observacion, mes, anio, 1, NOW(), ?
        FROM requerimiento_temporal
        WHERE user_reg = ? AND estado = 1 AND stock = 0
    ", [$id_usuario, $id_usuario]);
    }

    static function correos_logistica_surtido()
    {
        return DB::table('users')
            ->where('id_puesto', 76)
            ->where('estado', 1)
            ->get()
            ->toArray(); // Si necesitas el resultado en forma de array
    }

    static function get_id_requerimiento_prenda($codigo, $anio, $mes)
    {
        $query = DB::table('requerimiento_prenda_detalle as d')
            ->select('d.*')
            ->where('d.codigo', $codigo)
            ->where('d.mes', $mes)
            ->where('d.anio', $anio)
            ->where('d.estado', 1)
            ->get()
            ->toArray();

        return $query;
    }

    static function get_id_mercaderia_fotografia($codigo, $anio, $mes)
    {
        $query = DB::table('mercaderia_fotografia as d')
            ->select('d.*')
            ->where('d.codigo', $codigo)
            ->where('d.anio', $anio)
            ->where('d.mes', $mes)
            ->where('d.estado', 1)
            ->get()
            ->toArray();

        return $query;
    }

    static function enviar_oficina_requerimiento_prenda($dato)
    {
        $id_usuario = session('usuario.0.id_usuario'); // Obtener el id_usuario desde la sesión

        if (count($dato['get_req']) > 0) {
            DB::table('requerimiento_prenda_detalle')
                ->where('id_requerimientod', $dato['get_req'][0]['id_requerimientod'])
                ->update([
                    'estado_requerimiento' => 3,
                    'user_act' => $id_usuario,
                    'fec_act' => now(), // Utilizar la función now() de Laravel
                ]);
        }

        if (count($dato['get_mer']) > 0) {
            DB::table('mercaderia_fotografia')
                ->where('id_mercaderia', $dato['get_mer'][0]['id_mercaderia'])
                ->update([
                    'estado_requerimiento' => 3,
                    'user_act' => $id_usuario,
                    'fec_act' => now(), // Utilizar la función now() de Laravel
                ]);
        }
    }

    static function delete_todo_mercaderia_fotografia($dato)
    {
        $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

        if (count($dato['get_req']) > 0) {
            $sql = "UPDATE requerimiento_prenda_detalle
                    SET estado_requerimiento = 1, user_act = $id_usuario, fec_act = NOW()
                    WHERE id_requerimientod = " . $dato['get_req'][0]['id_requerimientod'];
            DB::statement($sql);
        }

        if (count($dato['get_id']) > 0) {
            $sql = "UPDATE mercaderia_fotografia
                    SET estado = 2, user_eli = $id_usuario, fec_eli = NOW()
                    WHERE id_mercaderia = " . $dato['get_id'][0]['id_mercaderia'];
            DB::statement($sql);
        }
    }

    static function get_list_requerimiento_prenda($dato)
    {
        if ($dato['mod'] == 1) {
            $sql = "select c.id_requerimientod, c.codigo,c.tipo_usuario,c.estilo,c.descripcion,c.color,c.talla,c.OFC as cant_solicitado,
                    CASE WHEN m.cantidad is null THEN '0' ELSE m.cantidad END AS empaquetado,
                    CASE WHEN m.cantidad is null THEN c.OFC ELSE c.OFC-m.cantidad END AS saldo,
                    case when c.estado_requerimiento=1 then 'Solicitado'
                    when c.estado_requerimiento=2 then 'Empaquetado'
                    when c.estado_requerimiento=3 then 'Enviado a Oficina'
                    when c.estado_requerimiento=4 then 'Foto Tomada' end as desc_estado_requerimiento,
                    c.estado_requerimiento,m.observacion,m.observacion_validaf,m.foto,'0' as nuevo,
                    c.observacion as obs_comercial, m.observacion as obs_logistica,c.ubicacion
                    from requerimiento_prenda_detalle c
                    left JOIN mercaderia_fotografia m on c.codigo=m.codigo and
                    c.mes=m.mes AND c.anio=m.anio
                    where c.estado=1 and c.mes='" . $dato['mes'] . "' and c.anio='" . $dato['anio'] . "'";
        } else {
            $estado1 = "";
            $estado2 = "";
            if ($dato['estadoi'] == 1) {
                $estado1 = " and c.estado_requerimiento=3";
                $estado2 = " and l.estado_requerimiento=3";
            }
            if ($dato['estadoi'] == 2) {
                $estado1 = " and c.estado_requerimiento=4";
                $estado2 = " and l.estado_requerimiento=4";
            }
            $sql = "SELECT l.id_mercaderia, l.codigo,l.usuario,l.estilo,l.descripcion,l.color,l.talla,
                    CASE WHEN r.OFC is null THEN '0' ELSE r.OFC end as cant_solicitado,l.cantidad as empaquetado,
                    CASE WHEN r.estado_requerimiento is null THEN '0' ELSE r.OFC-l.cantidad END AS saldo,
                    CASE WHEN r.estado_requerimiento is null THEN (
                    case when l.estado_requerimiento=1 then 'Solicitado'
                    when l.estado_requerimiento=2 then 'Empaquetado'
                    when l.estado_requerimiento=3 then 'Por Tomar Fotografía'
                    when l.estado_requerimiento=4 then 'Foto Tomada' END) else (
                    case when r.estado_requerimiento=1 then 'Solicitado'
                    when r.estado_requerimiento=2 then 'Empaquetado'
                    when r.estado_requerimiento=3 then 'Por Tomar Fotografía'
                    when r.estado_requerimiento=4 then 'Foto Tomada' END) end as desc_estado_requerimiento,
                    CASE WHEN r.estado_requerimiento is null THEN l.estado_requerimiento ELSE r.estado_requerimiento end as estado_requerimiento,l.observacion,l.observacion_validaf,l.foto,
                    CASE WHEN r.estado_requerimiento is null THEN '1' ELSE '0' end as nuevo
                    FROM mercaderia_fotografia l
                    left JOIN requerimiento_prenda_detalle r on l.codigo=r.codigo and l.mes=r.mes and l.anio=r.anio and r.estado=1
                    where r.estado=1 AND l.estado=1 AND l.mes='" . $dato['mes'] . "' and l.anio='" . $dato['anio'] . "' $estado2)";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}

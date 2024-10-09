<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventario extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'inventario';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_inventario';

    // Deshabilitar timestamps automáticos (created_at, updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar de manera masiva
    protected $fillable = [
        'cod_inventario',
        'fecha',
        'base',
        'id_responsable',
        'conteo',
        'stock',
        'diferencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    // Los campos que serán tratados como fechas
    protected $dates = [
        'fecha',
        'fec_reg',
        'fec_act',
        'fec_eli'
    ];

    // Relación con el usuario responsable (asumiendo que tienes un modelo Usuario)
    public function responsable()
    {
        return $this->belongsTo(User::class, 'id_responsable', 'id');
    }


    public static function get_list_inventario()
    {
        $sql = "SELECT a.*, 
                       DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha, 
                       b.usuario_nombres, 
                       b.usuario_apater, 
                       b.usuario_amater,
                       COALESCE(SUM(c.conteo), 0) AS conteo,
                       COALESCE(SUM(c.stock), 0) AS stock,
                       COALESCE(SUM(c.diferencia), 0) AS diferencia
                FROM inventario a
                LEFT JOIN users b ON a.id_responsable = b.id_usuario
                LEFT JOIN inventario_detalle c ON c.id_inventario = a.id_inventario AND c.estado = 1
                WHERE a.estado = 1
                GROUP BY a.id_inventario, a.cod_inventario, a.fecha, a.base, a.id_responsable, 
                         a.conteo, a.stock, a.diferencia, a.estado, a.fec_reg, a.user_reg, 
                         a.fec_act, a.user_act, a.fec_eli, a.user_eli, 
                         b.usuario_nombres, b.usuario_apater, b.usuario_amater";

        $query = DB::select($sql);
        return $query;
    }

    static function elimina_carga_inventario_temporal()
    {
        $id_usuario =  session('usuario')->id_usuario;

        $sql = "DELETE FROM inventario_detalle_temporal WHERE user_reg = '$id_usuario'";
        DB::statement($sql);
    }

    static function valida_carga_inventario($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = " AND id_inventario != '" . $dato['id_inventario'] . "'";
        }

        $sql = "SELECT * FROM inventario WHERE estado = 1 AND fecha = '" . $dato['fecha'] . "' AND base = '" . $dato['base'] . "' AND id_responsable = '" . $dato['id_responsable'] . "' $v";

        $query = DB::select($sql); // Cambia esto si utilizas un método diferente para ejecutar la consulta
        return $query;
    }

    static function insert_carga_inventario_temporal($dato)
    {
        $id_usuario =  session('usuario')->id_usuario;

        $sql = "INSERT INTO inventario_detalle_temporal (categoria, familia, ubicacion, barra, estilo, generico, color, talla, linea, tipo_prenda, usuario, marca, tela, descripcion, unidad, fecha_creacion, conteo, stock, diferencia, valor, poriginal, pventa, costo, validacion, caracter,
    estado, user_reg, fec_reg) VALUES 
            ('" . $dato['categoria'] . "', '" . $dato['familia'] . "', '" . $dato['ubicacion'] . "',
            '" . $dato['barra'] . "', '" . $dato['estilo'] . "', '" . $dato['generico'] . "', '" . $dato['color'] . "', '" . $dato['talla'] . "', '" . $dato['linea'] . "', '" . $dato['tipo_prenda'] . "', '" . $dato['usuario'] . "', '" . $dato['marca'] . "', '" . $dato['tela'] . "', '" . $dato['descripcion'] . "', '" . $dato['unidad'] . "', '" . $dato['fcreacion'] . "', '" . $dato['conteo'] . "', '" . $dato['stock'] . "', '" . $dato['diferencia'] . "', '" . $dato['valor'] . "', '" . $dato['poriginal'] . "', '" . $dato['pventa'] . "', '" . $dato['costo'] . "', '" . $dato['validacion'] . "', '" . $dato['caracter'] . "',
            '1', '$id_usuario', NOW())";

        // Suponiendo que DB es el acceso estático a la base de datos
        DB::statement($sql);
    }

    static function cont_carga_inventario()
    {
        $sql = "SELECT * FROM inventario";
        $query = DB::select($sql);
        return $query;
    }

    static function update_carga_inventario($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        $path = request()->file('archivoe')->getRealPath(); // Obtener el path del archivo

        // Actualizar la tabla inventario
        $sql = "UPDATE inventario 
            SET fecha = '" . $dato['fecha'] . "', 
                base = '" . $dato['base'] . "', 
                id_responsable = '" . $dato['id_responsable'] . "', 
                user_act = '$id_usuario', 
                fec_act = NOW()  
            WHERE id_inventario = '" . $dato['id_inventario'] . "'";
        DB::statement($sql);

        if ($path != "") {
            // Marcar los registros del inventario_detalle como eliminados
            $sql = "UPDATE inventario_detalle 
                SET estado = '2', 
                    user_eli = '$id_usuario', 
                    fec_eli = NOW()  
                WHERE id_inventario = '" . $dato['id_inventario'] . "'";
            DB::statement($sql);

            // Insertar los detalles del inventario desde inventario_detalle_temporal
            $sql = "INSERT INTO inventario_detalle (id_inventario, categoria, familia, ubicacion, barra, estilo, generico, color, talla, linea, tipo_prenda, usuario, marca, tela, descripcion, unidad, fecha_creacion, conteo, stock, diferencia, valor, poriginal, pventa, costo, validacion, estado, user_reg, fec_reg) 
                SELECT (SELECT id_inventario 
                        FROM inventario 
                        WHERE cod_inventario = '" . $dato['cod_inventario'] . "' 
                          AND estado = 1), 
                       categoria, familia, ubicacion, barra, estilo, generico, color, talla, linea, tipo_prenda, usuario, marca, tela, descripcion, unidad, fecha_creacion, conteo, stock, diferencia, valor, poriginal, pventa, costo, validacion, 
                       '1', '$id_usuario', NOW() 
                FROM inventario_detalle_temporal 
                WHERE estado = 1 
                  AND caracter = '' 
                  AND user_reg = '$id_usuario'";
            DB::statement($sql);
        }
    }

    static function busca_carga_inventario($id_inventario = null)
    {
        if (isset($id_inventario) && $id_inventario > 0) {
            $sql = "SELECT a.*,
                COALESCE(SUM(c.conteo), 0) AS conteo,
                COALESCE(SUM(c.stock), 0) AS stock,
                COALESCE(SUM(c.diferencia), 0) AS diferencia
            FROM inventario a
            LEFT JOIN inventario_detalle c ON c.id_inventario = a.id_inventario AND c.estado = 1
            WHERE a.id_inventario = $id_inventario
            GROUP BY a.id_inventario";
        } else {
            $sql = "SELECT a.*, 
                DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha, 
                b.usuario_nombres, 
                b.usuario_apater, 
                b.usuario_amater,
                COALESCE(SUM(c.conteo), 0) AS conteo,
                COALESCE(SUM(c.stock), 0) AS stock,
                COALESCE(SUM(c.diferencia), 0) AS diferencia
            FROM inventario a
            LEFT JOIN users b ON a.id_responsable = b.id_usuario
            LEFT JOIN inventario_detalle c ON c.id_inventario = a.id_inventario AND c.estado = 1
            WHERE a.estado = 1
            GROUP BY a.id_inventario";
        }

        $query = DB::select(DB::raw($sql));
        return $query;
    }

    static function delete_carga_inventario($id)
    {
        $id_usuario = session('usuario')->id_usuario;

        // Actualizar el estado del inventario
        $sql = "UPDATE inventario 
            SET estado = '2', 
                user_eli = '$id_usuario', 
                fec_eli = NOW() 
            WHERE id_inventario = :id_inventario";

        DB::update($sql, ['id_inventario' => $id]);

        // Actualizar el estado del inventario_detalle
        $sql = "UPDATE inventario_detalle 
            SET estado = '2', 
                user_eli = '$id_usuario', 
                fec_eli = NOW() 
            WHERE id_inventario = :id_inventario 
            AND estado = 1";

        DB::update($sql, ['id_inventario' => $id]);
    }
}

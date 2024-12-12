<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SedeLaboral extends Model
{
    use HasFactory;

    protected $table = 'sede_laboral';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function obtenerIdSede()
    {
        // Obtener el id_usuario de la sesión
        $idUsuario = session('usuario')->id_usuario;
        // dd($idUsuario);
        // Realizar la consulta con el leftJoin
        $resultado = DB::table('users')
            ->where('id_usuario', $idUsuario)
            ->leftJoin('ubicacion', 'users.id_centro_labor', '=', 'ubicacion.id_ubicacion')
            ->select('ubicacion.id_sede')
            ->first();

        // Retornar el cod_ubi si existe
        return $resultado ? $resultado->id_sede : null;
    }



    public static function validateListSedeLaboral()
    {
        // Obtener el id_usuario de la sesión
        $idUsuario = session('usuario')->id_usuario;

        // Validar si id_nivel es igual a 1
        $idNivel = DB::table('users')
            ->where('id_usuario', $idUsuario)
            ->value('id_nivel');

        return $idNivel === 1;
    }

    public static function getAllUbicaciones()
    {
        // Obtener todas las ubicaciones con columnas específicas, omitir estado = 1 y ciertos id_ubicacion
        $ubicaciones = DB::table('ubicacion')
            ->select('id_ubicacion', 'cod_ubi', 'id_sede', 'estado') // Columnas requeridas
            ->where('estado', '=', 1) // Excluir registros donde estado = 1
            ->whereNotIn('id_ubicacion', [20, 25, 26, 28, 29, 30]) // Excluir ciertos id_ubicacion
            ->get();

        // Retornar el resultado
        return $ubicaciones;
    }
}

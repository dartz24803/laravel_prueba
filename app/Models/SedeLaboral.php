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

        // Realizar el JOIN con la tabla puesto para obtener el id_area
        $resultado = DB::table('users')
            ->join('puesto', 'users.id_puesto', '=', 'puesto.id_puesto') // JOIN con la tabla puesto
            ->where('users.id_usuario', $idUsuario)
            ->value('puesto.id_area'); // Obtener el valor de id_area desde la tabla puesto

        // Verificar si id_area contiene los valores esperados
        $valoresPermitidos = [10, 18, 25];
        return in_array($resultado, $valoresPermitidos);
    }

    public static function getAllSedesLaborales()
    {
        // Obtener todas las sedes laborales con columnas específicas
        $sedesLaborales = DB::table('sede_laboral')
            ->select('id', 'descripcion', 'estado') // Aquí defines las columnas que necesitas
            ->get();

        // Retornar el resultado
        return $sedesLaborales;
    }
}

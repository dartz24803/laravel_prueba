<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    use HasFactory;

    protected $table = 'soporte';

    public $timestamps = false;

    protected $primaryKey = 'id_soporte';

    protected $fillable = [
        'id_especialidad',
        'id_area',
        'id_elemento',
        'id_asunto',
        'id_sede',
        'idsoporte_ubicacion',
        'idsoporte_ubicacion2',
        'fec_vencimiento',
        'descripcion',
        'estado',
        'estado_registro',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'

    ];

    public static function listTicketsSoporte()
    {
        return self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_ubicacion1.nombre as nombre_ubicacion',
            'soporte_ubicacion2.nombre as nombre_ubicacion2',
            'area.nom_area as nombre_area',
            'users.usuario_nombres as usuario_nombre'


        )
            ->leftjoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftjoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftjoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftjoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftjoin('soporte_ubicacion1', 'soporte.idsoporte_ubicacion', '=', 'soporte_ubicacion1.idsoporte_ubicacion1')
            ->leftjoin('soporte_ubicacion2', 'soporte.idsoporte_ubicacion2', '=', 'soporte_ubicacion2.idsoporte_ubicacion2')
            ->leftjoin('area', 'soporte.id_area', '=', 'area.id_area')
            ->leftjoin('users', 'soporte.user_reg', '=', 'users.id_usuario')

            ->where('soporte.estado', 1)
            ->get();
    }
}

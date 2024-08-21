<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProveedorGeneral extends Model
{
    use HasFactory;

    protected $table = 'proveedor_general';
    protected $primaryKey = 'id_proveedor';

    public $timestamps = false;

    protected $fillable = [
        'id_proveedor_mae',
        'tipo_proveedor',
        'codigo_proveedor',
        'nombre_proveedor',
        'ruc_proveedor',
        'direccion_proveedor',
        'departamento',
        'provincia',
        'distrito',
        'ubigeo',
        'telefono_proveedor',
        'celular_proveedor',
        'email_proveedor',

        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
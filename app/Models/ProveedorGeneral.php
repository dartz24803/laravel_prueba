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
        'web_proveedor',
        'contacto_proveedor',
        'proveedor_codigo',
        'proveedor_password',
        'id_area',
        'id_banco',
        'num_cuenta',
        'id_departamento',
        'id_provincia',
        'id_distrito',
        'referencia_proveedor',
        'id_tipo_servicio',
        'coordsltd',
        'coordslgt',
        'responsable',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
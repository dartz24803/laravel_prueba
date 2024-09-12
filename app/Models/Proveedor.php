<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';

    public $timestamps = false;

    protected $fillable = [
        'tipo',
        'nom_proveedor',
        'ruc_proveedor',
        'direccion_proveedor',
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
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}

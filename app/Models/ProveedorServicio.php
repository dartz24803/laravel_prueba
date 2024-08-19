<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorServicio extends Model
{
    use HasFactory;

    protected $table = 'proveedor_servicio';
    protected $primaryKey = 'id_proveedor_servicio';

    public $timestamps = false;

    protected $fillable = [
        'cod_proveedor_servicio',
        'nom_proveedor_servicio',
        'ruc_proveedor_servicio',
        'dir_proveedor_servicio',
        'tel_proveedor_servicio',
        'contacto_proveedor_servicio',
        'telefono_contacto',
        'cod_base',
        'id_servicio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambioPrendaDetalle extends Model
{
    use HasFactory;

    protected $table = 'cambio_prenda_detalle';
    protected $primaryKey = 'id_detalle';

    public $timestamps = false;

    protected $fillable = [
        'id_cambio_prenda',
        'n_codi_arti',
        'n_cant_vent',
        'c_arti_desc',
        'color',
        'talla'
    ];
}

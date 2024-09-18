<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    use HasFactory;

    protected $table = 'vw_tipo_comprobante';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'nom_tipo_comprobante'
    ];
}

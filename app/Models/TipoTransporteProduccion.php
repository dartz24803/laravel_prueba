<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTransporteProduccion extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla
    protected $table = 'tipo_transporte_produccion';

    // Define la clave primaria
    protected $primaryKey = 'id_tipo_transporte';

    // Indica que el ID es autoincrementable
    public $incrementing = true;

    // Indica el tipo de clave primaria
    protected $keyType = 'int';

    // Indica que no se usará el manejo automático de timestamps (created_at y updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nom_tipo_transporte',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    // Campos que se deben cast a tipos específicos
    protected $casts = [
        'fec_reg' => 'datetime',
        'fec_act' => 'datetime',
        'fec_eli' => 'datetime',
    ];
}

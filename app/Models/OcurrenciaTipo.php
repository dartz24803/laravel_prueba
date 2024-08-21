<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OcurrenciaTipo extends Model
{
    use HasFactory;

    protected $table = 'tipo_ocurrencia';
    protected $primaryKey = 'id_tipo_ocurrencia';

    public $timestamps = false;

    protected $fillable = [
        'cod_tipo_ocurrencia',
        'nom_tipo_ocurrencia',
        'id_conclusion',
        'tipo_mae',
        'base',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'digitos'
    ];

    // Define the relationship to OcurrenciaConclusion
    public function conclusion()
    {
        return $this->belongsTo(OcurrenciaConclusion::class, 'id_conclusion', 'id_conclusion');
    }


}

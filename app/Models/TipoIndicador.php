<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIndicador extends Model
{
    use HasFactory;

    protected $table = 'tipo_indicador';
    protected $primaryKey = 'idtipo_indicador';

    public $timestamps = false;

    protected $fillable = [
        'nom_indicador',
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    // Puedes agregar métodos personalizados si es necesario
    public function getAllActive()
    {
        return $this->whereNull('fec_eli')->get()->toArray();
    }
}

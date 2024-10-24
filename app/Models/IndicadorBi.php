<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicadorBi extends Model
{
    use HasFactory;

    // La tabla asociada con el modelo
    protected $table = 'indicadores_bi';
    protected $primaryKey = 'idindicadores_bi';

    public $timestamps = false;

    // Los atributos que se pueden asignar masivamente
    protected $fillable = [
        'id_acceso_bi_reporte',
        'npagina',
        'nom_indicador',
        'estado',
        'descripcion',
        'idtipo_indicador',
        'presentacion',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fect_eli',
        'user_eli',
    ];

    // Los atributos que deben ser convertidos a tipos nativos
    protected $casts = [
        'fec_reg' => 'datetime',
        'fec_act' => 'datetime',
        'fect_eli' => 'datetime',
    ];

    /**
     * Relación con TipoIndicador
     */
    public function tipoIndicador()
    {
        return $this->belongsTo(TipoIndicador::class, 'idtipo_indicador', 'idtipo_indicador');
    }
}

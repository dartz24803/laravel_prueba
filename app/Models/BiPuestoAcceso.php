<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiPuestoAcceso extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla en la base de datos
    protected $table = 'bi_puesto_acceso';

    // Definir la clave primaria
    protected $primaryKey = 'id_bi_puesto_acceso';

    // Indicar que la clave primaria es un entero auto-incremental
    public $incrementing = true;

    // Definir el tipo de la clave primaria
    protected $keyType = 'int';

    // Indicar que la tabla no usa timestamps automáticos
    public $timestamps = false;

    // Definir los atributos que se pueden llenar en masa
    protected $fillable = [
        'id_acceso_bi_reporte',
        'id_puesto',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act'
    ];

    // Definir la relación con el modelo AccesoBiReporte
    public function accesoBiReporte()
    {
        return $this->belongsTo(BiReporte::class, 'id_acceso_bi_reporte', 'id_acceso_bi_reporte');
    }

    // Definir la relación con el modelo Puesto
    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'id_puesto', 'id_puesto');
    }
}

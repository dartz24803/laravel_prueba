<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'area';

    protected $fillable = [
        'id_area',
        'id_direccion',
        'cod_area',
        'nom_area',
        'id_gerencia',
        'id_departamento',
        'puestos',
        'orden',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function buscar($id)
    {
        return $this->where('id_area', $id)->get()->toArray();
    }

    public function listar()
    {
        return $this->where('estado',1)->orderBy("id_area",'DESC')->get()->toArray();
    }
    
}

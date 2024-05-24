<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'base';

    protected $fillable = [
        'id_base',
        'cod_base',
        'nom_base',
        'id_empresa',
        'id_departamento',
        'id_provincia',
        'id_distrito',
        'direccion',
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
        return $this->where('id_base', $id)->get()->toArray();
    }

    public function listar()
    {
        return $this->select('cod_base')->where('estado',1)->distinct()->orderBy("cod_base",'ASC')->get()->toArray();
    }

}

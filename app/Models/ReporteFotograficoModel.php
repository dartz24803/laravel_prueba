<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteFotograficoModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'reporte_fotografico';

    protected $fillable = [
        'id',
        'base',
        'foto',
        'codigo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    /*
    public function buscar($id)
    {
        return $this->where('id', $id)->get()->toArray();
    }*/

    public function listar()
    {
        return $this->orderBy("id",'DESC')->get()->toArray();
    }
}

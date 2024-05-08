<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteraModelo extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'cartera';

    protected $fillable = [
        'codigo',
        'ruc',
        'razon_social',
        'nombre_comercial',
    ];

    public function buscar($id)
    {
        return $this->where('id_cartera', $id)->get()->toArray();
    }

    public function listar()
    {
        return $this->orderBy("id_cartera",'DESC')->get()->toArray();
    }

    public function buscar_codigo($codigo)
    {
        return $this->where('codigo', $codigo)->get()->toArray();
    }
}
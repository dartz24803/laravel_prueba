<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigosReporteFotografico extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'codigos_reporte_fotografico';

    protected $fillable = [
        'id',
        'descripcion',
        'tipo',
    ];

    public function buscar($id)
    {
        return $this->where('id', $id)->get()->toArray();
    }

    public function listar()
    {
        return $this->select('descripcion')->distinct()->get()->toArray();
    }
    
    public function listar_tipos()
    {
        return $this->select('tipo')->distinct()->get()->toArray();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuariosModel extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'users';

    protected $fillable = [
        'usuario_apater',
        'usuario_amater',
        'usuario_nombres',
        'usuario_codigo',
        'usuario_password',
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
        return $this->where('id_usuario', $id)->get()->toArray();
    }

    public function listar()
    {
        return $this->orderBy("id_usuario",'DESC')->get()->toArray();
    }

    public function buscar_codigo($id_usuario)
    {
        return $this->where('id_usuario', $id_usuario)->get()->toArray();
    }
    
}

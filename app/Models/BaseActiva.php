<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseActiva extends Model
{
    use HasFactory;

    protected $table = 'vw_base_activa';

    public $timestamps = false;

    protected $fillable = [
        'id_base',
        'cod_base'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcesoVisita extends Model
{
    use HasFactory;

    protected $table = 'proceso_visita';

    public $timestamps = false;

    protected $fillable = [
        'id_procesov',
        'nom_proceso'
    ];
}

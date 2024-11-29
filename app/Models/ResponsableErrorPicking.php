<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsableErrorPicking extends Model
{
    use HasFactory;

    protected $table = 'vw_responsable_error_picking';

    public $timestamps = false;

    protected $fillable = [
        'id_responsable',
        'nom_responsable'
    ];
}

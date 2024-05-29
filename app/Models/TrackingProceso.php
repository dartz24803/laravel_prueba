<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingProceso extends Model
{
    use HasFactory;

    protected $table = 'tracking_proceso';

    public $timestamps = false;

    protected $fillable = [
        'descripcion'
    ];
}

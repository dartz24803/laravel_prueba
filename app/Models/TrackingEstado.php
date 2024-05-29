<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingEstado extends Model
{
    use HasFactory;

    protected $table = 'tracking_estado';

    public $timestamps = false;

    protected $fillable = [
        'id_proceso',
        'descripcion'
    ];
}

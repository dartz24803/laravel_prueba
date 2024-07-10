<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingNotificacion extends Model
{
    use HasFactory;

    protected $table = 'tracking_notificacion';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'titulo',
        'contenido',
        'fecha'
    ];
}

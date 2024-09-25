<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingComentario extends Model
{
    use HasFactory;

    protected $table = 'tracking_comentario';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'pantalla',
        'comentario'
    ];
}

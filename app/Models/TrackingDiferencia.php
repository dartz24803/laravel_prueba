<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingDiferencia extends Model
{
    use HasFactory;
    
    protected $table = 'tracking_diferencia';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'sku',
        'estilo',
        'color_talla',
        'bulto',
        'enviado',
        'recibido',
        'observacion'
    ];
}

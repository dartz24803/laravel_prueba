<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingArchivo extends Model
{
    use HasFactory;

    protected $table = 'tracking_archivo';

    public $timestamps = false;

    protected $fillable = [
        'id_tracking',
        'tipo',
        'archivo'
    ];
}

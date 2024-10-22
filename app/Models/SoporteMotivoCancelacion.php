<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoporteMotivoCancelacion extends Model
{
    use HasFactory;

    protected $table = 'soporte_motivo_cancelacion';

    protected $primaryKey = 'idsoporte_motivo_cancelacion';

    public $timestamps = false;

    protected $fillable = [
        'motivo',
    ];
}

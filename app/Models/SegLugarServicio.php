<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SegLugarServicio extends Model
{
    use HasFactory;

    protected $table = 'seg_lugar_servicio';

    public $timestamps = false;

    protected $fillable = [
        'id_lugar_servicio',
        'nom_lugar_servicio'
    ];
}

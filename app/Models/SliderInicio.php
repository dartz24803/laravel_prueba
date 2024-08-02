<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderInicio extends Model
{
    use HasFactory;

    protected $table = 'slider_inicio';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'titulo',
        'descripcion',
        'link',
        'categoria',
        'fec_act',
        'user_act',
    ];
}

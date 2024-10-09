<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoCheque extends Model
{
    use HasFactory;

    protected $table = 'concepto_cheque';
    protected $primaryKey = 'id_concepto_cheque';

    public $timestamps = false;

    protected $fillable = [
        'nom_concepto_cheque',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}

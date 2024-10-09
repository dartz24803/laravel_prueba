<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanzasCheque extends Model
{
    use HasFactory;

    protected $table = 'finanzas_cheque';
    protected $primaryKey = 'id_cheque';

    public $timestamps = false;

    protected $fillable = [
        'cod_cheque',
        'id_empresa',
        'id_banco',
        'n_cheque',
        'id_tipo',
        'fec_emision',
        'fec_vencimiento',
        'id_proveedor',
        'tipo_doc',
        'num_doc',
        'razon_social',
        'concepto',
        'id_moneda',
        'importe',
        'estado_cheque',
        'fec_autorizado',
        'fec_pend_cobro',
        'fec_cobro',
        'noperacion',
        'motivo_anulado',
        'img_cheque',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];
}

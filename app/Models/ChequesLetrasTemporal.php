<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequesLetrasTemporal extends Model
{
    use HasFactory;

    protected $table = 'cheques_letras_temporal';
    protected $primaryKey = 'id_temporal';

    public $timestamps = false;

    protected $fillable = [
        'num_doc',
        'fec_emision',
        'fec_vencimiento',
        'fec_emision_ok',
        'fec_vencimiento_ok',
        'descripcion',
        'importe',
        'importe_ok',
        'n_comprobante',
        'ruc_empresa',
        'tipo_doc',
        'tipo_doc_aceptante',
        'num_doc_aceptante',
        'tipo_comprobante',
        'tipo_moneda',
        'nom_empresa',
        'nom_aceptante',
        'id_empresa',
        'id_tipo_documento',
        'id_tipo_comprobante',
        'num_comprobante',
        'id_moneda',
        'obs',
        'ok',
        'id',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}

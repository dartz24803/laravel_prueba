<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivosTickets extends Model
{
    protected $table = 'archivos_tickets';
    protected $primaryKey = 'id_archivos_tickets';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_solic',
        'cod_tickets',
        'id_ticket',
        'archivos',
        'nom_archivos',
        'estado',
        'user_reg',
        'fec_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivosTicketsSoporte extends Model
{
    protected $table = 'archivos_tickets_soporte';
    protected $primaryKey = 'id_archivos_tickets_soporte';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario_soporte',
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

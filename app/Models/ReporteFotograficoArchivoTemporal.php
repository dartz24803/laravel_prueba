<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ReporteFotograficoArchivoTemporal extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'reporte_fotografico_archivo_temporal';

    protected $fillable = [
        'id',
        'ruta',
        'id_usuario',
    ];

    public function contador_archivos_rf()
    {
        $id_usuario = Auth::id();
        return self::where('id_usuario', $id_usuario)->count();
    }
}

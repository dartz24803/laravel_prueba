<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CotizacionPendienteTemporal extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'cotizacion_pendiente_temporal';

    // Llave primaria
    protected $primaryKey = 'id';

    // Desactivar timestamps automáticos (si no se usan los campos created_at y updated_at)
    public $timestamps = false;

    // Atributos asignables
    protected $fillable = [
        'id_usuario',
        'proveedor',
        'telefono',
        'costo'
    ];
    
    static function insert_cotizacion_pendiente($dato){
        $id_usuario = session('usuario')->id_usuario;
        $sql = "INSERT INTO cotizacion_pendiente (id_pendiente,proveedor,telefono,costo) 
                SELECT '".$dato['id_pendiente']."',proveedor,telefono,costo 
                FROM cotizacion_pendiente_temporal
                WHERE id_usuario=$id_usuario";
        DB::insert($sql);
    }
}

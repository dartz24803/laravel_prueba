<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DomicilioUsers extends Model
{
    use HasFactory;

    protected $table = 'domicilio_users';
    protected $primaryKey = 'id_domicilio_users';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_departamento',
        'id_provincia',
        'id_distrito',
        'id_tipo_via',
        'nom_via',
        'num_via',
        'kilometro',
        'manzana',
        'lote',
        'interior',
        'departamento',
        'piso',
        'id_zona',
        'nom_zona',
        'referencia',
        'id_tipo_vivienda',
        'lat',
        'lng',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    static function get_id_domicilio_users($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT du.*,de.nombre_departamento,pro.nombre_provincia,
                    di.nombre_distrito , ti.nom_tipo_via,tip.nom_tipo_vivienda,
                    CONCAT((CASE WHEN du.id_tipo_via!=0 AND du.id_tipo_via!=21 THEN
                    CONCAT(ti.nom_tipo_via,' ') ELSE '' END),
                    (CASE WHEN du.nom_via!='' AND du.nom_via!='NO' AND du.nom_via!='No' AND
                    du.nom_via!='no' AND du.nom_via!='-' AND du.nom_via!='.'
                    THEN CONCAT(du.nom_via,' ') ELSE '' END),
                    (CASE WHEN du.num_via!='' AND du.num_via!='NO' AND du.num_via!='No' AND
                    du.num_via!='no' AND du.num_via!='-' AND du.num_via!='.'
                    THEN CONCAT(du.num_via,' ') ELSE '' END),
                    (CASE WHEN du.kilometro!='' AND du.kilometro!='NO' AND du.kilometro!='No' AND
                    du.kilometro!='no' AND du.kilometro!='-' AND du.kilometro!='.'
                    THEN CONCAT('KM ',du.kilometro,' ') ELSE '' END),
                    (CASE WHEN du.manzana!='' AND du.manzana!='NO' AND du.manzana!='No' AND
                    du.manzana!='no' AND du.manzana!='-' AND du.manzana!='.'
                    THEN CONCAT('MZ ',du.manzana,' ') ELSE '' END),
                    (CASE WHEN du.lote!='' AND du.lote!='NO' AND du.lote!='No' AND
                    du.lote!='no' AND du.lote!='-'AND du.lote!='.'
                    THEN CONCAT('LT ',du.lote,' ') ELSE '' END),
                    (CASE WHEN du.interior!='' AND du.interior!='NO' AND du.interior!='No' AND
                    du.interior!='no' AND du.interior!='-' AND du.interior!='.'
                    THEN CONCAT('INT ',du.interior,' ') ELSE '' END),
                    (CASE WHEN du.departamento!='' AND du.departamento!='NO' AND du.departamento!='No' AND
                    du.departamento!='no' AND du.departamento!='-' AND du.departamento!='.'
                    THEN CONCAT('DPTO ',du.departamento,' ') ELSE '' END),
                    (CASE WHEN du.piso!='' AND du.piso!='NO' AND du.piso!='No' AND
                    du.piso!='no' AND du.piso!='-' AND du.piso!='.'
                    THEN CONCAT('Piso ',du.piso,' ') ELSE '' END),
                    (CASE WHEN du.id_zona!=0 AND du.id_zona!=11 THEN CONCAT(zo.nom_zona,' ') ELSE '' END),
                    (CASE WHEN du.nom_zona!='' AND du.nom_zona!='NO' AND du.nom_zona!='No' AND
                    du.nom_zona!='no' AND du.nom_zona!='-' AND du.nom_zona!='.'
                    THEN CONCAT(du.nom_zona) ELSE '' END)) AS direccion_completa
                    FROM domicilio_users du
                    LEFT JOIN departamento de on de.id_departamento=du.id_departamento
                    LEFT JOIN distrito di on di.id_distrito=du.id_distrito
                    LEFT JOIN provincia pro on pro.id_provincia=du.id_provincia
                    LEFT JOIN tipo_via ti on ti.id_tipo_via=du.id_tipo_via
                    LEFT JOIN tipo_vivienda tip on tip.id_tipo_vivienda=du.id_tipo_vivienda
                    LEFT JOIN zona zo ON du.id_zona=zo.id_zona
                    where du.id_usuario =".$id_usuario;
        }else{
            $sql = "select * from domicilio_users";
        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}

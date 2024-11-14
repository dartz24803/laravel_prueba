<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organigrama extends Model
{
    use HasFactory;

    protected $table = 'organigrama';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'id_centro_labor',
        'id_usuario',
        'fecha',
        'usuario'
    ];

    public static function get_list_organigrama($dato)
    {
        $parte_puesto = "";
        if ($dato['id_puesto'] != "0") {
            $parte_puesto = "AND og.id_puesto=".$dato['id_puesto'];
        }
        $parte_centro_labor = "";
        if ($dato['id_centro_labor'] != "0") {
            $parte_centro_labor = "AND og.id_centro_labor=".$dato['id_centro_labor'];
        }
        $sql = "SELECT og.id,pu.nom_puesto,ub.cod_ubi,
                CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater) AS nom_usuario,
                og.id_usuario
                FROM organigrama og
                INNER JOIN puesto pu ON pu.id_puesto=og.id_puesto
                INNER JOIN ubicacion ub ON ub.id_ubicacion=og.id_centro_labor
                LEFT JOIN users us ON us.id_usuario=og.id_usuario
                WHERE og.id>0 $parte_puesto $parte_centro_labor";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_colaborador($dato)
    {
        $parte_gerencia = "";
        if ($dato['id_gerencia'] != "0") {
            $parte_gerencia = "WHERE us.id_gerencia=" . $dato['id_gerencia'];
        }
        if (isset($dato['excel'])) {
            $sql = "SELECT eu.nom_estado_usuario,CASE WHEN us.ini_funciones IS NULL THEN '' 
                    ELSE us.ini_funciones END AS ini_funciones,
                    us.centro_labores,us.usuario_apater,us.usuario_amater,us.usuario_nombres,ca.nom_cargo,
                    pu.nom_puesto,ar.nom_area,sg.nom_sub_gerencia,ge.nom_gerencia,td.cod_tipo_documento,
                    us.num_doc,du.dni_doc,gn.nom_genero,CASE WHEN us.fec_nac IS NULL THEN '' 
                    ELSE us.fec_nac END AS fec_nac,us.usuario_email,us.num_celp,de.nombre_departamento,
                    pr.nombre_provincia,di.nombre_distrito,tv.nom_tipo_via,dm.nom_via,dm.num_via,dm.kilometro,
                    dm.manzana,dm.interior,dm.departamento,dm.lote,dm.piso,zo.nom_zona AS nom_tipo_zona,
                    dm.nom_zona,ti.nom_tipo_vivienda,dm.referencia AS referencia_domicilio,
                    gpu.plato_postre,gpu.galletas_golosinas,gpu.ocio_pasatiempos,gpu.artistas_banda,gpu.genero_musical,
                    gpu.pelicula_serie,gpu.colores_favorito,gpu.redes_sociales,gpu.deporte_favorito,gpu.mascota,
                    CONCAT((CASE WHEN dm.id_tipo_via!=0 AND dm.id_tipo_via!=21 THEN 
                    CONCAT(tv.nom_tipo_via,' ') ELSE '' END),
                    (CASE WHEN dm.nom_via!='' AND dm.nom_via!='NO' AND dm.nom_via!='No' AND 
                    dm.nom_via!='no' AND dm.nom_via!='-' AND dm.nom_via!='.' 
                    THEN CONCAT(dm.nom_via,' ') ELSE '' END),
                    (CASE WHEN dm.num_via!='' AND dm.num_via!='NO' AND dm.num_via!='No' AND 
                    dm.num_via!='no' AND dm.num_via!='-' AND dm.num_via!='.' 
                    THEN CONCAT(dm.num_via,' ') ELSE '' END),
                    (CASE WHEN dm.kilometro!='' AND dm.kilometro!='NO' AND dm.kilometro!='No' AND 
                    dm.kilometro!='no' AND dm.kilometro!='-' AND dm.kilometro!='.' 
                    THEN CONCAT('KM ',dm.kilometro,' ') ELSE '' END),
                    (CASE WHEN dm.manzana!='' AND dm.manzana!='NO' AND dm.manzana!='No' AND 
                    dm.manzana!='no' AND dm.manzana!='-' AND dm.manzana!='.' 
                    THEN CONCAT('MZ ',dm.manzana,' ') ELSE '' END),
                    (CASE WHEN dm.lote!='' AND dm.lote!='NO' AND dm.lote!='No' AND 
                    dm.lote!='no' AND dm.lote!='-' AND dm.lote!='.' 
                    THEN CONCAT('LT ',dm.lote,' ') ELSE '' END),
                    (CASE WHEN dm.interior!='' AND dm.interior!='NO' AND dm.interior!='No' AND 
                    dm.interior!='no' AND dm.interior!='-' AND dm.interior!='.' 
                    THEN CONCAT('INT ',dm.interior,' ') ELSE '' END),
                    (CASE WHEN dm.departamento!='' AND dm.departamento!='NO' AND dm.departamento!='No' AND 
                    dm.departamento!='no' AND dm.departamento!='-' AND dm.departamento!='.' 
                    THEN CONCAT('DPTO ',dm.departamento,' ') ELSE '' END),
                    (CASE WHEN dm.piso!='' AND dm.piso!='NO' AND dm.piso!='No' AND 
                    dm.piso!='no' AND dm.piso!='-' AND dm.piso!='.' 
                    THEN CONCAT('Piso ',dm.piso,' ') ELSE '' END),
                    (CASE WHEN dm.id_zona!=0 AND dm.id_zona!=11 THEN CONCAT(zo.nom_zona,' ') ELSE '' END),
                    (CASE WHEN dm.nom_zona!='' AND dm.nom_zona!='NO' AND dm.nom_zona!='No' AND 
                    dm.nom_zona!='no' AND dm.nom_zona!='-' AND dm.nom_zona!='.' 
                    THEN CONCAT(dm.nom_zona,' ') ELSE '' END)) AS direccion_completa,
                    sn.cod_sistema_pensionario,ba.nom_banco,cb.num_cuenta_bancaria,
                    CASE WHEN us.ini_funciones IS NULL THEN '' 
                    ELSE TIMESTAMPDIFF(YEAR, us.ini_funciones, CURDATE()) END AS anio_antiguedad,
                    CASE WHEN us.ini_funciones IS NULL THEN '' 
                    ELSE TIMESTAMPDIFF(MONTH, us.ini_funciones, CURDATE()) END AS mes_antiguedad,
                    sl.nom_situacion_laboral,em.nom_empresa,CASE WHEN us.hijos=1 THEN 'SI' 
                    ELSE 'NO' END AS hijos,CASE WHEN og.id_usuario=0 THEN 0 ELSE 
                    progreso_colaborador(og.id_usuario) END AS progreso,
                    (CASE WHEN ou.cert_vacu_covid IS NOT NULL THEN 1 ELSE 0 END) AS covid,ou.cert_vacu_covid,
                    (CASE WHEN us.id_horario IS NOT NULL THEN ho.nombre ELSE 'Sin Horario' END) AS horariof,
                    (CASE WHEN us.id_modalidad_laboral!=0 THEN md.nom_modalidad_laboral 
                    ELSE 'Sin Modalidad' END) AS modalidadf,tp.cod_talla AS polo,tc.cod_talla AS camisa,
                    tpa.cod_talla AS pantalon,tz.cod_talla AS zapato,gs.nom_grupo_sanguineo,
                    CASE WHEN YEAR(us.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(us.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(us.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(us.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(us.fec_nac) >= 2013 THEN '&alpha;' ELSE '' END AS generacion,
                    CASE WHEN us.fin_funciones IS NULL THEN '' ELSE us.fin_funciones END AS fin_funciones,
                    us.mes_nac,us.dia_nac
                    FROM organigrama og
                    LEFT JOIN users us ON og.id_usuario=us.id_usuario
                    LEFT JOIN gusto_preferencia_users gpu ON us.id_usuario = gpu.id_usuario
                    LEFT JOIN estado_usuario eu ON us.estado=eu.id_estado_usuario
                    LEFT JOIN cargo ca ON us.id_cargo=ca.id_cargo
                    LEFT JOIN puesto pu ON og.id_puesto=pu.id_puesto
                    LEFT JOIN area ar ON pu.id_area=ar.id_area
                    LEFT JOIN sub_gerencia sg ON ar.id_departamento=sg.id_sub_gerencia
                    LEFT JOIN gerencia ge ON sg.id_gerencia=ge.id_gerencia
                    LEFT JOIN tipo_documento td ON us.id_tipo_documento=td.id_tipo_documento
                    LEFT JOIN documentacion_usuario du ON us.id_usuario=du.id_usuario
                    LEFT JOIN genero gn ON us.id_genero=gn.id_genero
                    LEFT JOIN domicilio_users dm ON us.id_usuario=dm.id_usuario
                    LEFT JOIN departamento de ON dm.id_departamento=de.id_departamento
                    LEFT JOIN provincia pr ON dm.id_provincia=pr.id_provincia
                    LEFT JOIN distrito di ON dm.id_distrito=di.id_distrito
                    LEFT JOIN tipo_via tv ON dm.id_tipo_via=tv.id_tipo_via
                    LEFT JOIN zona zo ON dm.id_zona=zo.id_zona
                    LEFT JOIN tipo_vivienda ti ON dm.id_tipo_vivienda=ti.id_tipo_vivienda
                    LEFT JOIN sist_pens_usuario sp ON us.id_usuario=sp.id_usuario
                    LEFT JOIN sistema_pensionario sn ON sp.id_sistema_pensionario=sn.id_sistema_pensionario
                    LEFT JOIN cuenta_bancaria cb ON us.id_usuario=cb.id_usuario
                    LEFT JOIN banco ba ON cb.id_banco=ba.id_banco
                    LEFT JOIN situacion_laboral sl ON us.id_situacion_laboral=sl.id_situacion_laboral
                    LEFT JOIN empresas em ON us.id_empresapl=em.id_empresa
                    LEFT JOIN otros_usuario ou ON us.id_usuario=ou.id_usuario
                    LEFT JOIN horario ho ON us.id_horario=ho.id_horario
                    LEFT JOIN modalidad_laboral md on us.id_modalidad_laboral=md.id_modalidad_laboral
                    LEFT JOIN ropa_usuario ru ON us.id_usuario=ru.id_usuario
                    LEFT JOIN talla tp ON ru.polo=tp.id_talla
                    LEFT JOIN talla tc ON ru.camisa=tc.id_talla
                    LEFT JOIN talla tpa ON ru.pantalon=tpa.id_talla
                    LEFT JOIN talla tz ON ru.zapato=tz.id_talla
                    LEFT JOIN grupo_sanguineo gs ON ou.id_grupo_sanguineo=gs.id_grupo_sanguineo
                    $parte_gerencia
                    ORDER BY us.ini_funciones DESC";
        } else {
            $sql = "SELECT CASE WHEN og.id_usuario IS NULL THEN 0 ELSE og.id_usuario END AS id_usuario,
                    us.ini_funciones AS orden,
                    CASE WHEN YEAR(us.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(us.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(us.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(us.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(us.fec_nac) >= 2013 THEN '&alpha;' ELSE '' END AS generacion,
                    cl.cod_ubi AS centro_labor,ub.cod_ubi AS ubicacion,us.usuario_apater,
                    us.usuario_amater,us.usuario_nombres,pu.nom_puesto,ar.nom_area,sg.nom_sub_gerencia,
                    ge.nom_gerencia,DATE_FORMAT(us.ini_funciones,'%d-%m-%Y') AS fecha_ingreso,
                    td.cod_tipo_documento,us.num_doc,us.num_celp,
                    DATE_FORMAT(us.fec_baja,'%d-%m-%Y') AS fecha_baja,mt.nom_motivo,us.doc_baja,us.verif_email,
                    us.foto,us.documento,us.fec_baja
                    FROM organigrama og
                    LEFT JOIN users us ON og.id_usuario=us.id_usuario
                    LEFT JOIN ubicacion cl ON us.id_centro_labor=cl.id_ubicacion
                    LEFT JOIN ubicacion ub ON us.id_ubicacion=ub.id_ubicacion
                    LEFT JOIN puesto pu ON og.id_puesto=pu.id_puesto
                    LEFT JOIN area ar ON pu.id_area=ar.id_area
                    LEFT JOIN sub_gerencia sg ON ar.id_departamento=sg.id_sub_gerencia
                    LEFT JOIN gerencia ge ON sg.id_gerencia=ge.id_gerencia
                    LEFT JOIN tipo_documento td ON us.id_tipo_documento=td.id_tipo_documento
                    LEFT JOIN motivo_baja_rrhh mt ON us.id_motivo_baja=mt.id_motivo
                    $parte_gerencia
                    ORDER BY us.ini_funciones DESC";
        }
        $query = DB::select($sql);
        return $query;
    }
}

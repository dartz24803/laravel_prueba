<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Model_Perfil extends Model
{
    public static function perfil_porcentaje($id_usuario){
        $sql = "SELECT u.id_usuario, u.usuario_apater, u.centro_labores, td.cod_tipo_documento,
                u.num_celp,u.num_doc, u.usuario_amater, u.usuario_nombres, n.nom_nacionalidad,
                u.foto, u.verif_email,
                (case when u.usuario_nombres is not null and u.usuario_apater is not null and u.usuario_amater is not null
                and u.id_nacionalidad is not null and u.id_tipo_documento is not null
                and u.num_doc is not null and u.id_genero is not null and u.fec_nac is not null
                and u.id_estado_civil is not null and u.num_celp is not null and u.foto_nombre is not null
                and (u.emailp is not null || u.usuario_email is not null)
                then 1 else 0 end) as datos_personales,
                (case when (select count(1) from gusto_preferencia_users where gusto_preferencia_users.id_usuario=u.id_usuario and gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos where hijos.id_usuario=u.id_usuario and hijos.estado=1)>0) then 1 else 0 end) as cont_hijos,
                (case when (select count(1) from conoci_idiomas where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0 then 1 else 0 end) as idiomas,
                (case when u.enfermedades=2 or (u.enfermedades=1 and (select count(1) from enfermedad_usuario where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0) then 1 else 0 end) as cont_enfermedades,
                (case when u.id_genero=1 or (select count(1) from gestacion_usuario where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0 then 1 else 0 end) as gestacion,
                (case when u.alergia=0 then 0 else 1 end) as cont_alergia,
                (case when (select count(1) from referencia_convocatoria where referencia_convocatoria.id_usuario=u.id_usuario and referencia_convocatoria.estado=1)>0 then 1 else 0 end) as ref_convoc,
                (case when e.cv_doc<>'' and e.dni_doc<>'' and e.recibo_doc<>'' then 1 else 0 end) as adj_documentacion,
                (case when u.terminos=0 then 0 else 1 end) as cont_terminos,
                (case when (select count(1) from curso_complementario where curso_complementario.id_usuario=u.id_usuario and curso_complementario.estado=1)>0 then 1 else 0 end) as con_cursos_compl,
                (case when (select count(1) from otros_usuario where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0 then 1 else 0 end) as con_otros,

                (case when d.id_departamento is not null and d.id_provincia is not null and d.id_distrito is not null
                and d.id_tipo_vivienda is not null and d.referencia is not null and d.lat is not null and d.lng is not null
                then 1 else 0 end) as domicilio_user, (case when cb.cuenta_bancaria=2 then 1
                when cb.id_banco is not null and cb.cuenta_bancaria is not null
                and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                and cb.num_codigo_interbancario is not null then 1 else 0 end) as cuenta_bancaria,
                (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                then 1 else 0 end) as talla_usuario, (case when ou.id_grupo_sanguineo is not null
                then 1 else 0 end) as grupo_sanguineo,
                /*(case when ou.cert_covid is not null then 1 else 0 end) as covid,*/
                (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                (case when sp.id_respuestasp is not null then 1 else 0 end) as sistema_pension,
                (case when du.cv_doc is not null and du.dni_doc is not null and du.recibo_doc is not null
                then 1 else 0 end) as documentacion, (case when co.nl_excel is not null and
                co.nl_word is not null and co.nl_ppoint is not null then 1 else 0 end) as office,
                (case when (select count(1) from referencia_familiar
                where referencia_familiar.id_usuario=u.id_usuario and referencia_familiar.nom_familiar is not null
                and referencia_familiar.id_parentesco is not null
                and referencia_familiar.fec_nac is not null and (referencia_familiar.celular1 is not null ||
                referencia_familiar.celular2 is not null || referencia_familiar.fijo is not null)
                and referencia_familiar.estado=1)>0 then 1 else 0 end) as referencia,
                (case when (select count(1) from contacto_emergencia
                where contacto_emergencia.id_usuario=u.id_usuario and contacto_emergencia.nom_contacto is not null
                and contacto_emergencia.id_parentesco is not null
                and (contacto_emergencia.celular1 is not null || contacto_emergencia.celular2 is not null ||
                contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                then 1 else 0 end) as contactoe,
                (case when (select count(1) from estudios_generales
                where estudios_generales.id_usuario=u.id_usuario and
                estudios_generales.id_grado_instruccion is not null
                and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                estudios_generales.estado=1)>0 then 1 else 0 end) as estudiosg,
                (case when (select count(1) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario and experiencia_laboral.empresa is not null
                and experiencia_laboral.cargo is not null and experiencia_laboral.fec_ini is not null
                and experiencia_laboral.fec_fin is not null and experiencia_laboral.motivo_salida is not null
                and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as experiencial, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo,
                u.usuario_email, em.nom_empresa, du.dni_doc
                from users u
                LEFT JOIN gerencia g on g.id_gerencia=u.id_gerencia
                LEFT JOIN area a on a.id_area=u.id_area
                LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                left join domicilio_users d on d.id_usuario=u.id_usuario
                left join tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                left join conoci_office co on co.id_usuario=u.id_usuario
                left join otros_usuario ou on ou.id_usuario=u.id_usuario
                left join documentacion_usuario du on du.id_usuario=u.id_usuario
                left join cuenta_bancaria cb on cb.id_usuario=u.id_usuario
                left join ropa_usuario ru on ru.id_usuario=u.id_usuario
                left join sist_pens_usuario sp on sp.id_usuario=u.id_usuario
                left join empresas em on em.id_empresa=u.id_empresapl
                left join (select id_usuario,cv_doc,dni_doc,recibo_doc
                            from documentacion_usuario where estado=1) as e on u.id_usuario=e.id_usuario
                WHERE u.id_usuario=$id_usuario";

            $result = DB::select($sql);
            return json_decode(json_encode($result), true);
    }
    public static function datosp_porcentaje($id_usuario=null){
        $sql = "SELECT
                (case when u.usuario_nombres is not null then 1 else 0 end) as nombres,
                (case when u.usuario_apater is not null then 1 else 0 end) as apater,
                (case when u.usuario_amater is not null then 1 else 0 end) as amater,
                (case when u.id_nacionalidad is not null then 1 else 0 end) as nacionalidad,
                (case when u.id_tipo_documento is not null then 1 else 0 end) as tipo_documento,
                (case when u.num_doc is not null then 1 else 0 end) as num_doc,
                (case when u.fec_nac is not null then 1 else 0 end) as fec_nac,
                (case when u.id_estado_civil is not null then 1 else 0 end) as estado_civil,
                (case when u.emailp is not null || u.usuario_email is not null then 1 else 0 end) as emailp,
                (case when u.num_celp is not null then 1 else 0 end) as num_celp,
                (case when u.foto_nombre is not null and u.foto_nombre<>'' then 1 else 0 end) as foto
                from users u
                WHERE id_usuario=$id_usuario";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_domicilio_users($id_usuario=null){
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

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    public static function get_id_gustosp($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from gusto_preferencia_users where id_usuario =".$id_usuario." and estado=1";
        }
        else{
            $sql = "select * from gusto_preferencia_users where estado=1";
        }

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function domiciliou_porcentaje($id_usuario=null){
        $sql = "SELECT (case when d.id_departamento is not null then 1 else 0 end) as departamento,
                (case when d.id_provincia is not null then 1 else 0 end) as provincia,
                (case when d.id_distrito is not null then 1 else 0 end) as distrito,
                (case when d.id_tipo_vivienda then 1 else 0 end) as tipo_vivienda,
                (case when d.referencia is not null then 1 else 0 end) as referencia,
                (case when d.lat is not null then 1 else 0 end) as lat,
                (case when d.lng is not null then 1 else 0 end) as lng
                from domicilio_users d
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function referenciaf_porcentaje($id_usuario=null){
        $sql = "SELECT (case when (select count(*) from referencia_familiar
                where referencia_familiar.id_usuario=u.id_usuario and referencia_familiar.nom_familiar is not null
                and referencia_familiar.estado=1)>0
                then 1 else 0 end) as nom_familiar,
                (case when (select count(*) from referencia_familiar
                where referencia_familiar.id_usuario=u.id_usuario
                and referencia_familiar.id_parentesco is not null
                and referencia_familiar.estado=1)>0
                then 1 else 0 end) as parentesco,
                (case when (select count(*) from referencia_familiar
                where referencia_familiar.id_usuario=u.id_usuario
                and referencia_familiar.fec_nac is not null
                and referencia_familiar.estado=1)>0
                then 1 else 0 end) as fec_nac,
                (case when (select count(*) from referencia_familiar
                where referencia_familiar.id_usuario=u.id_usuario
                and (referencia_familiar.celular1 is not null ||
                referencia_familiar.celular2 is not null || referencia_familiar.fijo is not null)
                and referencia_familiar.estado=1)>0
                then 1 else 0 end) as alternativa
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function datoshu_porcentaje($id_usuario=null){
        $sql = "SELECT
                (case when (select count(*) from hijos
                where hijos.id_usuario=u.id_usuario and hijos.nom_hijo is not null and hijos.estado=1)>0
                then 1 else 0 end) as nom_hijo,
                (case when (select count(*) from hijos
                where hijos.id_usuario=u.id_usuario and hijos.id_genero is not null
                and hijos.estado=1)>0
                then 1 else 0 end) as genero,
                (case when (select count(*) from hijos
                where hijos.id_usuario=u.id_usuario and hijos.fec_nac is not null and hijos.estado=1)>0
                then 1 else 0 end) as fec_nac,
                (case when (select count(*) from hijos
                where hijos.id_usuario=u.id_usuario and hijos.num_doc is not null and hijos.estado=1)>0
                then 1 else 0 end) as num_doc,
                (case when (select count(*) from hijos
                where hijos.id_usuario=u.id_usuario and hijos.id_biologico is not null
                and hijos.estado=1)>0
                then 1 else 0 end) as biologico,
                (case when (select count(*) from hijos
                where hijos.id_usuario=u.id_usuario and hijos.documento is not null and hijos.estado=1)>0
                then 1 else 0 end) as documento
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function contactoeu_porcentaje($id_usuario=null){
        $sql = "SELECT (case when (select count(*) from contacto_emergencia
                where contacto_emergencia.id_usuario=u.id_usuario and contacto_emergencia.nom_contacto is not null
                and contacto_emergencia.estado=1)>0
                then 1 else 0 end) as nom_contacto,
                (case when (select count(*) from contacto_emergencia
                where contacto_emergencia.id_usuario=u.id_usuario
                and contacto_emergencia.id_parentesco is not null
                and contacto_emergencia.estado=1)>0
                then 1 else 0 end) as parentesco,
                (case when (select count(*) from contacto_emergencia
                where contacto_emergencia.id_usuario=u.id_usuario
                and (contacto_emergencia.celular1 is not null || contacto_emergencia.celular2 is not null ||
                contacto_emergencia.fijo is not null)
                and contacto_emergencia.estado=1)>0
                then 1 else 0 end) as alternativoce
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function estudiosgu_porcentaje($id_usuario=null){
        $sql = "SELECT (case when (select count(*) from estudios_generales
                where estudios_generales.id_usuario=u.id_usuario
                and estudios_generales.id_grado_instruccion is not null
                and estudios_generales.estado=1)>0
                then 1 else 0 end) as instruccion,
                (case when (select count(*) from estudios_generales
                where estudios_generales.id_usuario=u.id_usuario
                and estudios_generales.carrera IS NOT NULL
                and estudios_generales.estado=1)>0
                then 1 else 0 end) as carrera,
                (case when (select count(*) from estudios_generales
                where estudios_generales.id_usuario=u.id_usuario
                and estudios_generales.centro IS NOT NULL
                and estudios_generales.estado=1)>0
                then 1 else 0 end) as centro
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function oficceu_porcentaje($id_usuario=null){
        $sql = "SELECT
                (case when co.nl_excel is not null and co.nl_excel!=0 then 1 else 0 end) as excel,
                (case when co.nl_word is not null and co.nl_word!=0 then 1 else 0 end) as word,
                (case when co.nl_ppoint is not null and co.nl_ppoint!=0 then 1 else 0 end) as ppoint
                from conoci_office co
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function idiomau_porcentaje($id_usuario=null){
        $sql = "select (case when (select count(*) from conoci_idiomas
                where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.nom_conoci_idiomas!=0
                and conoci_idiomas.nom_conoci_idiomas is not null
                and conoci_idiomas.estado=1)>0
                then 1 else 0 end) as conoci_idiomas,
                (case when (select count(*) from conoci_idiomas
                where conoci_idiomas.id_usuario=u.id_usuario
                and conoci_idiomas.lect_conoci_idiomas is not null and conoci_idiomas.lect_conoci_idiomas!=0
                and conoci_idiomas.estado=1)>0
                then 1 else 0 end) as lect_conoci,
                (case when (select count(*) from conoci_idiomas
                where conoci_idiomas.id_usuario=u.id_usuario
                and conoci_idiomas.escrit_conoci_idiomas is not null
                and conoci_idiomas.escrit_conoci_idiomas!=0
                and conoci_idiomas.estado=1)>0
                then 1 else 0 end) as escrit_conoci,
                (case when (select count(*) from conoci_idiomas
                where conoci_idiomas.id_usuario=u.id_usuario
                and conoci_idiomas.conver_conoci_idiomas is not null
                and conoci_idiomas.conver_conoci_idiomas!=0
                and conoci_idiomas.estado=1)>0
                then 1 else 0 end) as conver_conoci
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function cursocu_porcentaje($id_usuario=null){
        $sql = "SELECT (case when (select count(*) from curso_complementario
                where curso_complementario.id_usuario=u.id_usuario
                and curso_complementario.nom_curso_complementario IS NOT NULL
                and curso_complementario.nom_curso_complementario is not null
                and curso_complementario.estado=1)>0
                then 1 else 0 end) as curso_complementario,
                (case when (select count(*) from curso_complementario
                where curso_complementario.id_usuario=u.id_usuario
                and curso_complementario.anio is not null and curso_complementario.anio IS NOT NULL
                and curso_complementario.estado=1)>0
                then 1 else 0 end) as anio
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function cuentab_porcentaje($id_usuario=null){
        $sql = "SELECT (case when cb.id_banco is not null then 1 else 0 end) as banco,
                (case when cb.cuenta_bancaria is not null then 1 else 0 end) as cuenta,
                (case when cb.num_cuenta_bancaria IS NOT NULL then 1 else 0 end) as num_cuenta,
                (case when cb.num_codigo_interbancario IS NOT NULL then 1 else 0 end) as num_codigo,
                cuenta_bancaria
                from cuenta_bancaria cb
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function experiencialaboralu_porcentaje($id_usuario=null){
        $sql = "SELECT (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario and experiencia_laboral.empresa IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as empresa,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.cargo IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as cargo,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.fec_ini is not null
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as fec_ini,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.fec_fin is not null
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as fec_fin,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.actualidad IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as actualidad,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.motivo_salida IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as motivo_salida,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.remuneracion IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as remuneracion,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.nom_referencia_labores IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as nom_referencia_labores,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.num_contacto IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as num_contacto,
                (case when (select count(*) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario
                and experiencia_laboral.certificado IS NOT NULL
                and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as certificado
                from users u
                WHERE u.id_usuario=$id_usuario";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function enfermedadesu_porcentaje($id_usuario=null){
        $sql = "SELECT enfermedades, (case when (select count(*) from enfermedad_usuario
                where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.id_respuestae IS NOT NULL
                and enfermedad_usuario.estado=1)>0
                then 1 else 0 end) as id_respuestae,
                (case when (select count(*) from enfermedad_usuario
                where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.nom_enfermedad IS NOT NULL
                and enfermedad_usuario.estado=1)>0
                then 1 else 0 end) as nom_enfermedad,
                (case when (select count(*) from enfermedad_usuario
                where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.fec_diagnostico is not null
                and enfermedad_usuario.estado=1)>0
                then 1 else 0 end) as fec_diagnostico
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function gestacionu_porcentaje($id_usuario=null){
        $sql = "SELECT (case when gu.id_respuesta IS NOT NULL then 1 else 0 end) as id_respuesta,
                (case when gu.fec_ges is not null then 1 else 0 end) as fec_ges
                from gestacion_usuario gu
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function alergiasu_porcentaje($id_usuario=null){
        $sql = "SELECT alergia,
                (case when (select count(*) from alergia_usuario
                where alergia_usuario.id_usuario=u.id_usuario and alergia_usuario.nom_alergia IS NOT NULL
                and alergia_usuario.estado=1)>0
                then 1 else 0 end) as nom_alergia
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function otrosu_porcentaje($id_usuario=null){
        $sql = "SELECT  (case when ou.id_grupo_sanguineo IS NOT NULL
                and ou.id_grupo_sanguineo is not null
                then 1 else 0 end) as id_grupo_sanguineo,
                (case when ou.cert_covid IS NOT NULL then 1 else 0 end) as cert_covid,
                (case when ou.cert_vacu_covid IS NOT NULL then 1 else 0 end) as cert_vacu
                from otros_usuario ou
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function referenciaconvocatoriau_porcentaje($id_usuario=null){
        $sql = "SELECT (case when rc.id_referencia_laboral IS NOT NULL then 1 else 0 end) as id_referencia_laboral,
                (case when rc.otros IS NOT NULL then 1 else 0 end) as otros
                from referencia_convocatoria rc
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function documentarionu_porcentaje($id_usuario=null){
        $sql = "SELECT (case when (select count(1) from documentacion_usuario
                where documentacion_usuario.id_usuario=u.id_usuario and documentacion_usuario.cv_doc <>''
                and documentacion_usuario.estado=1)>0
                then 1 else 0 end) as cv_doc,
                (case when (select count(1) from documentacion_usuario
                where documentacion_usuario.id_usuario=u.id_usuario and documentacion_usuario.dni_doc <>''
                and documentacion_usuario.estado=1)>0
                then 1 else 0 end) as dni_doc,
                (case when (select count(1) from documentacion_usuario
                where documentacion_usuario.id_usuario=u.id_usuario and documentacion_usuario.recibo_doc <>''
                and documentacion_usuario.estado=1)>0
                then 1 else 0 end) as recibo_doc
                from users u
                WHERE u.id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function ropau_porcentaje($id_usuario=null){
        $sql = "select (case when ru.polo IS NOT NULL then 1 else 0 end) as polo,
                (case when ru.camisa IS NOT NULL then 1 else 0 end) as camisa,
                (case when ru.pantalon IS NOT NULL then 1 else 0 end) as pantalon,
                (case when ru.zapato IS NOT NULL then 1 else 0 end) as zapato
                from ropa_usuario ru
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function sist_pensu_porcentaje($id_usuario=null){
        $sql = "select (case when sp.id_respuestasp is not null then 1 else 0 end) as id_respuestasp,
                (case when sp.id_sistema_pensionario is not null then 1 else 0 end) as id_sistema_pensionario,
                (case when sp.id_afp is not null then 1 else 0 end) as id_afp
                from sist_pens_usuario sp
                WHERE id_usuario=$id_usuario";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_usuario($id_usuario=null){
        $anio=date('Y');
        $sql = "SELECT u.*, n.nom_nacionalidad,
                td.nom_tipo_documento,
                a.id_area,a.nom_area,pu.nom_puesto,est.nom_estado_civil,du.id_departamento,du.id_provincia,
                DATE_FORMAT(u.ini_funciones,'%d/%m/%Y') as inicio_funciones,e.nom_empresa,e.ruc_empresa,e.firma,e.direccion,
                CASE WHEN (SELECT count(1) FROM area ar WHERE CONCAT(',', ar.puestos, ',') like CONCAT('%',u.id_puesto, '%'))>0 THEN 'SI' ELSE 'NO' END AS encargado_p,
                ubi.cod_ubi AS centro_labores,(SELECT sl.nom_situacion_laboral FROM historico_colaborador hc
                LEFT JOIN situacion_laboral sl ON sl.id_situacion_laboral=hc.id_situacion_laboral
                WHERE hc.id_usuario=$id_usuario AND hc.estado=1
                ORDER BY hc.fec_inicio DESC
                LIMIT 1) AS nom_situacion_laboral,
                case when DATE_FORMAT(u.fec_nac, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d') then 1 else 0 end as cumple_anio,
                (select count(1) FROM saludo_cumpleanio_historial c where c.id_cumpleaniero='$id_usuario' and year(c.fec_reg)='$anio' and c.estado=1 and c.estado_registro=1) as cantidad_saludos,
                b.nom_gerencia,c.nom_modalidad_laboral,d.nombre as nom_horario,
                (select count(1) from users_historico_puesto p where p.estado=1 and p.id_usuario=$id_usuario) as cant_historico_puesto,
                (select count(1) from users_historico_centro_labores q where q.estado=1 and q.id_usuario=$id_usuario) as cant_historico_base,
                (select count(1) from users_historico_modalidadl r where r.estado=1 and r.id_usuario=$id_usuario) as cant_historico_modalidad,
                (select count(1) from users_historico_horario s where s.estado=1 and s.id_usuario=$id_usuario) as cant_historico_horario,
                (SELECT COUNT(1) FROM users_historico_horas_semanales s
                WHERE s.id_usuario=$id_usuario AND s.estado=1) AS cant_historico_horas_semanales,
                CASE WHEN SUBSTRING(u.fec_nac,1,1)=0 OR u.fec_nac IS NULL THEN ''
                ELSE DATE_FORMAT(u.fec_nac,'%d/%m/%Y') END AS fec_nac_baja,
                CASE WHEN SUBSTRING(u.ini_funciones,1,1)=0 OR u.ini_funciones IS NULL THEN ''
                ELSE DATE_FORMAT(u.ini_funciones,'%d/%m/%Y') END AS ini_funciones_baja,
                CASE WHEN SUBSTRING(u.fec_baja,1,1)=0 OR u.fec_baja IS NULL THEN ''
                ELSE DATE_FORMAT(u.fec_baja,'%d/%m/%Y') END AS fec_baja_baja,
                LOWER(CONCAT(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater)) AS nombre_completo,
                LOWER(pu.nom_puesto) AS nom_puesto_min,sg.nom_sub_gerencia,ub.cod_ubi AS ubicacion,
                b.id_gerencia
                from users u
                LEFT JOIN ubicacion ubi ON u.id_centro_labor = ubi.id_ubicacion
                LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                LEFT JOIN tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                LEFT JOIN puesto pu ON pu.id_puesto=u.id_puesto 
                LEFT JOIN area a ON a.id_area=pu.id_area
                LEFT JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento 
                LEFT JOIN gerencia b ON b.id_gerencia=sg.id_gerencia
                LEFT JOIN domicilio_users du on du.id_usuario=u.id_usuario
                LEFT JOIN estado_civil est on est.id_estado_civil =u.id_estado_civil
                left join empresas e on e.id_empresa=u.id_empresapl
                left join modalidad_laboral c on u.id_modalidad_laboral=c.id_modalidad_laboral
                left join horario d on u.id_horario=d.id_horario
                LEFT JOIN ubicacion ub ON ub.id_ubicacion=u.id_ubicacion
                where u.estado in (1,2,3,4) and u.id_usuario =".$id_usuario;
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_datoplanilla($id_usuario){
        $sql="SELECT h.*,e.nom_estado_usuario,s.nom_situacion_laboral,em.nom_empresa,DATE_FORMAT(h.fec_inicio,'%d/%m/%Y') as fecha_inicio,DATE_FORMAT(h.fec_fin,'%d/%m/%Y') as fecha_fin,
        (SELECT he2.id_historico_estado_colaborador FROM historico_estado_colaborador he2 WHERE he2.id_usuario=h.id_usuario and he2.estado=1 ORDER BY  he2.id_historico_estado_colaborador desc LIMIT 1) as id_historico_estado_colaborador,
        he.fec_fin as fec_fin_estado_colaborador,he.estado_fin_colaborador,he.id_historico_estado_colaborador as id_historico_estado_colaborador_eli,
        case when he.id_historico_estado_colaborador IS NOT NULL then '1' else '2' end as eliminar,
        case when h.estado=1 then 'Activo'
        when h.estado=3 and h.flag_cesado=1 then 'Cesado'
        when h.estado=3 and h.flag_cesado=0 then 'Terminado'
        when h.estado=4 then 'Renovación'
        when h.estado=5 then 'Reingreso' end as estado_colaborador,
        (h.sueldo+h.bono) as total,m.nom_motivo

        from historico_colaborador h
        left join vw_estado_usuario e on e.id_estado_usuario=h.estado
        left join situacion_laboral s on s.id_situacion_laboral=h.id_situacion_laboral
        left join empresas em on em.id_empresa=h.id_empresa
        left join historico_estado_colaborador he on h.id_usuario=he.id_usuario and h.fec_inicio=he.fec_inicio and he.estado=1
        left join motivo_baja_rrhh m on h.id_motivo_cese=m.id_motivo
        where h.id_usuario='".$id_usuario."' and h.estado in (1,3,4) ORDER BY h.id_historico_colaborador DESC";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_estado_usuario($id_estado_usuario=null){
        if(isset($id_estado_usuario) && $id_estado_usuario > 0){
            $sql = "select * from vw_estado_usuario where id_estado_usuario =".$id_estado_usuario;
        }
        else
        {
            $sql = "select * from vw_estado_usuario where id_estado_usuario<>2";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_nacionalidad_perfil($id_nacionalidad=null){
        if(isset($id_nacionalidad) && $id_nacionalidad > 0){
            $sql = "select * from nacionalidad where id_nacionalidad =".$id_nacionalidad;
        }
        else
        {
            $sql = "select * from nacionalidad";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_genero(){
        $sql = "SELECT * FROM genero WHERE estado='1' ";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_nivel_instruccion($id_nivel_instruccion=null){
        if(isset($id_nivel_instruccion) && $id_nivel_instruccion > 0){
            $sql = "select * from nivel_instruccion where id_nivel_instruccion =".$id_nivel_instruccion." and  estado=1";
        }
        else
        {
            $sql = "select * from nivel_instruccion where estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_dia(){
        $sql = "SELECT * FROM dia WHERE estado='1' ";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_mes(){
        $sql = "SELECT * FROM mes WHERE estado='1' ";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_anio(){
        $sql = "SELECT * FROM anio WHERE estado='1' order by cod_anio DESC";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_accesorio_polo($id_accesorio=null){
        if(isset($id_accesorio) && $id_accesorio > 0){
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1' and a.id_accesorio=1 ";
        }
        else
        {
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1' and a.id_accesorio=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_accesorio_camisa($id_accesorio=null){
        if(isset($id_accesorio) && $id_accesorio > 0){
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1' and a.id_accesorio=2 ";
        }
        else
        {
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1' and a.id_accesorio=2";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_accesorio_pantalon($id_accesorio=null){
        if(isset($id_accesorio) && $id_accesorio > 0){
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1'and a.id_accesorio=3 ";
        }
        else
        {
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1' and a.id_accesorio=3";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_accesorio_zapato($id_accesorio=null){
        if(isset($id_accesorio) && $id_accesorio > 0){
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1' and a.id_accesorio=4 ";
        }
        else
        {
            $sql = "SELECT t.*, a.nom_accesorio, a.id_accesorio FROM talla t
            LEFT JOIN accesorio a on a.id_accesorio=t.id_accesorio
            WHERE t.estado='1' and a.id_accesorio=4";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_gerencia($id_gerencia=null){
        if(isset($id_gerencia) && $id_gerencia > 0){
            $sql = "SELECT * FROM gerencia WHERE estado='1' and id_gerencia=$id_gerencia";
        }else{
            $sql = "SELECT g.*,d.direccion FROM gerencia g
            left join direccion d on g.id_direccion=d.id_direccion
            WHERE g.estado='1' ";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_area($id_gerencia=null, $id_area=null){
        if(isset($id_gerencia) && $id_gerencia > 0 && isset($id_area) && $id_area > 0){
            $sql = "SELECT t.*, a.nom_gerencia,d.direccion 
                    FROM area t
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=t.id_departamento
                    INNER JOIN gerencia a ON a.id_gerencia=sg.id_gerencia
                    INNER JOIN direccion d ON a.id_direccion=d.id_direccion
                    WHERE t.id_area=$id_area";
        }elseif(isset($id_gerencia) && $id_gerencia > 0){
            $sql = "SELECT t.*, a.nom_gerencia,d.direccion 
                    FROM area t
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=t.id_departamento
                    INNER JOIN gerencia a ON a.id_gerencia=sg.id_gerencia AND 
                    a.id_gerencia=$id_gerencia
                    INNER JOIN direccion d ON a.id_direccion=d.id_direccion
                    WHERE t.estado=1";
        }else{
            $sql = "SELECT t.*, a.nom_gerencia,d.direccion 
                    FROM area t
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=t.id_departamento
                    INNER JOIN gerencia a ON a.id_gerencia=sg.id_gerencia
                    INNER JOIN direccion d ON a.id_direccion=d.id_direccion
                    WHERE t.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_puesto($id_gerencia=null, $id_area=null){
        if(isset($id_gerencia) && $id_gerencia > 0 && isset($id_area) && $id_area > 0){
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area,d.direccion,n.nom_nivel FROM puesto t
                    LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                    LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                    left join direccion d on t.id_direccion=d.id_direccion
                    left join nivel_jerarquico n on t.id_nivel=n.id_nivel
                    WHERE t.estado='1' and t.id_gerencia=$id_gerencia and t.id_area=$id_area";
        }elseif(isset($id_gerencia) && $id_gerencia > 0 && $id_area==null){
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area,d.direccion,n.nom_nivel FROM puesto t
                LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                left join direccion d on t.id_direccion=d.id_direccion
                left join nivel_jerarquico n on t.id_nivel=n.id_nivel
                WHERE t.estado='1' and t.id_gerencia=$id_gerencia";
        }else{
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area,d.direccion,n.nom_nivel FROM puesto t
                LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                left join direccion d on t.id_direccion=d.id_direccion
                left join nivel_jerarquico n on t.id_nivel=n.id_nivel
                WHERE t.estado='1'";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_cargo($id_gerencia=null, $id_area=null, $id_puesto=null){
        if((isset($id_gerencia) && $id_gerencia > 0) && (isset($id_area) && $id_area > 0) &&
        (isset($id_puesto) && $id_puesto > 0)){
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area, p.nom_puesto FROM cargo t
                    LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                    LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                    LEFT JOIN puesto p on p.id_puesto=t.id_puesto and p.id_area=t.id_area and
                    p.id_gerencia=t.id_gerencia
                    WHERE t.estado='1' and t.id_gerencia=$id_gerencia and t.id_area=$id_area
                    and t.id_puesto=$id_puesto";
        }else{
            $sql = "SELECT t.*, g.nom_gerencia, a.nom_area, p.nom_puesto FROM cargo t
                    LEFT JOIN gerencia g on g.id_gerencia=t.id_gerencia
                    LEFT JOIN area a on a.id_area=t.id_area and a.id_gerencia=t.id_gerencia
                    LEFT JOIN puesto p on p.id_puesto=t.id_puesto and p.id_area=t.id_area and
                    p.id_gerencia=t.id_gerencia
                    WHERE t.estado='1'";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_ubicacion_l(){
        $sql = "SELECT cod_base from base b
        LEFT JOIN empresas e on b.id_empresa =e.id_empresa
        LEFT JOIN departamento d on b.id_departamento =d.id_departamento
        LEFT JOIN provincia p on b.id_provincia=p.id_provincia
        LEFT JOIN distrito i on b.id_distrito=i.id_distrito
        WHERE b.estado='1' group by cod_base";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_conoci_office($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from conoci_office where id_usuario =".$id_usuario;
        }
        else
        {
            $sql = "select * from conoci_office";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_ropa_usuario($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from ropa_usuario where id_usuario =".$id_usuario;
        }
        else
        {
            $sql = "select * from ropa_usuario";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_usuario($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT u.*, p.nom_puesto, m.nom_mes, g.cod_genero, g.nom_genero,a.cod_area,a.nom_area,t.cod_tipo_documento,ge.nom_gerencia,
                    u.usuario_email,(SELECT st.archivo FROM saludo_temporal st
                    WHERE st.id_usuario=u.id_usuario
                    LIMIT 1) AS archivo_saludo
                    FROM users u
                    left join area a on a.id_area=u.id_area
                    left join puesto p on p.id_puesto=u.id_puesto
                    left join mes m on m.id_mes=u.mes_nac
                    left join genero g on g.id_genero=u.id_genero
                    left join tipo_documento t on t.id_tipo_documento=u.id_tipo_documento
                    left join gerencia ge on ge.id_gerencia = u.id_gerencia
                    WHERE u.id_usuario=$id_usuario";
        }else{
            $sql = "SELECT * FROM parentesco";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_referenciafu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from referencia_familiar rf
                    LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from referencia_familiar rf
            LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
            where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_hijosu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_genero, p.nom_genero from hijos rf
                    LEFT JOIN genero p on p.id_genero=rf.id_genero
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_genero, p.nom_genero from hijos rf
            LEFT JOIN genero p on p.id_genero=rf.id_genero
            where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_contactoeu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
                    LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_parentesco, p.nom_parentesco from contacto_emergencia rf
            LEFT JOIN parentesco p on p.id_parentesco=rf.id_parentesco
            where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_estudiosgu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, p.id_grado_instruccion, p.nom_grado_instruccion from estudios_generales rf
                    LEFT JOIN grado_instruccion p on p.id_grado_instruccion=rf.id_grado_instruccion
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, p.id_grado_instruccion, p.nom_grado_instruccion from estudios_generales rf
            LEFT JOIN grado_instruccion p on p.id_grado_instruccion=rf.id_grado_instruccion
            where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_idiomasu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*, pl.id_nivel_instruccion as id_nivel_instruccionl, pl.nom_nivel_instruccion
                    as nom_nivel_instruccionl, pe.id_nivel_instruccion as id_nivel_instruccione,
                    pe.nom_nivel_instruccion as nom_nivel_instruccione, pc.id_nivel_instruccion as id_nivel_instruccionc,
                    pc.nom_nivel_instruccion as nom_nivel_instruccionc, i.id_idioma, i.nom_idioma
                    from conoci_idiomas rf
                    LEFT JOIN idioma i on i.id_idioma = rf.nom_conoci_idiomas
                    LEFT JOIN nivel_instruccion pl on pl.id_nivel_instruccion=rf.lect_conoci_idiomas
                    LEFT JOIN nivel_instruccion pe on pe.id_nivel_instruccion=rf.escrit_conoci_idiomas
                    LEFT JOIN nivel_instruccion pc on pc.id_nivel_instruccion=rf.conver_conoci_idiomas
                    where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.*, pl.id_nivel_instruccion as id_nivel_instruccionl, pl.nom_nivel_instruccion
                    as nom_nivel_instruccionl, pe.id_nivel_instruccion as id_nivel_instruccione,
                    pe.nom_nivel_instruccion as nom_nivel_instruccione, pc.id_nivel_instruccion as id_nivel_instruccionc,
                    pc.nom_nivel_instruccion as nom_nivel_instruccionc, i.id_idioma, i.nom_idioma
                    from conoci_idiomas rf
                    LEFT JOIN idioma i on i.id_idioma = rf.nom_conoci_idiomas
                    LEFT JOIN nivel_instruccion pl on pl.id_nivel_instruccion=rf.lect_conoci_idiomas
                    LEFT JOIN nivel_instruccion pe on pe.id_nivel_instruccion=rf.escrit_conoci_idiomas
                    LEFT JOIN nivel_instruccion pc on pc.id_nivel_instruccion=rf.conver_conoci_idiomas
                    where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_cursoscu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*
                    from curso_complementario rf where rf.id_usuario =".$id_usuario." and rf.estado=1";

        }
        else
        {
            $sql = "SELECT rf.*
                    from curso_complementario rf where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_cuentab($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from cuenta_bancaria where id_usuario =".$id_usuario;
        }
        else
        {
            $sql = "select * from cuenta_bancaria";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_gestacion($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from gestacion_usuario where id_usuario =".$id_usuario." and estado=1";
        }
        else
        {
            $sql = "select * from gestacion_usuario where estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_referenciac($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from referencia_convocatoria where id_usuario =".$id_usuario;
        }
        else
        {
            $sql = "select * from referencia_convocatoria";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_sist_pensu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from sist_pens_usuario where id_usuario =".$id_usuario." and estado=1";
        }
        else
        {
            $sql = "select * from sist_pens_usuario where estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_documentacion($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from documentacion_usuario where id_usuario =".$id_usuario." and estado=1";
        }
        else{
            $sql = "select * from documentacion_usuario where estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_id_otros($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "select * from otros_usuario where id_usuario =".$id_usuario." and estado=1";
        }
        else
        {
            $sql = "select * from otros_usuario where estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_enfermedadu($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*
                    from enfermedad_usuario rf where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else{
            $sql = "SELECT rf.*
            from enfermedad_usuario rf where rf.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_alergia($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT u.alergia, a.* FROM users u
                    LEFT JOIN alergia_usuario a on u.id_usuario=a.id_usuario
                    where u.id_usuario =".$id_usuario." and a.estado=1";
        }
        else
        {
            $sql = "SELECT u.alergia, a.* FROM users u
                    LEFT JOIN alergia_usuario a on u.id_usuario=a.id_usuario
                    where a.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_experiencial($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT rf.*
                    from experiencia_laboral rf where rf.id_usuario =".$id_usuario." and rf.estado=1";
        }
        else
        {
            $sql = "SELECT rf.* from experiencia_laboral rf where rf.estado=1";
            //"SELECT rf.* from experiencia_laboral rf where rf.id_usuario =".$id_usuario." and rf.estado=1";;
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_horario($id_horario=null){
        if(isset($id_horario) && $id_horario>0){
            $sql = "SELECT h.* FROM horario h
            WHERE h.id_horario=$id_horario";
        }else{
            $sql = "SELECT h.*,(SELECT group_concat(distinct d.nom_dia ORDER by d.dia ASC) FROM horario_dia d WHERE d.id_horario=h.id_horario and d.estado=1) as dias FROM horario h
            WHERE h.estado='1' ";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
    
    function get_list_hijosucount($id_usuario=null){
        if(isset($id_usuario) && $id_usuario > 0){
            $sql = "SELECT COUNT(*) as totalhijos from hijos hj
                    where hj.id_usuario =".$id_usuario." and hj.estado=1";
        }
        else
        {
            $sql = "SELECT hj.*, p.id_genero, p.nom_genero from hijos hj
            where hj.estado=1";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}

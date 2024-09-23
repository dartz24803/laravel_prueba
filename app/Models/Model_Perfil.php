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
}

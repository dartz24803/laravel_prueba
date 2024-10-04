<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mercaderia extends Model
{
    use HasFactory;

    static function get_list_mercaderia($dato=null){
        if(isset($dato)){
            $sql = "select dpln.semana, dpln.anio,
            dpln.user_reg as 'Usuario',
            sum(total) as total, dpln.estado, dpln.cierre
            from tge_articulos art(nolock)
            inner join tge_sub_familias sfa(nolock)
            on art.sfa_codigo=sfa.sfa_codigo
            inner join vw_colores clr(nolock)
            on art.art_color=par_codcolor
            inner join vw_usuarios usr(nolock)
            on usu_codigo=par_codusuario
            left join tge_tallas tl(nolock)
            on art.art_talla =Rtrim(tl.tall_codigo)
            inner join dpedido_lnuno dpln(nolock)
            on Rtrim(art.art_codigo)=Rtrim(dpln.codigo_barra) and dpln.estado in (1,3)
            Where art.cia_codigo='00001' and semana='".$dato['semana']."' and anio='".$dato['anio']."'
            group by semana, anio, dpln.user_reg, dpln.estado, dpln.cierre";
        }else{
            $semana=date('W');
            $anio=date('Y');
            $sql = "select dpln.semana, dpln.anio,
            dpln.user_reg as 'Usuario',
            sum(total) as total, dpln.estado, dpln.cierre
            from tge_articulos art(nolock)
            inner join tge_sub_familias sfa(nolock)
            on art.sfa_codigo=sfa.sfa_codigo
            inner join vw_colores clr(nolock)
            on art.art_color=par_codcolor
            inner join vw_usuarios usr(nolock)
            on usu_codigo=par_codusuario
            left join tge_tallas tl(nolock)
            on art.art_talla =Rtrim(tl.tall_codigo)
            inner join dpedido_lnuno dpln(nolock)
            on Rtrim(art.art_codigo)=Rtrim(dpln.codigo_barra) and dpln.estado in (1,3)
            Where art.cia_codigo='00001' and semana='$semana' and anio='$anio'
            group by semana, anio, dpln.user_reg, dpln.estado, dpln.cierre";
        }
        $query = DB::connection('sqlsrv')->select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_valida_cierre($semana,$anio){
        $sql = "select * from pedido_lnuno where estado=1 and semana=$semana and anio=$anio";

        $query = DB::connection('sqlsrv')->select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_num_cierre($semana,$anio){
        $sql = "select case when max(cierre) is not null then max(cierre) else 0 end as cantidad
        from pedido_lnuno
        where semana=$semana and anio=$anio and estado=1";

        $query = DB::connection('sqlsrv')->select($sql);
        return json_decode(json_encode($query), true);
    }

    static function cierre_mercaderia($semana,$cantcierre, $anio){
        $id_usuario= substr($_SESSION['usuario'][0]['usuario_nombres'],0,1).$_SESSION['usuario'][0]['usuario_apater'];
        $sql1 = "EXEC usp_replica_requ_infosap '$anio', '$semana'";
        DB::connection('sqlsrv')->statement($sql1, [$anio, $semana]);

        $sql2 = "UPDATE pedido_lnuno SET estado=3, cierre='$cantcierre', user_act='$id_usuario', fec_act=getdate()
                where estado=1 and semana=$semana";
        DB::connection('sqlsrv')->update($sql2, [$cantcierre, $id_usuario, $semana]);

        $sql3 = "UPDATE dpedido_lnuno SET estado=3, cierre='$cantcierre', user_act='$id_usuario', fec_act=getdate()
                WHERE estado=1 AND semana=$semana";
        DB::connection('sqlsrv')->update($sql3, [$cantcierre, $id_usuario, $semana]);
    }

    static function get_list_mercaderiat($semana=null){
        $sql = "select * from dpedido_lnuno
                Where estado in (1,3) and semana=$semana";

        $query = DB::connection('sqlsrv')->select($sql);
        return json_decode(json_encode($query), true);
    }


    static function get_list_reparto($usuario=null, $semana=null, $anio=null, $cierre=null){
        if($cierre==null || $cierre==""){
            $cierre=" and cierre is null ";
        }else{
            $cierre=" and cierre=".$cierre;
        }

            $sql = "SELECT dpln.semana,dpln.anio,
            par_desusuario as 'Usuario',
            sfa_descrip, art_estiloprd, dpln.user_reg
            from tge_articulos art(nolock)
            inner join tge_sub_familias sfa(nolock)
            on art.sfa_codigo=sfa.sfa_codigo
            inner join vw_colores clr(nolock)
            on art.art_color=par_codcolor
            inner join vw_usuarios usr(nolock)
            on usu_codigo=par_codusuario
            left join tge_tallas tl(nolock)
            on art.art_talla =Rtrim(tl.tall_codigo)
            inner join dpedido_lnuno dpln(nolock)
            on Rtrim(art.art_codigo)=Rtrim(dpln.codigo_barra) and dpln.estado in (1,3)
            --left join dpedido_lnuno dplne(nolock) on dplne.estilo=lanumerouno.control_ubicacion.estilo
            Where art.cia_codigo='00001' and semana='$semana' and anio='$anio' and user_reg='$usuario' $cierre
            group by semana, anio, par_desusuario,sfa_descrip, art_estiloprd, dpln.user_reg
            order by art_estiloprd, par_desusuario,sfa_descrip, sum(total) desc";

        $query = DB::connection('sqlsrv')->select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_repartod($par_desusuario, $sfa_descrip, $art_estiloprd, $usuario, $semana, $anio, $cierre=null){
        if($cierre==null || $cierre==""){$cierre=" and cierre is null ";}else{
            $cierre=" and cierre=".$cierre;}

        $sql = "SELECT dpln.semana, dpln.anio, par_desusuario as 'Usuario', dpln.RN,
		sfa_descrip, art_estiloprd, art_descrip,par_desccolor,tall_nombre, art_codigo as 'SKU',
        sum(stock) as stock, sum(B01) as B01, sum(B02) as B02, sum(B03) as B03, sum(B04) as B04,
        sum(B05) as B05, sum(B06) as B06, sum(B07) as B07, sum(B08) as B08, sum(B09) as B09,
        sum(B10) as B10, sum(B11) as B11, sum(B12) as B12, sum(B13) as B13, sum(B14) as B14, sum(B15) as B15,
        sum(B16) as B16, sum(B17) as B17, sum(B18) as B18, sum(B19) as B19, sum(B20) as B20, sum(BEC) as BEC,
        sum(total) as total, sum(observacion) as observacion, ubicacion
        from tge_articulos art(nolock)
        inner join tge_sub_familias sfa(nolock) on art.sfa_codigo=sfa.sfa_codigo
        inner join vw_colores clr(nolock) on art.art_color=par_codcolor
        inner join vw_usuarios usr(nolock) on usu_codigo=par_codusuario
        left join tge_tallas tl(nolock) on art.art_talla =Rtrim(tl.tall_codigo)
        inner join dpedido_lnuno dpln(nolock) on Rtrim(art.art_codigo)=Rtrim(dpln.codigo_barra) and dpln.estado in (1,3)
        Where art.cia_codigo='00001' and par_desusuario='".$par_desusuario."' and
        sfa_descrip='".$sfa_descrip."' and art_estiloprd='".$art_estiloprd."' and user_reg='$usuario'
        and semana='$semana' and anio='$anio' $cierre
        group by semana, anio, par_desusuario,sfa_descrip, art_estiloprd, art_descrip,par_desccolor,tall_nombre,
        tl.tall_orden, ubicacion, dpln.RN, art_codigo
        order by par_desusuario,sfa_descrip, art_estiloprd, art_descrip, par_desccolor,
        tl.tall_orden asc;";
        $query = DB::connection('sqlsrv')->select($sql);
        return json_decode(json_encode($query), true);
    }

    static function get_list_control_ubicaciones($id_control_ubicacion=null){
        if(isset($id_control_ubicacion) && $id_control_ubicacion>0){
            $sql = "SELECT * FROM control_ubicacion
                    WHERE id_control_ubicacion = '$id_control_ubicacion'";
        }else{
            $sql = "SELECT c.*,n.numero,p.nom_percha
            FROM control_ubicacion c
            left join nicho n on c.id_nicho=n.id_nicho
            left join percha p on n.id_percha=p.id_percha
            WHERE c.estado = '1'  ORDER BY n.nom_nicho";
        }

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_nicho($id_nicho=null){
        if(isset($id_nicho) && $id_nicho>0){
            $sql = "SELECT n.*,p.nom_percha
            FROM nicho n
            left join percha p on n.id_percha=p.id_percha
            WHERE n.id_nicho=$id_nicho ORDER BY n.nom_nicho";
        }else{
            $sql = "SELECT n.*,p.nom_percha, concat(p.nom_percha,n.numero) as nicho
            FROM nicho n
            left join percha p on n.id_percha=p.id_percha
            WHERE n.estado=1 ORDER BY n.nom_nicho";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_estilo_infosap($t){
        $v=" HAVING sum(e.stk_stkfmes)> 0";
        if($t==1){
            $v="";
        }
        $sql = "SELECT
        b.art_estiloprd,sum(e.stk_stkfmes) as stock

        from mvm_stock_x_fecha e
        inner join tge_articulos b on e.stk_empresa=b.cia_codigo and e.art_codigo=b.art_codigo
        Where exists (select 1 from seg_tbl_opci_conf where cnf_codi_secc like 'ALMACENES_CENTRALES_WEB%' and cnf_llav_secc like 'ALM%' and
            left(cnf_Valo_llav,5)=e.stk_empresa and
            right(rtrim(cnf_Valo_llav),2)=e.stk_sucursal
          ) and
        e.stk_ano=Year(Getdate()) and
        e.stk_mes=Month(Getdate()) and
        e.stk_stkfmes!=0
        group by b.art_estiloprd $v";

        return DB::connection('sqlsrv')->select($sql);
    }
}

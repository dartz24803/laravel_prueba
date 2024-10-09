<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequerimientoSurtido extends Model
{
    use HasFactory;

    
    function insert_cuenta($dato, $user_duplicado = null){
        $id_usuario = substr(session('usuario')->usuario_nombres, 0, 1) . session('usuario')->usuario_apater;
        $semana = $dato['semana'];
        if (isset($user_duplicado)) {
            $sql = "insert into dpedido_lnunot (empresa, costo, pc, pv, pp, pc_b4, pv_b4, pp_b4, 
                    tipo_usuario, tipo_prenda, codigo_barra, autogenerado, estilo, decripcion, color, 
                    talla, stock, B01, B02, B03, B04, B05, B06, B07, B08, B09, B10, B11, B13, B14, B15, 
                    B16, B17, B18, semana, user_reg, estado, fec_reg, user_duplicado, B12, BEC, RN, B19, B20,
                    caracter)
                    values 
                    ('" . $dato['empresa'] . "', '" . $dato['costo'] . "', '" . $dato['pc'] . "', '" . $dato['pv'] . "',
                    '" . $dato['pp'] . "', '" . $dato['pc_b4'] . "', '" . $dato['pv_b4'] . "', '" . $dato['pp_b4'] . "',
                    '" . $dato['tipo_usuario'] . "', '" . $dato['tipo_prenda'] . "', '" . $dato['codigo_barra'] . "', 
                    '" . $dato['autogenerado'] . "', '" . $dato['estilo'] . "', '" . $dato['decripcion'] . "',
                    '" . $dato['color'] . "', '" . $dato['talla'] . "', '" . $dato['stock'] . "', 
                    '" . $dato['B01'] . "', '" . $dato['B02'] . "', '" . $dato['B03'] . "',
                    '" . $dato['B04'] . "', '" . $dato['B05'] . "', '" . $dato['B06'] . "', '" . $dato['B07'] . "',
                    '" . $dato['B08'] . "', '" . $dato['B09'] . "', '" . $dato['B10'] . "', '" . $dato['B11'] . "',
                    '" . $dato['B13'] . "', '" . $dato['B14'] . "', '" . $dato['B15'] . "', '" . $dato['B16'] . "',
                    '" . $dato['B17'] . "', '" . $dato['B18'] . "', $semana, '$id_usuario',1, getdate(),
                    '$user_duplicado', '" . $dato['B12'] . "', '" . $dato['BEC'] . "', '" . $dato['RN'] . "',
                    '" . $dato['B19'] . "', '" . $dato['B20'] . "', '" . $dato['caracter'] . "')";
        } else {
            if ($dato['caracter'] != "") {

                $sql = "insert into dpedido_lnunot (empresa, costo, pc, pv, pp, pc_b4, pv_b4, pp_b4, 
                        tipo_usuario, tipo_prenda, codigo_barra, autogenerado, estilo, decripcion, color, 
                        talla, semana, user_reg, estado, fec_reg, BEC, RN, caracter) values 
                        ('" . $dato['empresa'] . "', '" . $dato['costo'] . "', '" . $dato['pc'] . "', '" . $dato['pv'] . "',
                        '" . $dato['pp'] . "', '" . $dato['pc_b4'] . "', '" . $dato['pv_b4'] . "', '" . $dato['pp_b4'] . "',
                        '" . $dato['tipo_usuario'] . "', '" . $dato['tipo_prenda'] . "', '" . $dato['codigo_barra'] . "', 
                        '" . $dato['autogenerado'] . "', '" . $dato['estilo'] . "', '" . $dato['decripcion'] . "',
                        '" . $dato['color'] . "', '" . $dato['talla'] . "', 
                        $semana, '$id_usuario',1, getdate(),
                        '" . $dato['BEC'] . "', '" . $dato['RN'] . "', '" . $dato['caracter'] . "')";
            } else {
                $sql = "insert into dpedido_lnunot (empresa, costo, pc, pv, pp, pc_b4, pv_b4, pp_b4, 
                        tipo_usuario, tipo_prenda, codigo_barra, autogenerado, estilo, decripcion, color, 
                        talla, stock, B01, B02, B03, B04, B05, B06, B07, B08, B09, B10, B11, B13, B14, B15, 
                        B16, B17, B18, semana, user_reg, estado, fec_reg, B12, BEC, RN, B19, B20) values 
                        ('" . $dato['empresa'] . "', '" . $dato['costo'] . "', '" . $dato['pc'] . "', '" . $dato['pv'] . "',
                        '" . $dato['pp'] . "', '" . $dato['pc_b4'] . "', '" . $dato['pv_b4'] . "', '" . $dato['pp_b4'] . "',
                        '" . $dato['tipo_usuario'] . "', '" . $dato['tipo_prenda'] . "', '" . $dato['codigo_barra'] . "', 
                        '" . $dato['autogenerado'] . "', '" . $dato['estilo'] . "', '" . $dato['decripcion'] . "',
                        '" . $dato['color'] . "', '" . $dato['talla'] . "', '" . $dato['stock'] . "', 
                        '" . $dato['B01'] . "', '" . $dato['B02'] . "', '" . $dato['B03'] . "',
                        '" . $dato['B04'] . "', '" . $dato['B05'] . "', '" . $dato['B06'] . "', '" . $dato['B07'] . "',
                        '" . $dato['B08'] . "', '" . $dato['B09'] . "', '" . $dato['B10'] . "', '" . $dato['B11'] . "',
                        '" . $dato['B13'] . "', '" . $dato['B14'] . "', '" . $dato['B15'] . "', '" . $dato['B16'] . "',
                        '" . $dato['B17'] . "', '" . $dato['B18'] . "', $semana, '$id_usuario',1, getdate(),
                        '" . $dato['B12'] . "', '" . $dato['BEC'] . "', '" . $dato['RN'] . "', '" . $dato['B19'] . "',
                        '" . $dato['B20'] . "')";
            }
        }
        DB::connection('sqlsrv')->insert($sql);

        $sql2 = "UPDATE dpedido_lnunot set total=B12+BEC+B01+B02+B03+B04+B05+B06+B07+B08+B09+B10+B11+B13+B14+B15+B16+B17+B18+B20+B19,
                observacion=stock-total";
        DB::connection('sqlsrv')->update($sql2);
    }

    
    function insert_ccuenta($data)
    {
        $id_usuario = substr(session('usuario')->usuario_nombres, 0, 1) . session('usuario')->usuario_apater;
        $semana = $data['semana'];

        $sql3 = "insert into dpedido_lnuno (id_pedido_lnuno, empresa, costo, pc, pv, pp, pc_b4, 
        pv_b4, pp_b4, tipo_usuario, tipo_prenda, codigo_barra, autogenerado, estilo, decripcion, 
        color, talla, stock, total, observacion, B01, B02, B03, B04, B05, B06, B07, B08, B09, B10, B11, B13, 
        B14, B15, B16, B17, B18, B19, B20, semana, anio, estado, user_reg, fec_reg, B12, BEC, RN, archivo) 
        select " . $data['id_pedido_lnuno'] . ", empresa, costo, pc, pv, pp, pc_b4, pv_b4, pp_b4,
        '" . $data['tipo_usuario'] . "', tipo_prenda, codigo_barra, autogenerado, estilo, decripcion, 
        color, talla, stock, total, observacion, B01, B02, B03, B04, B05, B06, B07, B08, B09, B10, 
        B11, B13, B14, B15, B16, B17, B18, B19, B20, semana, " . $data['anio'] . ",estado, user_reg, fec_reg, B12, BEC, RN, " . $data['archivo'] . "
        from dpedido_lnunot where user_reg='$id_usuario' and semana=$semana 
        and tipo_usuario='" . $data['tipo_usuario'] . "'";
        DB::connection('sqlsrv')->insert($sql3);
    }
    
    function get_list_duplicado($usuario, $semana){
        $sql = "SELECT * FROM dpedido_lnunot where user_reg='" . $usuario . "' and 
                semana=$semana and estado=1 and (caracter is not null or user_duplicado is not null)";
        
        $result = DB::connection('sqlsrv')->select($sql);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

}

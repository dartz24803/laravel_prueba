<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\CajaChicaPagoTemporal;
use App\Models\Categoria;
use App\Models\Empresas;
use App\Models\Notificacion;
use App\Models\Pago;
use App\Models\SubCategoria;
use App\Models\TipoMoneda;
use App\Models\Ubicacion;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SubGerencia;
use App\Models\TipoComprobante;
use App\Models\TipoPago;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CajaChicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('finanzas.tesoreria.caja_chica.index',compact('list_notificacion','list_subgerencia'));
    }

    public function list(Request $request)
    {
        $list_caja_chica = CajaChica::get_list_caja_chica();
        return view('finanzas.tesoreria.caja_chica.lista', compact('list_caja_chica'));
    }

    public function create_mo()
    {
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)
                        ->orderBy('cod_ubi','ASC')->get();
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('activo',1)
                        ->where('estado',1)->orderBy('nom_empresa','ASC')->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        return view('finanzas.tesoreria.caja_chica.modal_registrar_mo', compact('list_ubicacion','list_empresa','list_tipo_moneda'));
    }

    public function traer_sub_categoria_mo(Request $request)
    {
        $get_id = Categoria::where('id_categoria_mae',3)
                ->where('id_ubicacion',$request->id_ubicacion)
                ->where('nom_categoria','MOVILIDAD')->where('estado',1)->first();

        if(isset($get_id->id_categoria)){
            $list_sub_categoria = SubCategoria::where('id_categoria',$get_id->id_categoria)
                                ->where('estado',1)->orderBy('nombre','ASC')->get();
        }else{
            $list_sub_categoria = [];
        }
        return view('finanzas.tesoreria.caja_chica.sub_categoria', compact('list_sub_categoria'));
    }

    public function consultar_ruc(Request $request)
    {
        $request->validate([
            'ruc' => 'required|size:11'
        ], [
            'ruc.required' => 'Debe ingresar RUC.',
            'ruc.size' => 'Debe ingresar RUC válido (11 dígitos).'
        ]);

        $client = new Client();
        $body = '';
        $request = new Psr7Request('GET', 'https://dniruc.apisperu.com/api/v1/ruc/'.$request->ruc.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InNpc3RlbWFzbGFudW1lcm91bm9AZ21haWwuY29tIn0.FP8eTZr1p_oKvGXN3Wcc8mZd4fBuyAYvSYy28Qkgg0E', [], $body);
        $res = $client->sendAsync($request)->wait();
        $responseData = json_decode($res->getBody(), true);

        if(isset($responseData['success'])){
            echo "error@@@".$responseData['message'];
        }else{
            echo $responseData['razonSocial'];
        }
    }

    public function store_mo(Request $request)
    {
        $request->validate([
            'id_ubicacion' => 'gt:0',
            'fecha' => 'required',
            'id_sub_categoria' => 'gt:0',
            'id_empresa' => 'gt:0',
            'total' => 'required|gt:0',
            'ruta' => 'gt:0',
            'punto_partida' => 'required_if:ruta,1',
            'punto_llegada' => 'required'
        ], [
            'id_ubicacion.gt' => 'Debe seleccionar ubicación.',
            'fecha.required' => 'Debe ingresar fecha.',
            'id_sub_categoria.gt' => 'Debe seleccionar sub-categoría.',
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'total.required' => 'Debe ingresar total.',
            'total.gt' => 'Debe ingresar total mayor a 0.',
            'ruta.gt' => 'Debe seleccionar ruta.',
            'punto_partida.required_if' => 'Debe ingresar punto de partida.',
            'punto_llegada.required' => 'Debe ingresar punto de llegada.'
        ]);

        $comprobante = "";
        if ($_FILES["comprobante"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["comprobante"]["name"];
                $source_file = $_FILES['comprobante']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CAJA_CHICA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante = "https://lanumerounocloud.com/intranet/CAJA_CHICA/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        $get_id = SubCategoria::findOrFail($request->id_sub_categoria);

        CajaChica::create([
            'id_ubicacion' => $request->id_ubicacion,
            'id_categoria' => $get_id->id_categoria,
            'fecha' => $request->fecha,
            'id_sub_categoria' => $request->id_sub_categoria,
            'id_empresa' => $request->id_empresa,
            'id_tipo_moneda' => $request->id_tipo_moneda,
            'total' => $request->total,
            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'ruta' => $request->ruta,
            'id_tipo_comprobante' => 1,
            'punto_partida' => $request->punto_partida,
            'punto_llegada' => $request->punto_llegada,
            'comprobante' => $comprobante,
            'estado_c' => 1,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function create_pv()
    {
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)
                        ->orderBy('cod_ubi','ASC')->get();
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('activo',1)
                        ->where('estado',1)->orderBy('nom_empresa','ASC')->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        $list_tipo_comprobante = TipoComprobante::all();
        return view('finanzas.tesoreria.caja_chica.modal_registrar_pv', compact(
            'list_ubicacion',
            'list_empresa',
            'list_tipo_moneda',
            'list_tipo_comprobante'
        ));
    }

    public function traer_categoria_pv(Request $request)
    {
        $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',3)
                        ->where('id_ubicacion',$request->id_ubicacion)->where('nom_categoria','!=','MOVILIDAD')
                        ->where('estado',1)->get();
        return view('finanzas.tesoreria.caja_chica.categoria', compact('list_categoria'));
    }

    public function traer_sub_categoria_pv(Request $request)
    {
        $list_sub_categoria = SubCategoria::select('id','nombre')->where('id_categoria',$request->id_categoria)
                            ->where('estado',1)->get();
        return view('finanzas.tesoreria.caja_chica.sub_categoria', compact('list_sub_categoria'));
    }

    public function store_pv(Request $request)
    {
        $request->validate([
            'id_ubicacion' => 'gt:0',
            'id_categoria' => 'gt:0',
            'fecha' => 'required',
            'id_sub_categoria' => 'gt:0',
            'id_empresa' => 'gt:0',
            'total' => 'required|gt:0',
            'n_comprobante' => 'required',
            'id_tipo_comprobante' => 'gt:0',
            'punto_partida' => 'required'
        ], [
            'id_ubicacion.gt' => 'Debe seleccionar ubicación.',
            'id_categoria.gt' => 'Debe seleccionar categoría.',
            'fecha.required' => 'Debe ingresar fecha.',
            'id_sub_categoria.gt' => 'Debe seleccionar sub-categoría.',
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'total.required' => 'Debe ingresar total.',
            'total.gt' => 'Debe ingresar total mayor a 0.',
            'n_comprobante.required' => 'Debe ingresar n° comprobante.',
            'id_tipo_comprobante.gt' => 'Debe seleccionar tipo comprobante.',
            'punto_partida.required' => 'Debe ingresar descripción.'
        ]);

        $comprobante = "";
        if ($_FILES["comprobante"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["comprobante"]["name"];
                $source_file = $_FILES['comprobante']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CAJA_CHICA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante = "https://lanumerounocloud.com/intranet/CAJA_CHICA/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        CajaChica::create([
            'id_ubicacion' => $request->id_ubicacion,
            'id_categoria' => $request->id_categoria,
            'fecha' => $request->fecha,
            'id_sub_categoria' => $request->id_sub_categoria,
            'id_empresa' => $request->id_empresa,
            'id_tipo_moneda' => $request->id_tipo_moneda,
            'total' => $request->total,
            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'n_comprobante' => $request->n_comprobante,
            'id_tipo_comprobante' => $request->id_tipo_comprobante,
            'punto_partida' => $request->punto_partida,
            'comprobante' => $comprobante,
            'estado_c' => 1,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function edit($id)
    {
        $get_id = CajaChica::findOrFail($id);
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)
                        ->orderBy('cod_ubi','ASC')->get();
        $list_sub_categoria = SubCategoria::where('id_categoria',$get_id->id_categoria)
                            ->where('estado',1)->orderBy('nombre','ASC')->get();
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('activo',1)
                        ->where('estado',1)->orderBy('nom_empresa','ASC')->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        $valida = Categoria::select('nom_categoria')->where('id_categoria',$get_id->id_categoria)
                ->first();                      
        if($valida->nom_categoria=="MOVILIDAD"){
            return view('finanzas.tesoreria.caja_chica.modal_editar_mo', compact(
                'get_id',
                'list_ubicacion',
                'list_sub_categoria',
                'list_empresa',
                'list_tipo_moneda'
            ));
        }else{
            $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',3)
                            ->where('id_ubicacion',$get_id->id_ubicacion)->where('nom_categoria','!=','MOVILIDAD')
                            ->where('estado',1)->get();
            $list_tipo_comprobante = TipoComprobante::all();                            
            return view('finanzas.tesoreria.caja_chica.modal_editar_pv', compact(
                'get_id',
                'list_ubicacion',
                'list_categoria',
                'list_sub_categoria',
                'list_empresa',
                'list_tipo_moneda',
                'list_tipo_comprobante'
            ));
        }
    }

    public function download($id)
    {
        $get_id = CajaChica::findOrFail($id);

        // URL del archivo
        $url = $get_id->comprobante;

        // Crear un cliente Guzzle
        $client = new Client();

        // Realizar la solicitud GET para obtener el archivo
        $response = $client->get($url);

        // Obtener el contenido del archivo
        $content = $response->getBody()->getContents();

        // Obtener el nombre del archivo desde la URL
        $filename = basename($url);

        // Devolver el contenido del archivo en la respuesta
        return response($content, 200)
                    ->header('Content-Type', $response->getHeaderLine('Content-Type'))
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function update_mo(Request $request, $id)
    {
        $request->validate([
            'id_ubicacione' => 'gt:0',
            'fechae' => 'required',
            'id_sub_categoriae' => 'gt:0',
            'id_empresae' => 'gt:0',
            'totale' => 'required|gt:0',
            'rutae' => 'gt:0',
            'punto_partidae' => 'required_if:ruta,1',
            'punto_llegadae' => 'required'
        ], [
            'id_ubicacione.gt' => 'Debe seleccionar ubicación.',
            'fechae.required' => 'Debe ingresar fecha.',
            'id_sub_categoriae.gt' => 'Debe seleccionar sub-categoría.',
            'id_empresae.gt' => 'Debe seleccionar empresa.',
            'totale.required' => 'Debe ingresar total.',
            'totale.gt' => 'Debe ingresar total mayor a 0.',
            'rutae.gt' => 'Debe seleccionar ruta.',
            'punto_partidae.required_if' => 'Debe ingresar punto de partida.',
            'punto_llegadae.required' => 'Debe ingresar punto de llegada.'
        ]);

        $get_id = CajaChica::findOrFail($id);

        $comprobante = $get_id->comprobante;
        if ($_FILES["comprobantee"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->comprobante!=""){
                    ftp_delete($con_id, "CAJA_CHICA/".basename($get_id->comprobante));
                }

                $path = $_FILES["comprobantee"]["name"];
                $source_file = $_FILES['comprobantee']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CAJA_CHICA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante = "https://lanumerounocloud.com/intranet/CAJA_CHICA/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        $get_id = SubCategoria::findOrFail($request->id_sub_categoriae);

        CajaChica::findOrFail($id)->update([
            'id_ubicacion' => $request->id_ubicacione,
            'id_categoria' => $get_id->id_categoria,
            'fecha' => $request->fechae,
            'id_sub_categoria' => $request->id_sub_categoriae,
            'id_empresa' => $request->id_empresae,
            'id_tipo_moneda' => $request->id_tipo_monedae,
            'total' => $request->totale,
            'ruc' => $request->ruce,
            'razon_social' => $request->razon_sociale,
            'ruta' => $request->rutae,
            'id_tipo_comprobante' => 1,
            'punto_partida' => $request->punto_partidae,
            'punto_llegada' => $request->punto_llegadae,
            'comprobante' => $comprobante,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function update_pv(Request $request, $id)
    {
        $request->validate([
            'id_ubicacione' => 'gt:0',
            'id_categoriae' => 'gt:0',
            'fechae' => 'required',
            'id_sub_categoriae' => 'gt:0',
            'id_empresae' => 'gt:0',
            'totale' => 'required|gt:0',
            'n_comprobantee' => 'required',
            'id_tipo_comprobantee' => 'gt:0',
            'punto_partidae' => 'required'
        ], [
            'id_ubicacione.gt' => 'Debe seleccionar ubicación.',
            'id_categoriae.gt' => 'Debe seleccionar categoría.',
            'fechae.required' => 'Debe ingresar fecha.',
            'id_sub_categoriae.gt' => 'Debe seleccionar sub-categoría.',
            'id_empresae.gt' => 'Debe seleccionar empresa.',
            'totale.required' => 'Debe ingresar total.',
            'totale.gt' => 'Debe ingresar total mayor a 0.',
            'n_comprobantee.required' => 'Debe ingresar n° comprobante.',
            'id_tipo_comprobantee.gt' => 'Debe seleccionar tipo comprobante.',
            'punto_partidae.required' => 'Debe ingresar descripción.'
        ]);

        $get_id = CajaChica::findOrFail($id);

        $comprobante = $get_id->comprobante;
        if ($_FILES["comprobantee"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->comprobante!=""){
                    ftp_delete($con_id, "CAJA_CHICA/".basename($get_id->comprobante));
                }

                $path = $_FILES["comprobantee"]["name"];
                $source_file = $_FILES['comprobantee']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CAJA_CHICA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante = "https://lanumerounocloud.com/intranet/CAJA_CHICA/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        CajaChica::findOrFail($id)->update([
            'id_ubicacion' => $request->id_ubicacione,
            'id_categoria' => $request->id_categoriae,
            'fecha' => $request->fechae,
            'id_sub_categoria' => $request->id_sub_categoriae,
            'id_empresa' => $request->id_empresae,
            'id_tipo_moneda' => $request->id_tipo_monedae,
            'total' => $request->totale,
            'ruc' => $request->ruce,
            'razon_social' => $request->razon_sociale,
            'n_comprobante' => $request->n_comprobantee,
            'id_tipo_comprobante' => $request->id_tipo_comprobantee,
            'punto_partida' => $request->punto_partidae,
            'comprobante' => $comprobante,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function validar($id)
    {
        $get_id = CajaChica::from('caja_chica AS cc')
                ->select('cc.id','ca.nom_categoria','sc.nombre','tc.nom_tipo_comprobante',
                'cc.n_comprobante',DB::raw('CASE WHEN ca.nom_categoria="MOVILIDAD" THEN 
                (CASE WHEN cc.ruta=1 THEN CONCAT(cc.punto_partida," - ",cc.punto_llegada) 
                ELSE cc.punto_llegada END) ELSE cc.punto_partida END AS descripcion'),
                DB::raw('CONCAT(tm.cod_moneda," ",cc.total) AS total'),'ub.cod_ubi','em.nom_empresa',
                'cc.razon_social','cc.comprobante',
                DB::raw('SUBSTRING_INDEX(cc.comprobante,"/",-1) AS nom_comprobante'),'cc.id_categoria')
                ->join('categoria AS ca','ca.id_categoria','=','cc.id_categoria')
                ->join('sub_categoria AS sc','sc.id','=','cc.id_sub_categoria')
                ->join('vw_tipo_comprobante AS tc','tc.id','=','cc.id_tipo_comprobante')
                ->join('tipo_moneda AS tm','tm.id_moneda','=','cc.id_tipo_moneda')
                ->join('ubicacion AS ub','ub.id_ubicacion','=','cc.id_ubicacion')
                ->join('empresas AS em','em.id_empresa','=','cc.id_empresa')
                ->where('cc.id',$id)
                ->first();
        $list_pago = Pago::all();
        $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)->where('estado',1)
                        ->orderBy('nombre','ASC')->get();
        $valida = Categoria::select('nom_categoria')->where('id_categoria',$get_id->id_categoria)
                ->first();
        if($valida->nom_categoria=="MOVILIDAD"){
            return view('finanzas.tesoreria.caja_chica.modal_validar_mo', compact(
                'get_id',
                'list_pago',
                'list_tipo_pago'
            ));
        }else{
            CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->delete();
            return view('finanzas.tesoreria.caja_chica.modal_validar_pv', compact(
                'get_id',
                'list_pago',
                'list_tipo_pago'
            ));
        }
    }

    public function validar_mo(Request $request, $id)
    {
        $request->validate([
            'id_pagov' => 'gt:0',
            'id_tipo_pagov' => 'gt:0',
            'fecha_pagov' => 'required'
        ], [
            'id_pagov.gt' => 'Debe seleccionar pago.',
            'id_tipo_pagov.gt' => 'Debe seleccionar tipo pago.',
            'fecha_pagov.required' => 'Debe ingresar fecha de pago.'
        ]);

        CajaChica::findOrFail($id)->update([
            'id_pago' => $request->id_pagov,
            'id_tipo_pago' => $request->id_tipo_pagov,
            'cuenta_1' => $request->cuenta_1v,
            'cuenta_2' => $request->cuenta_2v,
            'fecha_pago' => $request->fecha_pagov,
            'estado_c' => 2,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function validar_pv(Request $request, $id)
    {
        $request->validate([
            'id_pagov' => 'gt:0',
            'id_tipo_pagov' => 'gt:0'
        ], [
            'id_pagov.gt' => 'Debe seleccionar pago.',
            'id_tipo_pagov.gt' => 'Debe seleccionar tipo pago.'
        ]);

        $errors = [];
        if($request->id_pagov=="1"){
            $errors['fecha_pagov'] = ['Debe ingresar fecha de pago.'];
        }
        if($request->id_pagov=="2"){
            $get_id = CajaChica::findOrFail($id);
            $suma = CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->sum('monto');
            if ($get_id->total != $suma) {
                $errors['suma'] = ['Debe ingresar más montos para completar el total.'];
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }
        
        CajaChica::findOrFail($id)->update([
            'id_pago' => $request->id_pagov,
            'id_tipo_pago' => $request->id_tipo_pagov,
            'cuenta_1' => $request->cuenta_1v,
            'cuenta_2' => $request->cuenta_2v,
            'fecha_pago' => $request->fecha_pagov,
            'estado_c' => 2,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($request->id_pagov=="2"){
            DB::statement('INSERT INTO caja_chica_pago (id_caja_chica,fecha,monto)
            SELECT '.$id.',fecha,monto
            FROM caja_chica_pago_temporal
            WHERE id_usuario='.session('usuario')->id_usuario);

            CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->delete();
        }
    }

    public function credito($id)
    {
        return view('finanzas.tesoreria.caja_chica.modal_credito',compact('id'));
    }

    public function list_credito()
    {
        $list_temporal = CajaChicaPagoTemporal::select(DB::raw('DATE_FORMAT(fecha,"%d-%m-%Y") AS fecha'),'monto')
                        ->where('id_usuario',session('usuario')->id_usuario)->get();
        return view('finanzas.tesoreria.caja_chica.lista_credito', compact(
            'list_temporal'
        ));
    }

    public function saldo($id)
    {
        $get_id = CajaChica::findOrFail($id);
        $suma = CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->sum('monto');
        echo $get_id->total-$suma;
    }

    public function store_cr(Request $request, $id)
    {
        $request->validate([
            'fechac' => 'required',
            'montoc' => 'required|gt:0'
        ], [
            'fechac.required' => 'Debe ingresar fecha.',
            'montoc.required' => 'Debe ingresar monto.',
            'montoc.gt' => 'Debe ingresar monto mayor a 0.'
        ]);

        $get_id = CajaChica::findOrFail($id);
        $suma = CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->sum('monto');

        if(($suma+$request->montoc)>$get_id->total){
            echo "error";
        }else{
            CajaChicaPagoTemporal::create([
                'id_usuario' => session('usuario')->id_usuario,
                'fecha' => $request->fechac,
                'monto' => $request->montoc
            ]);
        }
    }

    public function destroy($id)
    {
        CajaChica::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel()
    {
        $list_caja_chica = CajaChica::get_list_caja_chica();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Caja chica');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(22);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A1:L1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:L1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:L1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Fecha registro');
        $sheet->setCellValue("B1", 'Ubicación');
        $sheet->setCellValue("C1", 'Categoría');
        $sheet->setCellValue("D1", 'Sub-Categoría');
        $sheet->setCellValue("E1", 'Empresa');
        $sheet->setCellValue("F1", 'Descripción');
        $sheet->setCellValue("G1", 'RUC');
        $sheet->setCellValue("H1", 'Razón social');
        $sheet->setCellValue("I1", 'Tipo comprobante');
        $sheet->setCellValue("J1", 'N° comprobante');
        $sheet->setCellValue("K1", 'Monto');
        $sheet->setCellValue("L1", 'Estado');

        $contador = 1;

        foreach ($list_caja_chica as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->cod_ubi); 
            $sheet->setCellValue("C{$contador}", $list->nom_categoria);
            $sheet->setCellValue("D{$contador}", $list->nombre);
            $sheet->setCellValue("E{$contador}", $list->nom_empresa);
            $sheet->setCellValue("F{$contador}", $list->descripcion);
            $sheet->setCellValue("G{$contador}", $list->ruc);
            $sheet->setCellValue("H{$contador}", $list->razon_social); 
            $sheet->setCellValue("I{$contador}", $list->nom_tipo_comprobante);
            $sheet->setCellValue("J{$contador}", $list->n_comprobante);
            $sheet->setCellValue("K{$contador}", $list->total);
            $sheet->setCellValue("L{$contador}", $list->nom_estado);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Caja chica';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\ChequesLetras;
use App\Models\Empresas;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TipoComprobante;
use App\Models\TipoMoneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroLetraController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(8);
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get();
        $list_mes = Mes::select('cod_mes','abr_mes')->orderby('cod_mes','ASC')->get();
        $list_anio = Anio::select('cod_anio')->orderby('cod_anio','DESC')->get();
        return view('finanzas.tesoreria.registro_letra.index',compact(
            'list_notificacion',
            'list_subgerencia',
            'list_empresa',
            'list_aceptante',
            'list_mes',
            'list_anio'
        ));
    }

    public function list(Request $request)
    {
        $list_cheque_letra = ChequesLetras::get_list_cheques_letra([
            'estado'=>$request->estado,
            'id_empresa'=>$request->id_empresa,
            'id_aceptante'=>$request->id_aceptante,
            'tipo_fecha'=>$request->tipo_fecha,
            'mes'=>$request->mes,
            'anio'=>$request->anio
        ]);
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("clp_razsoc AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get()->map(function($item) {
                            return (array) $item;
                        })->toArray();
        return view('finanzas.tesoreria.registro_letra.lista', compact(
            'list_cheque_letra',
            'list_aceptante'
        ));
    }

    public function create()
    {
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get();
        $list_tipo_comprobante = TipoComprobante::whereIn('id',[1,2,5])->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        return view('finanzas.tesoreria.registro_letra.modal_registrar',compact(
            'list_empresa',
            'list_aceptante',
            'list_tipo_comprobante',
            'list_tipo_moneda'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'gt:0',
            'fec_emision' => 'required',
            'fec_vencimiento' => 'required',
            'id_tipo_documento' => 'gt:0',
            'num_doc' => 'required',
            'id_aceptante' => 'not_in:0',
            'id_tipo_comprobante' => 'gt:0',
            'num_comprobante' => 'required',
            'monto' => 'required|gt:0'
        ],[
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'fec_emision.required' => 'Debe ingresar fecha emisión.',
            'fec_vencimiento.required' => 'Debe ingresar fecha vencimiento.',
            'id_tipo_documento.gt' => 'Debe seleccionar tipo documento.',
            'num_doc.required' => 'Debe ingresar n° documento.',
            'id_aceptante.not_in' => 'Debe seleccionar aceptante.',
            'id_tipo_comprobante.gt' => 'Debe seleccionar tipo comprobante.',
            'num_comprobante.required' => 'Debe ingresar n° comprobante.',
            'monto.required' => 'Debe ingresar monto.',
            'monto.gt' => 'Debe ingresar monto mayor a 0.'
        ]);

        $valida = ChequesLetras::where('id_empresa', $request->id_empresa)
                ->where('fec_vencimiento',$request->fec_vencimiento)->where('num_doc',$request->num_doc)
                ->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
            $aceptante = explode("_",$request->id_aceptante);
            $tipo_doc_empresa_vinculada = NULL;
            $num_doc_empresa_vinculada = NULL;
            if($request->negociado_endosado=="2"){
                $empresa_vinculada = explode("_",$request->id_empresa_vinculada);
                $tipo_doc_empresa_vinculada = $empresa_vinculada[0];
                $num_doc_empresa_vinculada = $empresa_vinculada[1];
            }

            $documento = "";
            if ($_FILES["documento"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $path = $_FILES["documento"]["name"];
                    $source_file = $_FILES['documento']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Cheque_Letra_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $documento = "https://lanumerounocloud.com/intranet/ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }

            ChequesLetras::create([
                'id_empresa' => $request->id_empresa,
                'fec_emision' => $request->fec_emision,
                'fec_vencimiento' => $request->fec_vencimiento,
                'id_tipo_documento' => $request->id_tipo_documento,
                'num_doc' => $request->num_doc,
                'tipo_doc_aceptante' => $aceptante[0],
                'num_doc_aceptante' => $aceptante[1],
                'tipo_doc_emp_vinculada' => $tipo_doc_empresa_vinculada,
                'num_doc_emp_vinculada' => $num_doc_empresa_vinculada,
                'id_tipo_comprobante' => $request->id_tipo_comprobante,
                'num_comprobante' => $request->num_comprobante,
                'id_moneda' => $request->id_moneda,
                'monto' => $request->monto,
                'negociado_endosado' => $request->negociado_endosado,
                'documento' => $documento,
                'estado_registro' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function unico($id, $tipo)
    {
        $get_id = ChequesLetras::findOrFail($id);
        $list_banco = DB::connection('sqlsrv')->table('vw_bancos')
                    ->select(DB::raw("c_sigl_banc AS id_banco"),
                    DB::raw("CONCAT(c_desc_banc,' (',c_sigl_banc,')') AS nom_banco"))
                    ->orderBy('c_desc_banc','ASC')->get();
        return view('finanzas.tesoreria.registro_letra.modal_unico',compact(
            'get_id',
            'list_banco',
            'tipo'
        ));
    }

    public function update_unico(Request $request, $id)
    {
        $request->validate([
            'tipo_nunicou' => 'required',
            'num_unicou' => 'required_if:tipo_nunicou,1',
            'num_cuentau' => 'required_if:tipo_nunicou,2',
            'bancou' => 'not_in:0'
        ],[
            'tipo_nunicou.required' => 'Debe seleccionar el tipo de letra.',
            'num_unicou.required_if' => 'Debe ingresar número único.',
            'num_cuentau.required_if' => 'Debe ingresar número de cuenta.',
            'bancou.not_in' => 'Debe seleccionar banco.'
        ]);

        if($request->tipo_nunicou=="1"){
            $valida = ChequesLetras::where('num_unico', $request->num_unicou)
                    ->where('estado', 1)->where('id_cheque_letra','!=',$id)->exists();

            if($valida){
                echo "error";
            }else{
                ChequesLetras::findOrFail($id)->update([
                    'tipo_nunico' => $request->tipo_nunicou,
                    'num_unico' => $request->num_unicou,
                    'num_cuenta' => $request->num_cuentau,
                    'banco' => $request->bancou,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }else{
            ChequesLetras::findOrFail($id)->update([
                'tipo_nunico' => $request->tipo_nunicou,
                'num_unico' => $request->num_unicou,
                'num_cuenta' => $request->num_cuentau,
                'banco' => $request->bancou,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function estado($id, $tipo)
    {
        $get_id = ChequesLetras::findOrFail($id);
        return view('finanzas.tesoreria.registro_letra.modal_estado',compact('get_id','tipo'));
    }

    public function update_estado(Request $request, $id)
    {
        $request->validate([
            'fec_pagos' => 'required',
            'noperacions' => 'required'
        ],[
            'fec_pagos.required' => 'Debe ingresar fecha pago.',
            'noperacions.required' => 'Debe ingresar n° operación.'
        ]);

        $get_id = ChequesLetras::findOrFail($id);

        $comprobante_pago = $get_id->comprobante_pago;
        if ($_FILES["comprobante_pagos"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->comprobante_pago!=""){
                    ftp_delete($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/".basename($get_id->comprobante_pago));
                }

                $path = $_FILES["comprobante_pagos"]["name"];
                $source_file = $_FILES['comprobante_pagos']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_Pago_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante_pago = "https://lanumerounocloud.com/intranet/ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        ChequesLetras::findOrFail($id)->update([
            'fec_pago' => $request->fec_pagos,
            'noperacion' => $request->noperacions,
            'comprobante_pago' => $comprobante_pago,
            'estado_registro' => 2,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy($id)
    {
        ChequesLetras::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\Categoria;
use App\Models\Empresas;
use App\Models\Notificacion;
use App\Models\SubCategoria;
use App\Models\TipoMoneda;
use App\Models\Ubicacion;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use App\Models\SubGerencia;

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
        $list_caja_chica = CajaChica::from('caja_chica AS cc')
                            ->select('cc.id','cc.fecha AS orden',
                            DB::raw('DATE_FORMAT(cc.fecha,"%d-%m-%Y") AS fecha'),'ub.cod_ubi',
                            'ca.nom_categoria','sc.nombre','em.nom_empresa',
                            DB::raw('CASE WHEN ca.nom_categoria="MOVILIDAD" THEN 
                            (CASE WHEN cc.ruta=1 THEN CONCAT(cc.punto_partida," - ",cc.punto_llegada) 
                            ELSE cc.punto_llegada END) ELSE cc.punto_partida END AS descripcion'),
                            'cc.ruc','cc.razon_social','tc.nom_tipo_comprobante','cc.n_comprobante',
                            DB::raw('CONCAT(tm.cod_moneda," ",cc.total) AS total'),'cc.comprobante',
                            DB::raw('CASE WHEN cc.estado_c=1 THEN "Por revisar" 
                            WHEN cc.estado_c=2 THEN "Completado" ELSE "" END AS nom_estado'))
                            ->join('ubicacion AS ub','ub.id_ubicacion','=','cc.id_ubicacion')
                            ->join('categoria AS ca','ca.id_categoria','=','cc.id_categoria')
                            ->join('sub_categoria AS sc','sc.id','=','cc.id_sub_categoria')
                            ->join('empresas AS em','em.id_empresa','=','cc.id_empresa')
                            ->join('vw_tipo_comprobante AS tc','tc.id','=','cc.id_tipo_comprobante')
                            ->join('tipo_moneda AS tm','tm.id_moneda','=','cc.id_tipo_moneda')
                            ->where('cc.estado',1)
                            ->get();
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

        $comprobante = "";
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

    public function validar($id)
    {
        $get_id = CajaChica::from('caja_chica AS cc')
                ->select('cc.id','ca.nom_categoria','sc.nombre','tc.nom_tipo_comprobante',
                'cc.n_comprobante',DB::raw('CASE WHEN ca.nom_categoria="MOVILIDAD" THEN 
                (CASE WHEN cc.ruta=1 THEN CONCAT(cc.punto_partida," - ",cc.punto_llegada) 
                ELSE cc.punto_llegada END) ELSE cc.punto_partida END AS descripcion'),
                DB::raw('CONCAT(tm.cod_moneda," ",cc.total) AS total'),'ub.cod_ubi','em.nom_empresa',
                'cc.razon_social','cc.id_categoria')
                ->join('categoria AS ca','ca.id_categoria','=','cc.id_categoria')
                ->join('sub_categoria AS sc','sc.id','=','cc.id_sub_categoria')
                ->join('vw_tipo_comprobante AS tc','tc.id','=','cc.id_tipo_comprobante')
                ->join('tipo_moneda AS tm','tm.id_moneda','=','cc.id_tipo_moneda')
                ->join('ubicacion AS ub','ub.id_ubicacion','=','cc.id_ubicacion')
                ->join('empresas AS em','em.id_empresa','=','cc.id_empresa')
                ->where('cc.id',$id)
                ->first();
        $valida = Categoria::select('nom_categoria')->where('id_categoria',$get_id->id_categoria)
                ->first();
        if($valida->nom_categoria=="MOVILIDAD"){
            return view('finanzas.tesoreria.caja_chica.modal_validar_mo', compact(
                'get_id'
            ));
        }else{

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
}

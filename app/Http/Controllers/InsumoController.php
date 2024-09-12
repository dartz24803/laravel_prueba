<?php

namespace App\Http\Controllers;

use App\Models\Contometro;
use App\Models\Insumo;
use App\Models\Notificacion;
use App\Models\Proveedor;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();          
        return view('caja.insumo.index',compact('list_notificacion'));
    }

    public function index_en()
    {
        return view('caja.insumo.entrada_insumo.index');
    }

    public function list_en()
    {
        $list_contometro = Contometro::from('contometro AS co')
                        ->select('co.id_contometro','iu.nom_insumo','pr.nombre_proveedor',
                        'co.cantidad','co.n_factura','co.n_guia',
                        DB::raw('DATE_FORMAT(co.fecha_contometro,"%d-%m-%Y") AS fecha'),'co.factura',
                        'co.guia')
                        ->join('insumo AS iu','iu.id_insumo','=','co.id_insumo')
                        ->join('proveedor AS pr','pr.id_proveedor','=','co.id_proveedor')
                        ->where('co.estado',1)->get();
        return view('caja.insumo.entrada_insumo.lista', compact('list_contometro'));
    }

    public function create_en()
    {
        $list_insumo = Insumo::select('id_insumo','nom_insumo')->where('estado',1)
                        ->orderBy('nom_insumo','ASC')->get();
        $list_proveedor = Proveedor::select('id_proveedor','nombre_proveedor')->where('tipo',5)
                        ->where('estado',1)->orderBy('nombre_proveedor','ASC')->get();
        return view('caja.insumo.entrada_insumo.modal_registrar',compact('list_insumo','list_proveedor'));
    }

    public function store_en(Request $request)
    {
        $request->validate([
            'id_insumo' => 'gt:0',
            'id_proveedor' => 'gt:0',
            'cantidad' => 'required|gt:0',
            'fecha_contometro' => 'required',
            'n_factura' => 'required',
            'n_guia' => 'required'
        ], [
            'id_insumo.gt' => 'Debe seleccionar insumo.',
            'id_proveedor.gt' => 'Debe seleccionar proveedor.',
            'cantidad.required' => 'Debe ingresar cantidad.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
            'fecha_contometro.required' => 'Debe ingresar fecha.',
            'n_factura.required' => 'Debe ingresar n° factura.',
            'n_guia.required' => 'Debe ingresar n° guía.'
        ]);

        $factura = "";
        if ($_FILES["factura"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["factura"]["name"];
                $source_file = $_FILES['factura']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "INSUMO/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $factura = "https://lanumerounocloud.com/intranet/INSUMO/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        $guia = "";
        if ($_FILES["guia"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["guia"]["name"];
                $source_file = $_FILES['guia']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Guia_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "INSUMO/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $guia = "https://lanumerounocloud.com/intranet/INSUMO/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        Contometro::create([
            'id_insumo' => $request->id_insumo,
            'id_proveedor' => $request->id_proveedor,
            'cantidad' => $request->cantidad,
            'fecha_contometro' => $request->fecha_contometro,
            'n_factura' => $request->n_factura,
            'factura' => $factura,
            'n_guia' => $request->n_guia,
            'guia' => $guia,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function edit_en($id)
    {
        $get_id = Contometro::findOrFail($id);
        $list_insumo = Insumo::select('id_insumo','nom_insumo')->where('estado',1)
                        ->orderBy('nom_insumo','ASC')->get();
        $list_proveedor = Proveedor::select('id_proveedor','nombre_proveedor')->where('tipo',5)
                        ->where('estado',1)->orderBy('nombre_proveedor','ASC')->get();
        return view('caja.insumo.entrada_insumo.modal_editar', compact('get_id','list_insumo','list_proveedor'));
    }

    public function download_en($id, $tipo)
    {
        $get_id = Contometro::findOrFail($id);

        if($tipo=="1"){
            $archivo = $get_id->factura;
        }else{
            $archivo = $get_id->guia;
        }

        // URL del archivo
        $url = $archivo;

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

    public function update_en(Request $request, $id)
    {
        $request->validate([
            'id_insumoe' => 'gt:0',
            'id_proveedore' => 'gt:0',
            'cantidade' => 'required|gt:0',
            'fecha_contometroe' => 'required',
            'n_facturae' => 'required',
            'n_guiae' => 'required'
        ], [
            'id_insumoe.gt' => 'Debe seleccionar insumo.',
            'id_proveedore.gt' => 'Debe seleccionar proveedor.',
            'cantidade.required' => 'Debe ingresar cantidad.',
            'cantidade.gt' => 'Debe ingresar cantidad mayor a 0.',
            'fecha_contometroe.required' => 'Debe ingresar fecha.',
            'n_facturae.required' => 'Debe ingresar n° factura.',
            'n_guiae.required' => 'Debe ingresar n° guía.'
        ]);

        $get_id = Contometro::findOrFail($id);

        $factura = "";
        if ($_FILES["facturae"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if ($get_id->factura != "") {
                    ftp_delete($con_id, 'INSUMO/' . basename($get_id->factura));
                }
                $path = $_FILES["facturae"]["name"];
                $source_file = $_FILES['facturae']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "INSUMO/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $factura = "https://lanumerounocloud.com/intranet/INSUMO/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        $guia = "";
        if ($_FILES["guiae"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if ($get_id->guia != "") {
                    ftp_delete($con_id, 'INSUMO/' . basename($get_id->guia));
                }
                $path = $_FILES["guiae"]["name"];
                $source_file = $_FILES['guiae']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Guia_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "INSUMO/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $guia = "https://lanumerounocloud.com/intranet/INSUMO/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        Contometro::findOrFail($id)->update([
            'id_insumo' => $request->id_insumoe,
            'id_proveedor' => $request->id_proveedore,
            'cantidad' => $request->cantidade,
            'fecha_contometro' => $request->fecha_contometroe,
            'n_factura' => $request->n_facturae,
            'factura' => $factura,
            'n_guia' => $request->n_guiae,
            'guia' => $guia,
            'id_area' => $request->id_areae,
            'id_banco' => $request->id_bancoe,
            'num_cuenta' => $request->num_cuentae,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_en($id)
    {
        Contometro::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

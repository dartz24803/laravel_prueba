<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotografico;
use App\Models\Area;
use App\Models\Base;
use App\Models\CodigosReporteFotografico;
use App\Models\ReporteFotograficoArchivoTemporal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Exception;

class ReporteFotograficoController extends Controller
{
    //variables a usar
    protected $request;
    protected $modelo;
    protected $modeloarea;
    protected $modelobase;
    protected $modelocodigos;
    protected $modeloarchivotmp;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new ReporteFotografico();
        $this->modeloarea = new Area();
        $this->modelobase = new Base();
        $this->modelocodigos = new CodigosReporteFotografico();
        $this->modeloarchivotmp = new ReporteFotograficoArchivoTemporal();
    }

    public function index(){
        //retornar vista si esta logueado
        $list_area = $this->modeloarea->listar();
        $list_bases = $this->modelobase->listar();
        $list_codigos = $this->modelocodigos->listar();
        //enviar listas a la vista
        return view('tienda.ReporteFotografico.reportefotografico', compact('list_area', 'list_bases', 'list_codigos'));
    }

    public function listar(Request $request){
        $base= $request->input("base");
        $area= $request->input("area");
        $codigo= $request->input("codigo");
        $datos = $this->modelo->listar($base,$area,$codigo);
        $data = array();
        //listar cada fila de la tabla
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['id'];
            $sub_array[] = $row['base'];
            $sub_array[] = $row['codigo'];
            $sub_array[] = $row['tipo'];
            $sub_array[] = $row['areas'];
            $sub_array[] = $row['fec_reg'];
            $sub_array[] = '<div class="btn-group" role="group" aria-label="Button group">
            <a class="btn btn-success" title="Ver evidencia" href="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/'.$row['foto'].'" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </a>
            </div>';
            $sub_array[] = '<div class="btn-group" role="group" aria-label="Button group">
            <a class="btn btn-success" href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="'. route("tienda.ReporteFotografico.modal_editar", $row['id']).'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg>
            </a>
            <a class="btn btn-danger" onClick="Delete_Reporte_Fotografico(' . $row['id'] . ')" title="Eliminar">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
            </a>
        </div>';
            $data[] = $sub_array;
        }
        $results = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );
        //retornar resultados para el datatable
        return response()->json($results);
    }

    public function ModalRegistroReporteFotografico(){
        // Lógica para obtener los datos necesarios
        $this->modeloarchivotmp->where('id_usuario', Session::get('usuario')->id_usuario)->delete();
        $list_codigos = $this->modelocodigos->listar();
        // Retorna la vista con los datos
        return view('tienda.ReporteFotografico.modal_registrar', compact('list_codigos'));
    }

    public function ModalUpdatedReporteFotografico($id){
        // Lógica para obtener los datos necesarios
        $get_id = $this->modelo->where('id', $id)->get();
        $list_codigos = $this->modelocodigos->listar();
        // Retorna la vista con los datos
        return view('tienda.ReporteFotografico.modal_editar', compact('list_codigos','get_id'));
    }

    public function Previsualizacion_Captura2(){
        //contador de archivos temporales para validar si tomó foto o no
        //$data = $this->modeloarchivotmp->contador_archivos_rf();
        $data = $this->modeloarchivotmp->where('id_usuario', Session::get('usuario')->id_usuario)->get();

        //si esta vacío
        if($data->isEmpty()){
            $foto_key = "photo1";
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

            if ((!$con_id) || (!$lr)) {
                echo "No se pudo conectar al servidor FTP";
            } else {
                //ftp_delete($con_id, 'REPORTE_FOTOGRAFICO/temporal_rf_'.Session::get('usuario')->id. "_1" .'.jpg');
                $nombre_soli = "temporal_rf_" . Session::get('usuario')->id_usuario . "_1";
                $path = $_FILES[$foto_key]["name"];
                $source_file = $_FILES[$foto_key]['tmp_name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "REPORTE_FOTOGRAFICO/" . $nombre, $source_file, FTP_BINARY);

                if ($subio) {
                    $dato = [
                        'ruta' => $nombre,
                        'id_usuario' => Session::get('usuario')->id_usuario,
                    ];
                    $this->modeloarchivotmp->insert($dato);
                    $respuesta['error'] = "";
                } else {
                    echo "Error al subir la foto<br>";
                }
            }
            return response()->json($respuesta);
        }else{
            echo "error";
        }
    }

    public function obtenerImagenes() {
        //obtener imagenes por usuario
        $imagenes = $this->modeloarchivotmp->where('id_usuario', Session::get('usuario')->id_usuario)->get();
        $data = array();
        foreach ($imagenes as $imagen) {
            $data[] = array(
                'ruta' => $imagen['ruta'],
                'id' => $imagen['id']
            );
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function Delete_Imagen_Temporal(Request $request){
        $id = $request->input('id');
        $this->modeloarchivotmp->where('id', $id)->delete();
    }

    public function Registrar_Reporte_Fotografico(Request $request){
        $data = $this->modeloarchivotmp->where('id_usuario', Session::get('usuario')->id_usuario)->get();
        //print_r($data);

        //si hay foto procede a registrar
        if(!$data->isEmpty()){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

            if ((!$con_id) || (!$lr)) {
                echo "No se pudo conectar al servidor FTP";
            } else {
                //validacion de codigo, q vaya con datos
                $validator = Validator::make($request->all(), [
                    'codigo' => 'required'
                ], [
                    'codigo.required' => 'Codigo: Campo obligatorio',
                ]);
                //alerta de validacion
                if ($validator->fails()) {
                    $respuesta['error'] = $validator->errors()->all();
                }else{
                    $nombre_actual = "REPORTE_FOTOGRAFICO/".$data[0]['ruta'];
                    $nuevo_nombre = "REPORTE_FOTOGRAFICO/Evidencia_".date('Y-m-d H:m')."_captura.jpg";
                    ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                    $nombre = basename($nuevo_nombre);
                    //llenar array con datos para bd
                    $dato['foto'] = $nombre;
                    $dato = [
                        'base' => Session::get('usuario')->centro_labores,
                        'foto' => $nombre,
                        'codigo' => $request->input("codigo"),
                        'estado' => '1',
                        'fec_reg' => now(),
                        'user_reg' => Session::get('usuario')->id_usuario,
                    ];
                    $this->modelo->insert($dato);
                    $respuesta['error'] = "";
                }
            }
        }else{
            $respuesta['error'] = "Debe tomar una fotografía";
        }
        return response()->json($respuesta);
    }

    public function Delete_Reporte_Fotografico(Request $request)
    {
        $id = $request->input('id');
        $respuesta = array();
        try {
            $this->modelo->where('id', $id)->delete();
            $respuesta['error'] = "";
        } catch (Exception $e) {
            $respuesta['error']=$e->getMessage();
        }
        return response()->json($respuesta);
    }

    public function Update_Registro_Fotografico(Request $request){
        //verificar sesión
        $id = $request->input('id');
        $respuesta = array();
        $validator = Validator::make($request->all(), [
            'codigo_e' => 'required'
        ], [
            'codigo_e.required' => 'Codigo: Campo obligatorio',
        ]);
        //verificar validacion de select
        if ($validator->fails()) {
            $respuesta['error'] = $validator->errors()->all();
        }else{
            try {
                $dato = [
                    'codigo' => $request->input('codigo_e'),
                    'fec_act' => now(),
                    'user_act' => Session::get('usuario')->id_usuario,
                ];
                //actualizar codigo
                $this->modelo->where('id', $id)->update($dato);
                $respuesta['error'] = "";
                $respuesta['ok'] = "Se Elimino Correctamente";
            } catch (Exception $e) {
                $respuesta['error']=$e->getMessage();
            }
        }
        return response()->json($respuesta);
    }
}

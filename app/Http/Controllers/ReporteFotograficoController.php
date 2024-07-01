<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotografico;
use App\Models\Area;
use App\Models\Base;
use App\Models\CodigosReporteFotografico;
use App\Models\ReporteFotograficoArchivoTemporal;
use App\Models\ReporteFotograficoAdm;
use Illuminate\Support\Facades\Validator;
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
    protected $modelorfa;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new ReporteFotografico();
        $this->modeloarea = new Area();
        $this->modelobase = new Base();
        $this->modelocodigos = new CodigosReporteFotografico();
        $this->modeloarchivotmp = new ReporteFotograficoArchivoTemporal();
        $this->modelorfa = new ReporteFotograficoAdm();
    }

    public function index(){
        //enviar listas a la vista
        return view('tienda.ReporteFotografico.index');
    }

    public function Reporte_Fotografico(Request $request){
        //retornar vista si esta logueado
        $list_bases = $this->modelobase->listar();
        $list_categorias = $this->modelorfa->where('estado',1)->get();
        return view('tienda.ReporteFotografico.tabla_rf.reportefotografico', compact('list_categorias', 'list_bases'));
    }

    public function Reporte_Fotografico_Listar(Request $request){
        $base= $request->input("base");
        $categoria= $request->input("categoria");
        $list = $this->modelo->listar($base,$categoria);
        return view('tienda.ReporteFotografico.tabla_rf.listar', compact('list'));
    }

    public function ModalRegistroReporteFotografico(){
        // Lógica para obtener los datos necesarios
        $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->delete();
        $list_codigos = $this->modelocodigos->listar();
        // Retorna la vista con los datos
        return view('tienda.ReporteFotografico.tabla_rf.modal_registrar', compact('list_codigos'));
    }

    public function ModalUpdatedReporteFotografico($id){
        // Lógica para obtener los datos necesarios
        $get_id = $this->modelo->where('id', $id)->get();
        $list_codigos = $this->modelocodigos->listar();
        // Retorna la vista con los datos
        return view('tienda.ReporteFotografico.tabla_rf.modal_editar', compact('list_codigos','get_id'));
    }

    public function Previsualizacion_Captura2(){
        //contador de archivos temporales para validar si tomó foto o no
        //$data = $this->modeloarchivotmp->contador_archivos_rf();
        $data = $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->get();

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
                $nombre_soli = "temporal_rf_" . Session('usuario')->id_usuario . "_1";
                $path = $_FILES[$foto_key]["name"];
                $source_file = $_FILES[$foto_key]['tmp_name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "REPORTE_FOTOGRAFICO/" . $nombre, $source_file, FTP_BINARY);

                if ($subio) {
                    $dato = [
                        'ruta' => $nombre,
                        'id_usuario' => Session('usuario')->id_usuario,
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
        $imagenes = $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->get();
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
        $data = $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->get();
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
                    'codigo' => 'not_in:0'
                ], [
                    'codigo.not_in' => 'Codigo: Campo obligatorio',
                ]);
                //alerta de validacion
                if ($validator->fails()) {
                    $respuesta['error'] = $validator->errors()->all();
                }else{
                    $nombre_actual = "REPORTE_FOTOGRAFICO/".$data[0]['ruta'];
                    $nuevo_nombre = "REPORTE_FOTOGRAFICO/Evidencia_".date('Y-m-d H:m:s')."_".Session('usuario')->id_usuario."_".Session('usuario')->centro_labores."_captura.jpg";
                    ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                    $nombre = basename($nuevo_nombre);
                    //llenar array con datos para bd
                    $dato['foto'] = $nombre;
                    $dato = [
                        'base' => Session('usuario')->centro_labores,
                        'foto' => $nombre,
                        'codigo' => $request->input("codigo"),
                        'estado' => '1',
                        'fec_reg' => now(),
                        'user_reg' => Session('usuario')->id_usuario,
                    ];
                    $this->modelo->insert($dato);
                    $respuesta['error'] = "";
                }
            }
        }else{
            $respuesta['error'][0] = "Debe tomar una fotografía";
        }
        return response()->json($respuesta);
    }

    public function Delete_Reporte_Fotografico(Request $request){
        $id = $request->input('id');
        $respuesta = array();
        try {
            $dato = [
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => session('usuario')->id_usuario,
            ];
            $this->modelo->where('id', $id)->update($dato);
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
                    'user_act' => Session('usuario')->id_usuario,
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

    public function Imagenes_Reporte_Fotografico(Request $request){
        $list_bases = $this->modelobase->listar();
        $list_categorias = $this->modelorfa->where('estado',1)->get();
        $base= $request->input("base");
        $area= $request->input("area");
        $codigo= $request->input("codigo");
        return view('tienda.ReporteFotografico.imagenes_rf.index',  compact('list_categorias', 'list_bases'));
    }

    public function Listar_Imagenes_Reporte_Fotografico(Request $request){
        $base= $request->input("base");
        $categoria= $request->input("categoria");
        $list_rf = $this->modelo->listar($base, $categoria);
        //print_r($list_rf[0]);
        return view('tienda.ReporteFotografico.imagenes_rf.listar',  compact('list_rf'));
    }

    public function Modal_Detalle_RF($id){
        $get_id = ReporteFotografico::leftJoin('codigos_reporte_fotografico_new', 'reporte_fotografico_new.codigo', '=', 'codigos_reporte_fotografico_new.id')
        ->select('reporte_fotografico_new.id', 'reporte_fotografico_new.foto', 'reporte_fotografico_new.base', 'reporte_fotografico_new.fec_reg', 'codigos_reporte_fotografico_new.descripcion')
        ->where('reporte_fotografico_new.id', $id)
        ->get();
        return view('tienda.ReporteFotografico.imagenes_rf.modal_detalle', compact('get_id'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\OcurrenciaArchivo;
use App\Models\OcurrenciaGestion;
use App\Models\OcurrenciaConclusion;
use App\Models\Ocurrencias;
use App\Models\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
class OcurrenciasTiendaController extends Controller{
    protected $request;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function Ocurrencia_Tienda(Request $request){
        $list_base = Base::get_list_base_only();

        $list_tipo_ocurrencia = DB::table('tipo_ocurrencia')
                ->select('id_tipo_ocurrencia', 'nom_tipo_ocurrencia')
                ->where('estado', 1)
                ->get();

        //$dato['list_tipo_ocurrencia'] = $this->Model_Corporacion->get_combo_tipo_ocurrencia('Todo');
        $list_colaborador = Ocurrencias::get_combo_colaborador_ocurrencia();

        //$dato['list_ocurrencia_usu'] = $this->Model_Corporacion->get_list_ocurrencia_usuario();

        $cantidad_revisadas = Ocurrencias::where('revisado', 0)
                    ->whereDate('fec_ocurrencia', now())
                    ->where('estado', 1)
                    ->count();


        //NOTIFICACIÓN-NO BORRAR
        /*
        $dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
        $dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();*/
        return view('seguridad.ocurrencias_tienda.index', compact('cantidad_revisadas', 'list_base', 'list_colaborador', 'list_tipo_ocurrencia'));
    }
/*
    public function Traer_Tipo_Ocurrencia_Busq(){
        if ($this->session->userdata('usuario')) {
            $dato['cod_base'] = $this->input->post("cod_base");
            $dato['list_tipo_ocurrencia'] = $this->Model_Corporacion->get_combo_tipo_ocurrencia($dato['cod_base']);
            $this->load->view('Admin/Configuracion/Ocurrencia_Tienda/tipo_ocurrencia',$dato);
        }else{
            redirect('');
        }
    }*/

    public function ListaOcurrencia($cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador){
        $list_ocurrencia = Ocurrencias::get_list_ocurrencia($id_ocurrencia=null,$cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador);
        return view('seguridad.ocurrencias_tienda.lista_ocurrencia', compact('list_ocurrencia'));
    }

    //-------------------------arreglar-----------------------------
    public function Confirmar_Revision_Ocurrencia(Request $request){
        $base = $request->input("base");
        $cant = Ocurrencias::where('revisado', 0)
                    ->whereDate('fec_ocurrencia', Carbon::now()->format('Y-m-d'))
                    ->where('estado', 1)
                    ->where('cod_base', $base)
                    ->count();
        if($cant==0){
            echo "error";
        }else{
            $id_usuario = session('usuario')[0]['id_usuario']; // Obtén el ID del usuario de la sesión

            Ocurrencias::whereDate('fec_ocurrencia', Carbon::now()->format('Y-m-d'))
                ->where('cod_base', $base)
                ->where('revisado', 0)
                ->update([
                    'revisado' => 1,
                    'fec_revisado' => DB::raw('NOW()'),
                    'user_revisado' => $id_usuario,
                ]);
        }
    }

    public function Modal_Ocurrencia_Tienda_Admin(){
        $dato['list_usuario'] = Usuario::where('estado', 1)
                                ->whereIn('id_puesto', [23,24,36])
                                ->get();
        $dato['list_conclusion'] = OcurrenciaConclusion::where('estado', 1)
                        ->get();
        $dato['list_gestion'] = OcurrenciaGestion::where('estado', 1)
                        ->get();
        $dato['list_base'] = Base::select('cod_base')
                        ->where('estado', 1)
                        ->groupBy('cod_base')
                        ->orderBy('cod_base', 'ASC')
                        ->get();
        // $dato['list_base'] = $this->Model_Corporacion->get_list_base_reg_agente();
        $id_usuario=session('usuario')->id_usuario;
        $dato['get_id'] = Usuario::where('id_usuario', $id_usuario)->get();
        $base = $dato['get_id'][0]['centro_labores'];

        $dato['list_tipo'] = DB::table('tipo_ocurrencia')
                            ->select('id_tipo_ocurrencia','nom_tipo_ocurrencia')
                            ->where('base', $base)
                            ->where('estado', 1)
                            ->get();
        return view('seguridad.ocurrencias_tienda.modal_registrar_admin',$dato);
    }

    public function Insert_Ocurrencia_Tienda_Admin(Request $request){
        $request->validate([
            'id_tipo' => 'required',
            'id_gestion' => 'required',
            'cod_base' => 'not_in:0',
            'descripcion' => 'required',
        ],[
            'id_tipo.required' => 'Debe ingresar tipo.',
            'id_gestion.required' => 'Debe ingresar gestion.',
            'cod_base.not_in' => 'Debe seleccionar base',
            'descripcion.required' => 'Debe ingresar descripcion.',
        ]);

        $valida = Ocurrencias::where('fec_ocurrencia', $request->fec_ocurrencia)
                    ->where('user_reg', session('usuario')->id_usuario)
                    ->where('id_tipo', $request->id_tipo)
                    ->where('id_conclusion', $request->id_conclusion)
                    ->where('id_gestion', $request->id_gestion)
                    ->where('descripcion', $request->descripcion)
                    ->where('estado', 1)
                    ->exists();
        if ($valida){
            echo "error";
        }else{
            $aniodereg = date('Y');
            $anio=date('Y');
            $query_id = Ocurrencias::whereYear('fec_reg', $aniodereg)->get();
            $totalRows_t = count($query_id);
            $aniof=substr($anio, 2,2);
            if($totalRows_t<9){
                $codigofinal="OC".$aniof."0000".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                    $codigofinal="OC".$aniof."000".($totalRows_t+1);
            }
            if($totalRows_t>98 && $totalRows_t<999){
                $codigofinal="OC".$aniof."00".($totalRows_t+1);
            }
            if($totalRows_t>998 && $totalRows_t<9999){
                $codigofinal="OC".$aniof."0".($totalRows_t+1);
            }
            if($totalRows_t>9998){
                $codigofinal="OC".$aniof.($totalRows_t+1);
            }
            $dato['cod_ocurrencia']=$codigofinal;

            $dato['id_usuario']= $request->input('id_usuario');
            $dato['fec_ocurrencia']= $request->input("fec_ocurrencia");
            $dato['hora']= date('H:i:s');
            $dato['id_tipo']= $request->input("id_tipo");
            $dato['id_zona']= $request->input("id_zona_i");
            $dato['id_estilo']= $request->input("id_estilo_i");
            $dato['id_conclusion']= $request->input("id_conclusion");
            $dato['id_gestion']= $request->input("id_gestion");
            $dato['cantidad'] = $request->input("cantidad");
            $dato['monto'] = $request->input("monto");
            $dato['descripcion'] = $request->input("descripcion");
            $dato['cod_base'] = $request->input("cod_base");
            $dato['estado'] = 1;
            $dato['fec_reg'] =now();
            $dato['user_reg'] = session('usuario')->id_usuario;
            $ocurrencia = Ocurrencias::create($dato);
            $dato2['id_ocurrencia'] = $ocurrencia->id_ocurrencia;

            if (isset($_FILES["files"])) {
                $files = $_FILES["files"];
                $filtered_files = array_filter($files["name"]);
                if (!empty($filtered_files)) {
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if((!$con_id) || (!$lr)){
                        echo "No se conecto";
                    }else{
                        echo "Se conecto";
                        $files = $_FILES["files"];
                        foreach ($files["name"] as $count => $name) {
                            $path = $files["name"][$count];
                            $file_type = $files["type"][$count];
                            $source_file = $files["tmp_name"][$count];
                            $file_error = $files["error"][$count];
                            $file_size = $files["size"][$count];

                            $fecha=date('Y-m-d_His');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Ocurrencia_Tienda_".$fecha."_".rand(10,199);
                            $nombre = $nombre_soli.".".$ext;
                            $dato2['archivo']=$nombre;

                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"SEGURIDAD/OCURRENCIAS/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                $dato2['estado']=1;
                                $dato2['fec_reg']=now();
                                $dato2['user_reg']=session('usuario')->id_usuario;
                                OcurrenciaArchivo::create($dato2);
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }
                }
            }

        }
    }

    public function Tipo_Piocha(Request $request){
        $dato['id_tipo'] =  $request->input("id_tipo");
        $dato['list_tipo'] = DB::table('tipo_ocurrencia')
                            ->select('id_tipo_ocurrencia')
                            ->where('nom_tipo_ocurrencia','like','Piocha%')
                            ->where('id_tipo_ocurrencia', $dato['id_tipo'])
                            ->where('estado', 1)
                            ->get();
        if(count($dato['list_tipo'])>0){
            echo "Si";
        }
    }

    public function Modal_Update_Ocurrencia_Tienda_Admin($id_ocurrencia){
        $dato['get_id'] = Ocurrencias::get_list_ocurrencia($id_ocurrencia);
        $dato['get_id_files_ocurrencia'] = OcurrenciaArchivo::where('estado',1)
                                        ->where('id_ocurrencia', $id_ocurrencia)
                                        ->get();
        $dato['list_usuario'] = Usuario::where('estado', 1)
                                ->whereIn('id_puesto', [23,24,36])
                                ->get();

        $dato['base'] = $dato['get_id'][0]['cod_base'];
        $dato['list_tipo'] = DB::table('tipo_ocurrencia')
                            ->where('base', $dato['base'])
                            ->get();
        $dato['list_conclusion'] = OcurrenciaConclusion::where('estado', 1)
                        ->get();
        $dato['list_gestion'] = OcurrenciaGestion::where('estado', 1)
                        ->get();
        $dato['list_base'] = Base::select('cod_base')
                        ->where('estado', 1)
                        ->groupBy('cod_base')
                        ->orderBy('cod_base', 'ASC')
                        ->get();
        $dato['url'] = Config::where('descrip_config', 'Ocurrencia_Tienda')
                        ->where('estado', 1)
                        ->get();
        return view('seguridad.ocurrencias_tienda.modal_editar_admin',$dato);
    }

    public function Descargar_Archivo_Ocurrencia($id_ocurrencia_archivo) {
        // Obtener el archivo de la base de datos
        $archivo = OcurrenciaArchivo::where('estado', 1)
                    ->where('id_ocurrencia', $id_ocurrencia_archivo)
                    ->first();

        // Obtener la URL de configuración
        $config = Config::where('estado', 1)
                    ->where('descrip_config', 'Ocurrencia_Tienda')
                    ->first();

        // Verificar si se obtuvieron los datos
        if (!$archivo || !$config) {
            return abort(404, 'Archivo o configuración no encontrada.');
        }

        // Construir la ruta completa del archivo
        $filePath = $config->url_config . $archivo->archivo;
        $fileName = basename($filePath);
        print_r($archivo);
/*
        // Descargar el archivo
        if (file_exists($filePath)) {
            return Response::download($filePath, $fileName);
        } else {
            return abort(404, 'El archivo no existe en el servidor.');
        }*/
    }


    public function Delete_Archivo_Ocurrencia() {
        $id_ocurrencia_archivo = $this->input->post('image_id');
        $this->Model_Corporacion->delete_archivo_ocurrencia($id_ocurrencia_archivo);
    }

    public function Update_Ocurrencia_Tienda(Request $request){
        $request->validate([
            'id_tipoe' => 'required',
            'id_gestione' => 'required',
            'cod_basee' => 'not_in:0',
            'descripcione' => 'required',
        ],[
            'id_tipoe.required' => 'Debe ingresar tipo.',
            'id_gestione.required' => 'Debe ingresar gestion.',
            'cod_basee.not_in' => 'Debe seleccionar base',
            'descripcione.required' => 'Debe ingresar descripcion.',
        ]);

        $valida = Ocurrencias::where('fec_ocurrencia', $request->fec_ocurrenciae)
                    ->where('user_reg', session('usuario')->id_usuario)
                    ->where('id_tipo', $request->id_tipoe)
                    ->where('id_conclusion', $request->id_conclusione)
                    ->where('id_gestion', $request->id_gestione)
                    ->where('descripcion', $request->descripcione)
                    ->where('estado', 1)
                    ->exists();
        if ($valida){
            echo "error";
        }else{
            $id_ocurrencia = $request->input("id_ocurrencia");
            //$dato['cod_ocurrencia']= $request->input("cod_ocurrencia");
            $dato['cod_base'] = $request->input("cod_basee");
            $dato['fec_ocurrencia'] = $request->input("fec_ocurrenciae");
            $dato['id_usuario'] = $request->input("id_usuarioe");
            $dato['id_tipo']= $request->input("id_tipoe");
            $dato['id_zona']= $request->input("id_zona_u");
            $dato['id_estilo']= $request->input("id_estilo_u");
            $dato['id_conclusion']= $request->input("id_conclusione");
            $dato['id_gestion']= $request->input("id_gestione");
            $dato['monto'] = $request->input("montoe");
            $dato['cantidad'] = $request->input("cantidade");
            $dato['descripcion'] = $request->input("descripcione");
            $dato['hora'] = $request->input("horae");
            $dato['fec_act'] =now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Ocurrencias::findOrfail($id_ocurrencia)->update($dato);
            if (isset($_FILES["files_u_admin"])) {
                $files = $_FILES["files_u_admin"];
                $filtered_files = array_filter($files["name"]);
                if (!empty($filtered_files)) {
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if((!$con_id) || (!$lr)){
                        echo "No se conecto";
                    }else{
                        echo "Se conecto";
                        $dato['ruta']="";
                        $files = $_FILES["files_u_admin"];
                        foreach ($files["name"] as $count => $name) {
                            $path = $files["name"][$count];
                            $file_type = $files["type"][$count];
                            $source_file = $files["tmp_name"][$count];
                            $file_error = $files["error"][$count];
                            $file_size = $files["size"][$count];

                            $fecha=date('Y-m-d_His');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Ocurrencia_Tienda_".$fecha."_".rand(10,199);
                            $nombre = $nombre_soli.".".$ext;
                            $dato['ruta']=$nombre;

                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"SEGURIDAD/OCURRENCIAS/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                $dato2['estado']=1;
                                $dato2['fec_reg']=now();
                                $dato2['user_reg']=session('usuario')->id_usuario;
                                OcurrenciaArchivo::create($dato2);
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }
                }
            }
        }
    }

    public function Delete_Ocurrencia(Request $request){
        $id_ocurrencia= $request->input("id_ocurrencia");
        $dato = [
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario,
        ];
        Ocurrencias::findOrfail($id_ocurrencia)->update($dato);
    }

    public function Excel_Ocurrencia($cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador){
        $fecha = substr($fecha,0,4)."-".substr($fecha,4,2)."-".substr($fecha,-2);
        $fecha_fin = substr($fecha_fin,0,4)."-".substr($fecha_fin,4,2)."-".substr($fecha_fin,-2);
        $list_ocurrencia = Ocurrencias::get_list_ocurrencia($id_ocurrencia=null,$cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Ocurrencia Tienda');

        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(15);
		$sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
		$sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(85);
        $sheet->getColumnDimension('N')->setWidth(15);

        $sheet->getStyle('A1:N1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFill()
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

        $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Base');
		$sheet->setCellValue('D1', 'Colaborador');
		$sheet->setCellValue('E1', 'Ocurrencia');
        $sheet->setCellValue('F1', 'Zona');
        $sheet->setCellValue('G1', 'Estilo');
        $sheet->setCellValue('H1', 'Conclusión');
        $sheet->setCellValue('I1', 'Gestión');
        $sheet->setCellValue('J1', 'Cantidad');
        $sheet->setCellValue('K1', 'Monto');
        $sheet->setCellValue('L1', 'Hora');
        $sheet->setCellValue('M1', 'Descripción');
        $sheet->setCellValue('N1', 'Revisado');

        $contador=1;

        foreach($list_ocurrencia as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_ocurrencia']);
            $sheet->setCellValue("B{$contador}", $list['fecha_ocurrencia']);
            $sheet->setCellValue("C{$contador}", $list['cod_base']);
            $sheet->setCellValue("D{$contador}", $list['colaborador']);
            $sheet->setCellValue("E{$contador}", $list['nom_tipo_ocurrencia']);
            $sheet->setCellValue("F{$contador}", $list['nom_zona']);
            $sheet->setCellValue("G{$contador}", $list['nom_estilo']);
            $sheet->setCellValue("H{$contador}", $list['nom_conclusion']);
            $sheet->setCellValue("I{$contador}", $list['nom_gestion']);
            $sheet->setCellValue("J{$contador}", $list['cantidad']);
            $sheet->setCellValue("K{$contador}", "S/. ".$list['monto']);
            $sheet->setCellValue("L{$contador}", $list['hora']);
            $sheet->setCellValue("M{$contador}", $list['descripcion']);
            $sheet->setCellValue("N{$contador}", $list['v_revisado']);
        }

        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista_Ocurrencia_'.$curdate;
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Buscar_Tipo_Ocurrencia(Request $request){
        $dato['list_tipo'] = DB::table('tipo_ocurrencia')
                            ->where('base', $request->input("cod_base"))
                            ->where('estado', 1)
                            ->get();
        return view("seguridad.ocurrencias_tienda.cmb_tipo_o", $dato);
    }
}

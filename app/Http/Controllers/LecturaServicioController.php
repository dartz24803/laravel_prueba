<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\DatosServicio;
use App\Models\LecturaServicio;
use App\Models\Mes;
use App\Models\Servicio;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LecturaServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.lectura_servicio.index');
    }

    public function index_reg()
    {
        $list_servicio = Servicio::where('lectura',1)->where('estado',1)->get();
        $list_mes = Mes::select('cod_mes','nom_mes')->where('estado',1)->get();
        $list_anio = Anio::select('cod_anio')->where('estado',1)->orderBy('cod_anio','DESC')->get();
        return view('seguridad.lectura_servicio.lectura.index',compact('list_servicio','list_mes','list_anio'));
    }

    public function list_reg(Request $request)
    {
        $list_lectura_servicio = LecturaServicio::get_list_lectura_servicio(['id_servicio'=>$request->id_servicio,'mes'=>$request->mes,'anio'=>$request->anio]);
        return view('seguridad.lectura_servicio.lectura.lista', compact('list_lectura_servicio'));
    }

    public function create_reg()
    {
        $list_servicio = Servicio::where('lectura',1)->where('estado',1)->get();
        return view('seguridad.lectura_servicio.lectura.modal_registrar',compact('list_servicio'));
    }

    public function traer_suministro_reg(Request $request)
    {
        $list_suministro = DatosServicio::select('id_datos_servicio','suministro')
                        ->where('cod_base',session('usuario')->centro_labores)
                        ->where('id_servicio',$request->id_servicio)->where('id_lugar_servicio','!=','1')
                        ->where('estado',1)->get();
        return view('seguridad.lectura_servicio.lectura.suministro',compact('list_suministro'));
    }

    public function traer_lectura_reg(Request $request)
    {
        $ultimo = LecturaServicio::select('lect_ing')
                    ->where('id_servicio',$request->id_servicio)
                    ->where('cod_base',session('usuario')->centro_labores)
                    ->where('id_datos_servicio',$request->id_datos_servicio)
                    ->where('estado',1)->orderBy('id','DESC')->first();
        if($ultimo){
            echo $ultimo->lect_ing;
        }
    }

    public function store_reg(Request $request)
    {
        $request->validate([
            'id_servicio' => 'gt:0',
            'id_datos_servicio' => 'gt:0',
            'hora_ing' => 'required',
            'lect_ing' => 'required'
        ],[
            'id_servicio.gt' => 'Debe seleccionar servicio.',
            'id_datos_servicio.gt' => 'Debe seleccionar suministro.',
            'hora_ing.required' => 'Debe ingresar hora.',
            'lect_ing.required' => 'Debe ingresar lectura.'
        ]);

        $valida = LecturaServicio::where('fecha', date('Y-m-d'))->where('id_servicio', $request->id_servicio)
                ->where('id_datos_servicio', $request->id_datos_servicio)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            $archivo = "";
            if($_FILES["img_ing"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $path = $_FILES["img_ing"]["name"];
                    $source_file = $_FILES['img_ing']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "LectIng_".$request->id_servicio."_".$request->id_datos_servicio."_".date('YmdHis');
                    $nombre = $nombre_soli.".".strtolower($ext);
    
                    ftp_pasv($con_id,true);
                    $subio = ftp_put($con_id,"LECTURA_SERVICIO/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        $archivo = "https://lanumerounocloud.com/intranet/LECTURA_SERVICIO/".$nombre;
                    }else{
                        echo "Archivo no subido correctamente";
                    }
                }else{
                    echo "No se conecto";
                }
            }

            LecturaServicio::create([
                'cod_base' => session('usuario')->centro_labores,
                'fecha' => now(),
                'hora_ing' => $request->hora_ing,
                'lect_ing' => $request->lect_ing,
                'img_ing' => $archivo,
                'id_servicio' => $request->id_servicio,
                'id_datos_servicio' => $request->id_datos_servicio,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_reg($id,$tipo)
    {
        $get_id = LecturaServicio::findOrFail($id);
        $list_servicio = Servicio::where('lectura',1)->where('estado',1)->get();
        $list_suministro = DatosServicio::select('id_datos_servicio','suministro')
                            ->where('cod_base',$get_id->cod_base)
                            ->where('id_servicio',$get_id->id_servicio)->where('id_lugar_servicio','!=','1')
                            ->where('estado',1)->get();
        return view('seguridad.lectura_servicio.lectura.modal_editar',compact('get_id','tipo','list_servicio','list_suministro'));
    }

    public function download_reg($id,$tipo)
    {
        $get_id = LecturaServicio::findOrFail($id);

        if($tipo=="ing"){
            $archivo = $get_id->img_ing;
        }else{
            $archivo = $get_id->img_sal;
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

    public function update_reg(Request $request,$id,$tipo)
    {
        $validate = $request->validate([
            'hora_'.$tipo.'e' => 'required',
            'lect_'.$tipo.'e' => 'required'
        ],[
            'hora_'.$tipo.'e.required' => 'Debe ingresar hora.',
            'lect_'.$tipo.'e.required' => 'Debe ingresar lectura.'
        ]);

        $get_id = LecturaServicio::findOrFail($id);

        $errors = [];

        if ($get_id) {
            if($tipo=="ing"){
                if ($validate['hora_'.$tipo.'e'] >= $get_id->hora_sal) {
                    $errors['hora_'.$tipo.'e'] = ['Debe ingresar hora menor a la de salida.'];
                }
                if ($validate['lect_'.$tipo.'e'] >= $get_id->lect_sal) {
                    $errors['lect_'.$tipo.'e'] = ['Debe ingresar lectura menor a la de salida.'];
                }
            }else{
                if ($validate['hora_'.$tipo.'e'] < $get_id->hora_ing) {
                    $errors['hora_'.$tipo.'e'] = ['Debe ingresar hora mayor a la de ingreso.'];
                }
                if ($validate['lect_'.$tipo.'e'] < $get_id->lect_ing) {
                    $errors['lect_'.$tipo.'e'] = ['Debe ingresar lectura mayor a la de ingreso.'];
                }
            }
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $archivo = "";
        if($_FILES["img_".$tipo."e"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if($tipo=="ing"){
                    if($get_id->img_ing!=""){
                        ftp_delete($con_id, 'LECTURA_SERVICIO/'.basename($get_id->img_ing));
                    }
                }else{
                    if($get_id->img_sal!=""){
                        ftp_delete($con_id, 'LECTURA_SERVICIO/'.basename($get_id->img_sal));
                    }
                }
                $path = $_FILES["img_".$tipo."e"]["name"];
                $source_file = $_FILES['img_'.$tipo.'e']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "LectIng_".$get_id->id_servicio."_".$get_id->id_datos_servicio."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"LECTURA_SERVICIO/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/LECTURA_SERVICIO/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        LecturaServicio::findOrFail($id)->update([
            'hora_'.$tipo => $request->input('hora_'.$tipo.'e'),
            'lect_'.$tipo => $request->input('lect_'.$tipo.'e'),
            'img_'.$tipo => $archivo,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function excel_reg($id_servicio,$mes,$anio)
    {
        $list_lectura_servicio = LecturaServicio::get_list_lectura_servicio(['id_servicio'=>$id_servicio,'mes'=>$mes,'anio'=>$anio]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Lectura Servicio');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:G1")->getFill()
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

        $sheet->getStyle("A1:G1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Fecha');     
        $sheet->setCellValue("B1", 'Servicio');           
        $sheet->setCellValue("C1", 'Suministro');             
        $sheet->setCellValue("D1", 'Hora Ingreso');             
        $sheet->setCellValue("E1", 'Lectura Ingreso');             
        $sheet->setCellValue("F1", 'Hora Salida');       
        $sheet->setCellValue("G1", 'Lectura Salida');             

        $contador=1;
        
        foreach($list_lectura_servicio as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->nom_servicio);
            $sheet->setCellValue("C{$contador}", $list->suministro);
            $sheet->setCellValue("D{$contador}", $list->hora_ing);
            $sheet->setCellValue("E{$contador}", $list->lect_ing);
            $sheet->setCellValue("F{$contador}", $list->hora_sal);
            $sheet->setCellValue("G{$contador}", $list->lect_sal);
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Lectura Servicio';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Error;
use App\Models\Suceso;
use App\Models\TipoError;
use App\Models\Usuario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Support\Facades\DB;

class ObservacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index_reg()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('caja.observacion.index',compact('list_base'));
    }

    public function list_reg(Request $request)
    {
        $list_suceso = Suceso::get_list_suceso(['estado_suceso'=>$request->estado_suceso,'cod_base'=>$request->cod_base,'fecha_inicio'=>$request->fecha_inicio,'fecha_fin'=>$request->fecha_fin]);
        return view('caja.observacion.lista', compact('list_suceso'));
    }

    public function create_reg()
    {
        $list_tipo_error = TipoError::where('estado',1)->orderBy('nom_tipo_error')->get();
        $list_base = Base::get_list_bases_tienda();
        $list_responsable = Usuario::select('id_usuario',DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario'))
                            ->where('centro_labores',session('usuario')->centro_labores)->whereNotIn('id_nivel',[8,12])->where('estado',1)
                            ->orderBy('usuario_apater','ASC')->orderBy('usuario_amater','ASC')->orderBy('usuario_nombres','ASC')->get();
        return view('caja.observacion.modal_registrar',compact('list_tipo_error','list_base','list_responsable'));
    }

    public function traer_error_reg(Request $request)
    {
        $list_error = Error::select('id_error','nom_error')->where('id_tipo_error',$request->id_tipo_error)
                    ->where('estado',1)->orderBy('nom_error','ASC')->get();
        return view('caja.observacion.error',compact('list_error'));
    }

    public function traer_datos_error_reg(Request $request)
    {
        $parametro = $request->parametro;
        $get_error = Error::findOrFail($request->id_error);
        return view('caja.observacion.datos_error',compact('parametro','get_error'));
    }

    public function traer_responsable_reg(Request $request)
    {
        $list_responsable = Usuario::select('id_usuario',DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario'))
                            ->where('centro_labores',$request->cod_base)->whereNotIn('id_nivel',[8,12])->where('estado',1)
                            ->orderBy('usuario_apater','ASC')->orderBy('usuario_amater','ASC')->orderBy('usuario_nombres','ASC')->get();
        return view('caja.observacion.responsable',compact('list_responsable'));
    }
    
    public function store_reg(Request $request)
    {
        $request->validate([
            'id_tipo_error' => 'gt:0',
            'id_error' => 'gt:0',
            'responsables' => 'required',
            'nom_suceso' => 'required'
        ],[
            'id_tipo_error.gt' => 'Debe seleccionar tipo de error.',
            'id_error.gt' => 'Debe seleccionar error.',
            'responsables.required' => 'Debe seleccionar al menos un responsable.',
            'nom_suceso.required' => 'Debe ingresar suceso.'
        ]);

        $get_error = Error::findOrFail($request->id_error);

        $errors = [];

        if($get_error->monto=="1"){
            if ($request->monto == "") {
                $errors['monto'] = ['Debe ingresar monto.'];
            }
        }
        if($get_error->archivo=="1"){
            if ($_FILES["archivo"]["name"] == "") {
                $errors['archivo'] = ['Debe ingresar archivo.'];
            }
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $anio = date('Y');
        $fin_anio = substr($anio, -2);
        $totalRows_t = Suceso::where('cod_suceso','like',$fin_anio.'%')->where('estado',1)->count();

        if(($totalRows_t+1)<=9){
            $codigo = $fin_anio."-0000".($totalRows_t+1);
        }
        if(($totalRows_t+1)>9 && ($totalRows_t+1)<=99){
            $codigo = $fin_anio."-000".($totalRows_t+1);
        }
        if(($totalRows_t+1)>99 && ($totalRows_t+1)<=999){
            $codigo = $fin_anio."-00".($totalRows_t+1);
        }
        if(($totalRows_t+1)>999 && ($totalRows_t+1)<=9999){
            $codigo = $fin_anio."-0".($totalRows_t+1);
        }
        if(($totalRows_t+1)>9999 && ($totalRows_t+1)<=99999){
            $codigo = $fin_anio."-".($totalRows_t+1);
        }
        
        $user_suceso = implode(",",$request->responsables);
        
        $archivo = "";
        if(isset($_FILES["archivo"]["name"]) && $_FILES["archivo"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $path = $_FILES["archivo"]["name"];
                $source_file = $_FILES['archivo']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = $request->cod_base."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,$request->cod_base."/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/".$request->cod_base."/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        if(($get_error->automatico=="1" && $get_error->monto=="1" && $request->monto<20) || 
        ($get_error->automatico=="1" && $get_error->monto!="1")){
            Suceso::create([
                'cod_suceso' => $codigo,
                'id_tipo_error' => $request->id_tipo_error,
                'id_error' => $request->id_error,
                'centro_labores' => $request->cod_base,
                'user_suceso' => $user_suceso,
                'nom_suceso' => $request->nom_suceso,
                'monto' => $request->monto,
                'archivo' => $archivo,
                'estado_suceso' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }else{
            Suceso::create([
                'id_tipo_error' => $request->id_tipo_error,
                'id_error' => $request->id_error,
                'centro_labores' => $request->cod_base,
                'user_suceso' => $user_suceso,
                'nom_suceso' => $request->nom_suceso,
                'monto' => $request->monto,
                'archivo' => $archivo,
                'estado_suceso' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_reg($id)
    {
        $get_id = Suceso::findOrFail($id);
        $list_tipo_error = TipoError::where('estado',1)->orderBy('nom_tipo_error')->get();
        $list_error = Error::select('id_error','nom_error')->where('id_tipo_error',$get_id->id_tipo_error)
                    ->where('estado',1)->orderBy('nom_error','ASC')->get();
        $get_error = Error::findOrFail($get_id->id_error);                    
        $list_base = Base::get_list_bases_tienda();
        $list_responsable = Usuario::select('id_usuario',DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario'))
                            ->where('centro_labores',$get_id->centro_labores)->whereNotIn('id_nivel',[8,12])->where('estado',1)
                            ->orderBy('usuario_apater','ASC')->orderBy('usuario_amater','ASC')->orderBy('usuario_nombres','ASC')->get();
        return view('caja.observacion.modal_editar',compact('get_id','list_tipo_error','list_error','get_error','list_base','list_responsable'));
    }

    public function update_reg(Request $request, $id)
    {
        $request->validate([
            'id_tipo_errore' => 'gt:0',
            'id_errore' => 'gt:0',
            'responsablese' => 'required',
            'nom_sucesoe' => 'required'
        ],[
            'id_tipo_errore.gt' => 'Debe seleccionar tipo de error.',
            'id_errore.gt' => 'Debe seleccionar error.',
            'responsablese.required' => 'Debe seleccionar al menos un responsable.',
            'nom_sucesoe.required' => 'Debe ingresar suceso.'
        ]);

        $get_error = Error::findOrFail($request->id_errore);

        $errors = [];

        if($get_error->monto=="1"){
            if ($request->montoe == "") {
                $errors['montoe'] = ['Debe ingresar monto.'];
            }
        }
        if($get_error->archivo=="1"){
            if ($_FILES["archivoe"]["name"] == "") {
                $errors['archivoe'] = ['Debe ingresar archivo.'];
            }
        }

        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $get_id = Suceso::findOrFail($id);
        
        $user_suceso = implode(",",$request->responsablese);
        
        $archivo = "";
        if(isset($_FILES["archivoe"]["name"]) && $_FILES["archivoe"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if($get_id->archivo!=""){
                    ftp_delete($con_id, $get_id->centro_labores."/".basename($get_id->archivo));
                }

                $path = $_FILES["archivoe"]["name"];
                $source_file = $_FILES['archivoe']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = $request->cod_basee."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,$request->cod_basee."/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/".$request->cod_basee."/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        Suceso::findOrFail($id)->update([
            'id_tipo_error' => $request->id_tipo_errore,
            'id_error' => $request->id_errore,
            'centro_labores' => $request->cod_basee,
            'user_suceso' => $user_suceso,
            'nom_suceso' => $request->nom_sucesoe,
            'monto' => $request->montoe,
            'archivo' => $archivo,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function download_reg($id)
    {
        $get_id = Suceso::findOrFail($id);

        // URL del archivo
        $url = $get_id->archivo;

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

    public function cambiar_estado_reg($id)
    {
        $anio = date('Y');
        $fin_anio = substr($anio, -2);
        $totalRows_t = Suceso::where('cod_suceso','like',$fin_anio.'%')->where('estado',1)->count();

        if(($totalRows_t+1)<=9){
            $codigo = $fin_anio."-0000".($totalRows_t+1);
        }
        if(($totalRows_t+1)>9 && ($totalRows_t+1)<=99){
            $codigo = $fin_anio."-000".($totalRows_t+1);
        }
        if(($totalRows_t+1)>99 && ($totalRows_t+1)<=999){
            $codigo = $fin_anio."-00".($totalRows_t+1);
        }
        if(($totalRows_t+1)>999 && ($totalRows_t+1)<=9999){
            $codigo = $fin_anio."-0".($totalRows_t+1);
        }
        if(($totalRows_t+1)>9999 && ($totalRows_t+1)<=99999){
            $codigo = $fin_anio."-".($totalRows_t+1);
        }

        Suceso::findOrFail($id)->update([
            'cod_suceso' => $codigo,
            'estado_suceso' => 2,
            'usuario_aprobado' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        echo $codigo;
    }

    public function destroy_reg($id)
    {
        Suceso::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel_reg($estado_suceso,$cod_base,$fecha_inicio,$fecha_fin)
    {
        $list_suceso = Suceso::get_list_suceso(['estado_suceso'=>$estado_suceso,'cod_base'=>$cod_base,'fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Observación');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(60);
        $sheet->getColumnDimension('H')->setWidth(60);

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:H1")->getFill()
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

        $sheet->getStyle("A1:H1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'Fecha');
        $sheet->setCellValue('B1', 'Base');
		$sheet->setCellValue('C1', 'Nº de OBER');
		$sheet->setCellValue('D1', 'Tipo Error');
        $sheet->setCellValue('E1', 'Error');
        $sheet->setCellValue('F1', 'Monto');
        $sheet->setCellValue('G1', 'Suceso');
        $sheet->setCellValue('H1', 'Responsable');           

        $contador=1;
        
        foreach($list_suceso as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

            $sheet->setCellValue("A{$contador}", $list->fecha);
            $sheet->setCellValue("B{$contador}", $list->centro_labores);
            $sheet->setCellValue("C{$contador}", $list->cod_suceso);
            $sheet->setCellValue("D{$contador}", $list->nom_tipo_error);
            $sheet->setCellValue("E{$contador}", $list->nom_error);
            $sheet->setCellValue("F{$contador}", $list->monto);
            $sheet->setCellValue("G{$contador}", $list->nom_suceso);
            $sheet->setCellValue("H{$contador}", $list->user_suceso);
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Observación';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
}

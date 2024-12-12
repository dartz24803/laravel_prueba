<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AperturaCierreTienda;
use App\Models\ArchivosAperturaCierreTienda;
use App\Models\ArchivoTemporal;
use App\Models\Base;
use App\Models\CObservacionAperturaCierreTienda;
use App\Models\Notificacion;
use App\Models\ObservacionAperturaCierreTienda;
use App\Models\TiendaMarcacionDia;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\DB;
use App\Models\SubGerencia;
use App\Models\TiendaMarcacion;

class AperturaCierreTiendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(1);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();            
        return view('seguridad.apertura_cierre.index',compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_reg()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('seguridad.apertura_cierre.registro.index', compact('list_base'));
    }

    public function list_reg(Request $request)
    {
        $list_apertura_cierre_tienda = AperturaCierreTienda::get_list_apertura_cierre_tienda(['cod_base' => $request->cod_base, 'fec_ini' => $request->fec_ini, 'fec_fin' => $request->fec_fin]);
        return view('seguridad.apertura_cierre.registro.lista', compact('list_apertura_cierre_tienda'));
    }

    public function valida_modal_reg()
    {
        $valida = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_ingreso')
            ->join('tienda_marcacion', 'tienda_marcacion.id_tienda_marcacion', '=', 'tienda_marcacion_dia.id_tienda_marcacion')
            ->where('tienda_marcacion.cod_base', session('usuario')->centro_labores)
            ->where('tienda_marcacion_dia.dia', date('N'))
            ->exists();
        if (!$valida) {
            echo "error";
        }
    }

    public function create_reg()
    {
        //LIMPIAR LOS ARCHIVOS TEMPORALES
        $list_archivo = ArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                        ->where('tabla','APERTURA_CIERRE_TIENDA')->get();
        if(count($list_archivo)>0){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                foreach($list_archivo as $list){
                    $file_to_delete = "APERTURA_CIERRE_TIENDA/".basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        ArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }
        $get_hora = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_ingreso')
                    ->join('tienda_marcacion', 'tienda_marcacion.id_tienda_marcacion', '=', 'tienda_marcacion_dia.id_tienda_marcacion')
                    ->where('tienda_marcacion.cod_base', session('usuario')->centro_labores)
                    ->where('tienda_marcacion.estado', 1)
                    ->where('tienda_marcacion_dia.dia', date('N'))
                    ->first();
        $list_observacion = CObservacionAperturaCierreTienda::select('id', 'descripcion')->get();
        return view('seguridad.apertura_cierre.registro.modal_registrar', compact('get_hora', 'list_observacion'));
    }

    public function list_archivo_reg()
    {
        $list_archivo = ArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                        ->where('tabla','APERTURA_CIERRE_TIENDA')->get();
        return view('seguridad.apertura_cierre.registro.lista_archivo', compact('list_archivo'));
    }

    public function habilitar_boton_reg()
    {
        $cantidad = ArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                    ->where('tabla','APERTURA_CIERRE_TIENDA')->count();
        $get_id = TiendaMarcacion::where('cod_base',session('usuario')->centro_labores)->first();                    
        if($cantidad==$get_id->cantidad_foto){
            echo "Si";
        }else{
            echo "No";
        }
    }

    public function previsualizacion_captura_reg()
    {
        $valida = ArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                ->where('tabla','APERTURA_CIERRE_TIENDA')->get();
        $get_id = TiendaMarcacion::where('cod_base',session('usuario')->centro_labores)->first();
        if(count($valida)==$get_id->cantidad_foto){
            echo "¡No se puede tomar más de ".$get_id->cantidad_foto." captura(s)!";
        }else{
            if ($_FILES["photo"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $path = $_FILES["photo"]["name"];
                    $source_file = $_FILES['photo']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "temporal_" . session('usuario')->id_usuario."_".date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    $archivo = "https://lanumerounocloud.com/intranet/APERTURA_CIERRE_TIENDA/".$nombre;
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "APERTURA_CIERRE_TIENDA/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        ArchivoTemporal::create([
                            'id_usuario' => session('usuario')->id_usuario,
                            'tabla' => 'APERTURA_CIERRE_TIENDA',
                            'archivo' => $archivo
                        ]);
                    }else{
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
        }
    }

    public function delete_archivo_temporal_reg($id)
    {
        $get_id = ArchivoTemporal::findOrFail($id);
        if($get_id->archivo!=""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $file_to_delete = "APERTURA_CIERRE_TIENDA/".basename($get_id->archivo);
                if (ftp_delete($con_id, $file_to_delete)) {
                    ArchivoTemporal::destroy($id);
                }
            }
        }
    }

    public function store_reg(Request $request)
    {
        $valida = AperturaCierreTienda::where('fecha', date('Y-m-d'))
                ->where('cod_base', session('usuario')->centro_labores)
                ->where('estado', 1)->exists();

        if ($valida) {
            echo "error";
        } else {
            $get_hora = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_ingreso')
                        ->join('tienda_marcacion', 'tienda_marcacion.id_tienda_marcacion', '=', 'tienda_marcacion_dia.id_tienda_marcacion')
                        ->where('tienda_marcacion.cod_base', session('usuario')->centro_labores)
                        ->where('tienda_marcacion.estado', 1)
                        ->where('tienda_marcacion_dia.dia', date('N'))
                        ->first();

            $apertura = AperturaCierreTienda::create([
                'fecha' => date('Y-m-d'),
                'cod_base' => session('usuario')->centro_labores,
                'ingreso_horario' => $get_hora->hora_ingreso,
                'ingreso' => now(),
                'obs_ingreso' => $request->otra_observacion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if (is_array($request->observaciones) && count($request->observaciones) > 0) {
                foreach ($request->observaciones as $observacion) {
                    ObservacionAperturaCierreTienda::create([
                        'id_apertura_cierre' => $apertura->id_apertura_cierre,
                        'tipo_apertura' => 1,
                        'id_observacion' => $observacion
                    ]);
                }
            }

            $list_archivo = ArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                            ->where('tabla','APERTURA_CIERRE_TIENDA')->get();

            if(count($list_archivo)>0){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $i = 1;
                    foreach($list_archivo as $list){
                        $nombre_actual = "APERTURA_CIERRE_TIENDA/".basename($list->archivo);
                        $nuevo_nombre = "APERTURA_CIERRE_TIENDA/Evidencia_".$apertura->id_apertura_cierre."_".date('YmdHis')."_".$i.".jpg";
                        ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                        $archivo = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;
    
                        ArchivosAperturaCierreTienda::create([
                            'id_apertura_cierre' => $apertura->id_apertura_cierre,
                            'tipo_apertura' => 1,
                            'archivo' => $archivo,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
    
                        $i++;
                    }
                }
                ArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                ->where('tabla','APERTURA_CIERRE_TIENDA')->delete();
            }
        }
    }

    public function edit_reg($id)
    {
        $get_id = AperturaCierreTienda::get_list_apertura_cierre_tienda(['id_apertura_cierre' => $id]);
        if ($get_id->tipo_apertura == "2") {
            $minuscula = "apertura";
            $titulo = "Apertura de tienda";
        } elseif ($get_id->tipo_apertura == "3") {
            $minuscula = "cierre";
            $titulo = "Cierre de tienda";
        } elseif ($get_id->tipo_apertura == "4") {
            $minuscula = "salida";
            $titulo = "Salida de personal";
        }
        $get_hora = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_' . $minuscula . ' AS hora_programada')
            ->join('tienda_marcacion', 'tienda_marcacion.id_tienda_marcacion', '=', 'tienda_marcacion_dia.id_tienda_marcacion')
            ->where('tienda_marcacion.cod_base', $get_id->cod_base)
            ->where('tienda_marcacion.estado', 1)
            ->where('tienda_marcacion_dia.dia', date('N'))
            ->first();
        $list_observacion = CObservacionAperturaCierreTienda::select('id', 'descripcion')->get();
        return view('seguridad.apertura_cierre.registro.modal_editar', compact('get_id', 'get_hora', 'titulo', 'list_observacion'));
    }

    public function update_reg(Request $request, $id)
    {
        $get_id = AperturaCierreTienda::get_list_apertura_cierre_tienda(['id_apertura_cierre' => $id]);
        if ($get_id->tipo_apertura == "2") {
            $minuscula = "apertura";
        } elseif ($get_id->tipo_apertura == "3") {
            $minuscula = "cierre";
        } elseif ($get_id->tipo_apertura == "4") {
            $minuscula = "salida";
        }
        $get_hora = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_' . $minuscula . ' AS hora_programada')
            ->join('tienda_marcacion', 'tienda_marcacion.id_tienda_marcacion', '=', 'tienda_marcacion_dia.id_tienda_marcacion')
            ->where('tienda_marcacion.cod_base', session('usuario')->centro_labores)
            ->where('tienda_marcacion.estado', 1)
            ->where('tienda_marcacion_dia.dia', date('N'))
            ->first();

        AperturaCierreTienda::findOrFail($id)->update([
            $minuscula . '_horario' => $get_hora->hora_programada,
            $minuscula => now(),
            'obs_' . $minuscula => $request->otra_observacione,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if (is_array($request->observacionese) && count($request->observacionese) > 0) {
            foreach ($request->observacionese as $observacion) {
                ObservacionAperturaCierreTienda::create([
                    'id_apertura_cierre' => $id,
                    'tipo_apertura' => $get_id->tipo_apertura,
                    'id_observacion' => $observacion
                ]);
            }
        }

        if ($request->capturae == "1") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $nombre_actual = "APERTURA_CIERRE_TIENDA/temporal_" . session('usuario')->id_usuario . ".jpg";
                $nuevo_nombre = "APERTURA_CIERRE_TIENDA/Evidencia_" . $id . "_" . date('YmdHis') . ".jpg";
                ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

                ArchivosAperturaCierreTienda::create([
                    'id_apertura_cierre' => $id,
                    'tipo_apertura' => $get_id->tipo_apertura,
                    'archivo' => $archivo,
                    'fecha' => now(),
                    'usuario' => session('usuario')->id_usuario
                ]);
            } else {
                echo "No se conecto";
            }
        }
    }

    public function archivo_reg($id)
    {
        $get_id = AperturaCierreTienda::select('cod_base', DB::raw('DATE_FORMAT(fecha,"%d/%m/%Y") AS fecha_v'))
            ->where('id_apertura_cierre', $id)
            ->first();
        $list_archivo = ArchivosAperturaCierreTienda::select(
            'archivo',
            'tipo_apertura',
            DB::raw('CASE WHEN tipo_apertura=1 THEN "INGRESO DE PERSONAL" 
                                                    WHEN tipo_apertura=2 THEN "APERTURA DE TIENDA" 
                                                    WHEN tipo_apertura=3 THEN "CIERRE DE TIENDA" 
                                                    WHEN tipo_apertura=4 THEN "SALIDA DE PERSONAL" 
                                                    ELSE "" END AS titulo')
        )
            ->where('id_apertura_cierre', $id)->get();
        return view('seguridad.apertura_cierre.registro.modal_archivo', compact('get_id', 'list_archivo'));
    }

    public function excel_reg($cod_base, $fec_ini, $fec_fin)
    {
        $list_funcion_temporal = AperturaCierreTienda::get_list_apertura_cierre_tienda(['cod_base' => $cod_base, 'fec_ini' => $fec_ini, 'fec_fin' => $fec_fin]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:R1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:R1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Apertura y Cierre de Tienda');

        $sheet->setAutoFilter('A1:R1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(50);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(50);
        $sheet->getColumnDimension('O')->setWidth(25);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(50);

        $sheet->getStyle('A1:R1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:R1")->getFill()
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

        $sheet->getStyle("A1:R1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->getStyle('F')->getAlignment()->setWrapText(true);
        $sheet->getStyle('J')->getAlignment()->setWrapText(true);
        $sheet->getStyle('N')->getAlignment()->setWrapText(true);
        $sheet->getStyle('R')->getAlignment()->setWrapText(true);

        $sheet->setCellValue("A1", 'Base');
        $sheet->setCellValue("B1", 'Fecha');
        $sheet->setCellValue("C1", 'Ingreso Programado');
        $sheet->setCellValue("D1", 'Ingreso Real');
        $sheet->setCellValue("E1", 'Diferencia');
        $sheet->setCellValue("F1", 'Observación');
        $sheet->setCellValue("G1", 'Apertura Programada');
        $sheet->setCellValue("H1", 'Apertura Real');
        $sheet->setCellValue("I1", 'Diferencia');
        $sheet->setCellValue("J1", 'Observación');
        $sheet->setCellValue("K1", 'Cierre Programado');
        $sheet->setCellValue("L1", 'Cierre Real');
        $sheet->setCellValue("M1", 'Diferencia');
        $sheet->setCellValue("N1", 'Observación');
        $sheet->setCellValue("O1", 'Salida Programada');
        $sheet->setCellValue("P1", 'Salida Real');
        $sheet->setCellValue("Q1", 'Diferencia');
        $sheet->setCellValue("R1", 'Observación');

        $contador = 1;

        foreach ($list_funcion_temporal as $list) {
            $contador++;

            if ($list->ingreso_diferencia == null) {
                $spreadsheet->getActiveSheet()->getStyle("E{$contador}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF');
            } else {
                $sheet->getStyle("E{$contador}")->getFont()->getColor()->setRGB('FFFFFF');
                if ($list->ingreso_diferencia > 0) {
                    $spreadsheet->getActiveSheet()->getStyle("E{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('1ABC9C');
                } else {
                    $spreadsheet->getActiveSheet()->getStyle("E{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('E7515A');
                }
            }

            if ($list->apertura_diferencia == null) {
                $spreadsheet->getActiveSheet()->getStyle("I{$contador}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF');
            } else {
                $sheet->getStyle("I{$contador}")->getFont()->getColor()->setRGB('FFFFFF');
                if ($list->apertura_diferencia > 0) {
                    $spreadsheet->getActiveSheet()->getStyle("I{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('1ABC9C');
                } else {
                    $spreadsheet->getActiveSheet()->getStyle("I{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('E7515A');
                }
            }

            if ($list->cierre_diferencia == null) {
                $spreadsheet->getActiveSheet()->getStyle("M{$contador}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF');
            } else {
                $sheet->getStyle("M{$contador}")->getFont()->getColor()->setRGB('FFFFFF');
                if ($list->cierre_diferencia > 0) {
                    $spreadsheet->getActiveSheet()->getStyle("M{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('1ABC9C');
                } else {
                    $spreadsheet->getActiveSheet()->getStyle("M{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('E7515A');
                }
            }

            if ($list->salida_diferencia == null) {
                $spreadsheet->getActiveSheet()->getStyle("Q{$contador}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF');
            } else {
                $sheet->getStyle("Q{$contador}")->getFont()->getColor()->setRGB('FFFFFF');
                if ($list->salida_diferencia > 0) {
                    $spreadsheet->getActiveSheet()->getStyle("Q{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('1ABC9C');
                } else {
                    $spreadsheet->getActiveSheet()->getStyle("Q{$contador}")->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('E7515A');
                }
            }

            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("R{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:R{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:R{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->cod_base);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list->fecha_v));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $list->ingreso_programado);
            $sheet->setCellValue("D{$contador}", $list->ingreso_real);
            $sheet->setCellValue("E{$contador}", $list->ingreso_diferencia);
            $sheet->setCellValue("F{$contador}", $list->obs_ingreso);
            $sheet->setCellValue("G{$contador}", $list->apertura_programada);
            $sheet->setCellValue("H{$contador}", $list->apertura_real);
            $sheet->setCellValue("I{$contador}", $list->apertura_diferencia);
            $sheet->setCellValue("J{$contador}", $list->obs_apertura);
            $sheet->setCellValue("K{$contador}", $list->cierre_programado);
            $sheet->setCellValue("L{$contador}", $list->cierre_real);
            $sheet->setCellValue("M{$contador}", $list->cierre_diferencia);
            $sheet->setCellValue("N{$contador}", $list->obs_cierre);
            $sheet->setCellValue("O{$contador}", $list->salida_programada);
            $sheet->setCellValue("P{$contador}", $list->salida_real);
            $sheet->setCellValue("Q{$contador}", $list->salida_diferencia);
            $sheet->setCellValue("R{$contador}", $list->obs_salida);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Apertura y Cierre de Tienda';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function index_img()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('seguridad.apertura_cierre.imagen.index', compact('list_base'));
    }

    public function list_img(Request $request)
    {
        $list_archivo = ArchivosAperturaCierreTienda::get_list_archivos_apertura_cierre_tienda(['cod_base' => $request->cod_base, 'fec_ini' => $request->fec_ini, 'fec_fin' => $request->fec_fin]);
        return view('seguridad.apertura_cierre.imagen.lista', compact('list_archivo'));
    }

    public function show_img($id)
    {
        $get_id = ArchivosAperturaCierreTienda::select(
            'archivos_apertura_cierre_tienda.id',
            'archivos_apertura_cierre_tienda.archivo',
            'apertura_cierre_tienda.cod_base',
            DB::raw('CASE WHEN archivos_apertura_cierre_tienda.tipo_apertura=1 THEN "Ingreso de personal"
                                                WHEN archivos_apertura_cierre_tienda.tipo_apertura=2 THEN "Apertura de tienda"
                                                WHEN archivos_apertura_cierre_tienda.tipo_apertura=3 THEN "Cierre de tienda"
                                                WHEN archivos_apertura_cierre_tienda.tipo_apertura=4 THEN "Salida de personal" 
                                                ELSE "" END AS tipo_apertura'),
            DB::raw('DATE_FORMAT(archivos_apertura_cierre_tienda.fecha,"%d/%m/%Y %H:%i:%s") AS fecha')
        )
            ->join('apertura_cierre_tienda', 'apertura_cierre_tienda.id_apertura_cierre', '=', 'archivos_apertura_cierre_tienda.id_apertura_cierre')
            ->where('archivos_apertura_cierre_tienda.id', $id)->first();
        return view('seguridad.apertura_cierre.imagen.modal_detalle', compact('get_id'));
    }
}

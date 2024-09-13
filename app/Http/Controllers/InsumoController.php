<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Contometro;
use App\Models\Insumo;
use App\Models\Notificacion;
use App\Models\Proveedor;
use App\Models\RepartoInsumo;
use App\Models\SalidaContometro;
use App\Models\StockTotalInsumo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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

    public function index_ra()
    {
        return view('caja.insumo.reparto_insumo.index');
    }

    public function list_izquierda_ra()
    {
        $list_stock_total_insumo = StockTotalInsumo::all();
        return view('caja.insumo.reparto_insumo.lista_izquierda', compact('list_stock_total_insumo'));
    }

    public function list_derecha_ra()
    {
        $list_reparto_insumo = RepartoInsumo::get_list_reparto_insumo();
        return view('caja.insumo.reparto_insumo.lista_derecha', compact('list_reparto_insumo'));
    }

    public function create_ra()
    {
        $list_insumo = Insumo::select('id_insumo','nom_insumo')->where('estado',1)
                        ->orderBy('nom_insumo','ASC')->get();
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('caja.insumo.reparto_insumo.modal_registrar',compact('list_insumo','list_base'));
    }

    public function store_ra(Request $request)
    {
        $request->validate([
            'id_insumo' => 'gt:0',
            'cod_base' => 'not_in:0',
            'cantidad_reparto' => 'required|gt:0',
            'fec_reparto' => 'required'
        ], [
            'id_insumo.gt' => 'Debe seleccionar insumo.',
            'cod_base.not_in' => 'Debe seleccionar base.',
            'cantidad_reparto.required' => 'Debe ingresar cantidad.',
            'cantidad_reparto.gt' => 'Debe ingresar cantidad mayor a 0.',
            'fec_reparto.required' => 'Debe ingresar fecha.',
        ]);

        $stock = StockTotalInsumo::where('id_insumo',$request->id_insumo)->first();

        if(!isset($stock) || $request->cantidad_reparto>$stock->total){
            echo "error";
        }else{
            RepartoInsumo::create([
                'id_insumo' => $request->id_insumo,
                'cod_base' => $request->cod_base,
                'cantidad_reparto' => $request->cantidad_reparto,
                'fec_reparto' => $request->fec_reparto,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ra($id)
    {
        $get_id = RepartoInsumo::findOrFail($id);
        $list_insumo = Insumo::select('id_insumo','nom_insumo')->where('estado',1)
                        ->orderBy('nom_insumo','ASC')->get();
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('caja.insumo.reparto_insumo.modal_editar', compact('get_id','list_insumo','list_base'));
    }

    public function update_ra(Request $request, $id)
    {
        $request->validate([
            'id_insumoe' => 'gt:0',
            'cod_basee' => 'not_in:0',
            'cantidad_repartoe' => 'required|gt:0',
            'fec_repartoe' => 'required'
        ], [
            'id_insumoe.gt' => 'Debe seleccionar insumo.',
            'cod_basee.not_in' => 'Debe seleccionar base.',
            'cantidad_repartoe.required' => 'Debe ingresar cantidad.',
            'cantidad_repartoe.gt' => 'Debe ingresar cantidad mayor a 0.',
            'fec_repartoe.required' => 'Debe ingresar fecha.',
        ]);

        $stock = StockTotalInsumo::where('id_insumo',$request->id_insumoe)->first();

        if(!isset($stock) || $request->cantidad_repartoe>$stock->total){
            echo "error";
        }else{
            RepartoInsumo::findOrFail($id)->update([
                'id_insumo' => $request->id_insumoe,
                'cod_base' => $request->cod_basee,
                'cantidad_reparto' => $request->cantidad_repartoe,
                'fec_reparto' => $request->fec_repartoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ra($id)
    {
        RepartoInsumo::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel_izquierda_ra()
    {
        $list_stock_total_insumo = StockTotalInsumo::all();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:B1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:B1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Stock Total Insumo');

        $sheet->setAutoFilter('A1:B1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);

        $sheet->getStyle('A1:B1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:B1")->getFill()
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

        $sheet->getStyle("A1:B1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Insumo');
        $sheet->setCellValue("B1", 'Cantidad');

        $contador = 1;

        foreach ($list_stock_total_insumo as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->nom_insumo); 
            $sheet->setCellValue("B{$contador}", $list->total);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Stock Total Insumo';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function excel_derecha_ra()
    {
        $list_reparto_insumo = RepartoInsumo::get_list_reparto_insumo();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:D1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:D1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Reparto de Insumo');

        $sheet->setAutoFilter('A1:D1');

        $sheet->getColumnDimension('A')->setWidth(40);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:D1")->getFill()
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

        $sheet->getStyle("A1:D1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Insumo');
        $sheet->setCellValue("B1", 'Fecha');
        $sheet->setCellValue("C1", 'Base');
        $sheet->setCellValue("D1", 'Cantidad');

        $contador = 1;

        foreach ($list_reparto_insumo as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:D{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->nom_insumo); 
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $list->cod_base); 
            $sheet->setCellValue("D{$contador}", $list->cantidad_reparto);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Reparto de Insumo';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function index_sa()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_insumo = Insumo::select('id_insumo','nom_insumo')->where('estado',1)
                        ->orderBy('nom_insumo','ASC')->get();
        return view('caja.insumo.salida_insumo.index', compact('list_base','list_insumo'));
    }

    public function list_sa(Request $request)
    {
        $list_salida_insumo = SalidaContometro::get_list_salida_contometro([
            'cod_base'=>$request->cod_base,
            'id_insumo'=>$request->id_insumo,
            'inicio'=>$request->inicio,
            'fin'=>$request->fin
        ]);
        return view('caja.insumo.salida_insumo.lista', compact('list_salida_insumo'));
    }

    public function edit_sa($id)
    {
        $get_id = SalidaContometro::findOrFail($id);
        return view('caja.insumo.salida_insumo.modal_editar', compact('get_id'));
    }

    public function update_sa(Request $request, $id)
    {
        $request->validate([
            'cantidad_salidae' => 'required|gt:0'
        ], [
            'cantidad_salidae.required' => 'Debe ingresar cantidad.',
            'cantidad_salidae.gt' => 'Debe ingresar cantidad mayor a 0.'
        ]);

        SalidaContometro::findOrFail($id)->update([
            'cantidad_salida' => $request->cantidad_salidae,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function excel_sa($cod_base, $id_insumo, $inicio, $fin)
    {
        $list_salida_insumo = SalidaContometro::get_list_salida_contometro([
            'cod_base'=>$cod_base,
            'id_insumo'=>$id_insumo,
            'inicio'=>$inicio,
            'fin'=>$fin
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Salida de Insumo');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:F1")->getFill()
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

        $sheet->getStyle("A1:F1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Base');
        $sheet->setCellValue("B1", 'Insumo');
        $sheet->setCellValue("C1", 'Usuario');
        $sheet->setCellValue("D1", 'Cantidad');
        $sheet->setCellValue("E1", 'Fecha');
        $sheet->setCellValue("F1", 'Hora');

        $contador = 1;

        foreach ($list_salida_insumo as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->cod_base); 
            $sheet->setCellValue("B{$contador}", $list->nom_insumo); 
            $sheet->setCellValue("C{$contador}", $list->nom_usuario); 
            $sheet->setCellValue("D{$contador}", $list->cantidad_salida); 
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $list->hora); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Salida de Insumo';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

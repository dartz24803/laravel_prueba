<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\ConceptoCheque;
use App\Models\Empresas;
use App\Models\FinanzasCheque;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TipoMoneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RegistroChequeController extends Controller
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
        return view('finanzas.tesoreria.registro_cheque.index',compact(
            'list_notificacion',
            'list_subgerencia',
            'list_empresa'
        ));
    }

    public function list(Request $request)
    {
        $list_cheque = FinanzasCheque::get_list_cheque([
            'todos'=>$request->todos,
            'id_empresa'=>$request->id_empresa,
            'estado'=>$request->estado,
            'fec_inicio'=>$request->fec_inicio,
            'fec_fin'=>$request->fec_fin,
            'tipo_fecha'=>$request->tipo_fecha,
        ]);
        $list_girado = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_girado"),
                        DB::raw("clp_razsoc AS nom_girado"))
                        ->where('clp_estado','!=','*')->get()->map(function($item) {
                            return (array) $item;
                        })->toArray();
        return view('finanzas.tesoreria.registro_cheque.lista', compact(
            'list_cheque',
            'list_girado'
        ));
    }

    public function create()
    {
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_banco = Banco::select('id_banco','nom_banco')->where('estado',1)
                    ->orderBy('nom_banco','ASC')->get();
        $list_girado = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_girado"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_girado"))
                        ->where('clp_estado','!=','*')->get();
        $list_concepto = ConceptoCheque::select('id_concepto_cheque','nom_concepto_cheque')
                        ->where('estado',1)->orderBy('nom_concepto_cheque','ASC')->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','nom_moneda')->get();
        return view('finanzas.tesoreria.registro_cheque.modal_registrar',compact(
            'list_empresa',
            'list_banco',
            'list_girado',
            'list_concepto',
            'list_tipo_moneda'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'gt:0',
            'id_banco' => 'gt:0',
            'n_cheque' => 'required',
            'fec_emision' => 'required',
            'fec_vencimiento' => 'required|after_or_equal:fec_emision',
            'importe' => 'required|gt:0'
        ],[
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'id_banco.gt' => 'Debe seleccionar banco.',
            'n_cheque.required' => 'Debe ingresar n° cheque.',
            'fec_emision.required' => 'Debe ingresar fecha emisión.',
            'fec_vencimiento.required' => 'Debe ingresar fecha vencimiento.',
            'fec_vencimiento.after_or_equal' => 'Fecha vencimiento no debe ser menor a la fecha emisión.',
            'importe.required' => 'Debe ingresar importe.',
            'importe.gt' => 'Debe ingresar importe mayor a 0.'
        ]);

        $valida = FinanzasCheque::where('id_empresa', $request->id_empresa)->where('n_cheque',$request->n_cheque)
                ->where('id_moneda',$request->id_moneda)->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
            if($request->id_girado!="0"){
                $girado = explode("_",$request->id_girado);
            }

            FinanzasCheque::create([
                'id_empresa' => $request->id_empresa,
                'id_banco' => $request->id_banco,
                'n_cheque' => $request->n_cheque,
                'fec_emision' => $request->fec_emision,
                'fec_vencimiento' => $request->fec_vencimiento,
                'tipo_doc' => $girado[0],
                'num_doc' => $girado[1],
                'concepto' => $request->concepto,
                'id_moneda' => $request->id_moneda,
                'importe' => $request->importe,
                'estado_cheque' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_banco = Banco::select('id_banco','nom_banco')->where('estado',1)
                    ->orderBy('nom_banco','ASC')->get();
        $list_girado = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_girado"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_girado"))
                        ->where('clp_estado','!=','*')->get();
        $list_concepto = ConceptoCheque::select('id_concepto_cheque','nom_concepto_cheque')
                        ->where('estado',1)->orderBy('nom_concepto_cheque','ASC')->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','nom_moneda')->get();
        return view('finanzas.tesoreria.registro_cheque.modal_editar',compact(
            'get_id',
            'list_empresa',
            'list_banco',
            'list_girado',
            'list_concepto',
            'list_tipo_moneda'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_empresae' => 'gt:0',
            'id_bancoe' => 'gt:0',
            'n_chequee' => 'required',
            'fec_emisione' => 'required',
            'fec_vencimientoe' => 'required|after_or_equal:fec_emisione',
            'importee' => 'required|gt:0'
        ],[
            'id_empresae.gt' => 'Debe seleccionar empresa.',
            'id_bancoe.gt' => 'Debe seleccionar banco.',
            'n_chequee.required' => 'Debe ingresar n° cheque.',
            'fec_emisione.required' => 'Debe ingresar fecha emisión.',
            'fec_vencimientoe.required' => 'Debe ingresar fecha vencimiento.',
            'fec_vencimientoe.after_or_equal' => 'Fecha vencimiento no debe ser menor a la fecha emisión.',
            'importee.required' => 'Debe ingresar importe.',
            'importee.gt' => 'Debe ingresar importe mayor a 0.'
        ]);

        $valida = FinanzasCheque::where('id_empresa', $request->id_empresae)->where('n_cheque',$request->n_chequee)
                ->where('id_moneda',$request->id_monedae)->where('estado', 1)->where('id_cheque','!=',$id)->exists();

        if($valida){
            echo "error";
        }else{
            if($request->id_giradoe!="0"){
                $girado = explode("_",$request->id_giradoe);
            }

            FinanzasCheque::findOrFail($id)->update([                
                'id_empresa' => $request->id_empresae,
                'id_banco' => $request->id_bancoe,
                'n_cheque' => $request->n_chequee,
                'fec_emision' => $request->fec_emisione,
                'fec_vencimiento' => $request->fec_vencimientoe,
                'tipo_doc' => $girado[0],
                'num_doc' => $girado[1],
                'concepto' => $request->conceptoe,
                'id_moneda' => $request->id_monedae,
                'importe' => $request->importee,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function update_estado(Request $request, $id)
    {
        if($request->estado=="2"){
            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_autorizado' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="3"){
            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_pend_cobro' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="4"){
            $request->validate([
                'fec_cobroc' => 'required'
            ],[
                'fec_cobroc.required' => 'Debe ingresar fecha cobro.'
            ]);

            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_cobro' => $request->fec_cobroc,
                'noperacion' => $request->noperacionc,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="5"){
            $request->validate([
                'motivo_anuladon' => 'required'
            ],[
                'motivo_anuladon.required' => 'Debe ingresar motivo.'
            ]);
    
            FinanzasCheque::findOrFail($id)->update([
                'motivo_anulado' => $request->motivo_anuladon,
                'estado_cheque' => $request->estado,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="6"){
            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function modal_cancelar($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_cancelar',compact(
            'get_id'
        ));
    }

    public function modal_motivo($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_motivo',compact(
            'get_id'
        ));
    }

    public function update_motivo(Request $request, $id)
    {
        FinanzasCheque::findOrFail($id)->update([
            'motivo_anulado' => $request->motivo_anuladom,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function modal_archivo($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_archivo',compact(
            'get_id'
        ));
    }

    public function update_archivo(Request $request, $id)
    {
        $get_id = FinanzasCheque::findOrFail($id);

        $img_cheque = $get_id->img_cheque;
        if ($_FILES["img_chequea"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->img_cheque!=""){
                    ftp_delete($con_id, "ADM_FINANZAS/CHEQUES/".basename($get_id->img_cheque));
                }

                $path = $_FILES["img_chequea"]["name"];
                $source_file = $_FILES['img_chequea']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Cheques_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "ADM_FINANZAS/CHEQUES/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $img_cheque = "https://lanumerounocloud.com/intranet/ADM_FINANZAS/CHEQUES/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        FinanzasCheque::findOrFail($id)->update([
            'img_cheque' => $img_cheque,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function modal_anular($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_anular',compact(
            'get_id'
        ));
    }

    public function destroy($id)
    {
        FinanzasCheque::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel($todos,$id_empresa,$estado,$fec_inicio,$fec_fin,$tipo_fecha)
    {
        $list_cheque = FinanzasCheque::get_list_cheque([
            'todos'=>$todos,
            'id_empresa'=>$id_empresa,
            'estado'=>$estado,
            'fec_inicio'=>$fec_inicio,
            'fec_fin'=>$fec_fin,
            'tipo_fecha'=>$tipo_fecha,
        ]);
        $list_girado = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_girado"),
                        DB::raw("clp_razsoc AS nom_girado"))
                        ->where('clp_estado','!=','*')->get()->map(function($item) {
                            return (array) $item;
                        })->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cheques');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(22);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(28);
        $sheet->getColumnDimension('J')->setWidth(16);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(25);

        $sheet->getStyle('A1:L1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:L1")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('92D050');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:L1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'EMPRESA');
        $sheet->setCellValue('B1', 'BANCO');
        $sheet->setCellValue('C1', 'NRO. CHEQUE');
        $sheet->setCellValue('D1', 'FEC EMISIÓN');
        $sheet->setCellValue('E1', 'FEC VENCIMIENTO');
        $sheet->setCellValue('F1', 'GIRADO');
        $sheet->setCellValue('G1', 'CONCEPTO');
        $sheet->setCellValue('H1', 'IMPORTE');
        $sheet->setCellValue('I1', 'MOTIVO DE ANULACIÓN');
        $sheet->setCellValue('J1', 'FEC COBRO');
        $sheet->setCellValue('K1', 'NUM. OPERACIÓN');
        $sheet->setCellValue('L1', 'ESTADO');

        $contador = 1;
        $soles = 0;
        $dolares = 0;
        foreach ($list_cheque as $list) {
            $contador++;

            $nom_girado = "";
            $busqueda = in_array($list->id_girado, array_column($list_girado, 'id_girado'));
            $posicion = array_search($list->id_girado, array_column($list_girado, 'id_girado'));    
            if ($busqueda != false) {
                $nom_girado = $list_girado[$posicion]['nom_girado'];
            }

            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            if($list->id_moneda=="1"){
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            }else{
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
            }

            $sheet->setCellValue("A{$contador}", $list->nom_empresa);
            $sheet->setCellValue("B{$contador}", $list->nom_banco);
            $sheet->setCellValue("C{$contador}", $list->n_cheque);
            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list->fec_emision));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH); 
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list->fec_vencimiento));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH); 
            $sheet->setCellValue("F{$contador}", $nom_girado);
            $sheet->setCellValue("G{$contador}", $list->nom_concepto_cheque);
            $sheet->setCellValue("H{$contador}", $list->importe);
            $sheet->setCellValue("I{$contador}", $list->motivo_anulado);
            if($list->fec_cobro!=""){
                $sheet->setCellValue("J{$contador}", Date::PHPToExcel($list->fec_vencimiento));
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH); 
            }
            $sheet->setCellValue("K{$contador}", $list->noperacion); 
            $sheet->setCellValue("L{$contador}", $list->nom_estado);

            if($list->id_moneda=="1"){
                $soles = $soles+$list->importe;
            }else{
                $dolares = $dolares+$list->importe;
            }
        }
        $contador = $contador+1;
        $sheet->setCellValue("G{$contador}", 'Total Soles');
        $sheet->setCellValue("H{$contador}", $soles);
        $sheet->getStyle("G{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("G{$contador}:H{$contador}")->getFont()->setBold(true);
        $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
        $contador = $contador+1;
        $sheet->setCellValue("G{$contador}", 'Total Dólares');
        $sheet->setCellValue("H{$contador}", $dolares);
        $sheet->getStyle("G{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("G{$contador}:H{$contador}")->getFont()->setBold(true);
        $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cheques';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

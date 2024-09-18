<?php

namespace App\Http\Controllers;

use App\Models\EvaluacionCaja;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CapacitacionCajeroController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('caja.capacitacion_cajero.index',compact('list_notificacion'));
    }

    public function list(Request $request)
    { 
        $list_capacitacion_cajero = EvaluacionCaja::select('fec_reg AS orden',
                                    DB::raw('DATE_FORMAT(fec_reg,"%d-%m-%Y %H:%i") AS fecha'),
                                    'base','c_usua_caja','c_usua_nomb','h_ini','h_fin','tiempo')->where('estado',1)
                                    ->orderBy('fec_reg','DESC')
                                    ->get();
        return view('caja.capacitacion_cajero.lista', compact('list_capacitacion_cajero'));
    }

    public function excel()
    {
        $list_capacitacion_cajero = EvaluacionCaja::select('fec_reg AS orden',
                                    DB::raw('DATE_FORMAT(fec_reg,"%d-%m-%Y %H:%i") AS fecha'),
                                    'base','c_usua_caja','c_usua_nomb','h_ini','h_fin','tiempo')->where('estado',1)
                                    ->orderBy('fec_reg','DESC')
                                    ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Capacitación cajero');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);

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
        $sheet->setCellValue("B1", 'Base');
        $sheet->setCellValue("C1", 'Caja');
        $sheet->setCellValue("D1", 'Cajero');
        $sheet->setCellValue("E1", 'Hora inicio');
        $sheet->setCellValue("F1", 'Hora fin');
        $sheet->setCellValue("G1", 'Tiempo');

        $contador = 1;

        foreach ($list_capacitacion_cajero as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->base); 
            $sheet->setCellValue("C{$contador}", $list->c_usua_caja);
            $sheet->setCellValue("D{$contador}", $list->c_usua_nomb);
            $sheet->setCellValue("E{$contador}", $list->h_ini);
            $sheet->setCellValue("F{$contador}", $list->h_fin);
            $sheet->setCellValue("G{$contador}", $list->tiempo);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Capacitación cajero';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

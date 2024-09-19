<?php

namespace App\Http\Controllers;

use App\Models\DuracionTransaccion;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DuracionTransaccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(13);
        return view('caja.duracion_transaccion.index',compact('list_notificacion','list_subgerencia'));
    }

    public function list(Request $request)
    {
        $list_duracion_transaccion = DuracionTransaccion::get_list_duracion_transaccion(['fecha_inicio'=>$request->fecha_inicio,'fecha_fin'=>$request->fecha_fin]);
        return view('caja.duracion_transaccion.lista', compact('list_duracion_transaccion'));
    }

    public function excel($fecha_inicio, $fecha_fin)
    {
        $list_duracion_transaccion = DuracionTransaccion::get_list_duracion_transaccion(['fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Duración de transacción');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(15);
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

        $sheet->setCellValue("A1", 'Base');
        $sheet->setCellValue("B1", 'Cajero');
        $sheet->setCellValue("C1", 'Fecha');
        $sheet->setCellValue("D1", 'Cantidad prendas');
        $sheet->setCellValue("E1", 'Hora inicio');
        $sheet->setCellValue("F1", 'Hora termino');
        $sheet->setCellValue("G1", 'Total tiempo');

        $contador = 1;

        foreach ($list_duracion_transaccion as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:G{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:G{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->NombreBase); 
            $sheet->setCellValue("B{$contador}", $list->NomCajero);
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("D{$contador}", $list->Cantidad);
            $sheet->setCellValue("E{$contador}", $list->hora_inicial);
            $sheet->setCellValue("F{$contador}", $list->hora_final);
            $sheet->setCellValue("G{$contador}", $list->diferencia." min ");
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Duración de transacción';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

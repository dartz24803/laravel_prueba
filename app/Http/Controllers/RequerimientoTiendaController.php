<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\BaseActiva;
use App\Models\MercaderiaSurtida;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RequerimientoTiendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();    
        $list_subgerencia = SubGerencia::list_subgerencia(3);      
        return view('comercial.requerimiento_tienda.index',compact('list_notificacion','list_subgerencia'));
    }

    public function index_re()
    {
        $list_base = BaseActiva::all();
        $list_anio = Anio::select('cod_anio')->where('estado',1)
                    ->where('cod_anio','>=','2024')->get();
        return view('comercial.requerimiento_tienda.reposicion.index', compact(
            'list_base',
            'list_anio'
        ));
    }

    public function list_re(Request $request)
    {
        $list_requerimiento_resposicion = MercaderiaSurtida::get_list_requerimiento_reposicion([
            'anio'=>$request->anio,
            'semana'=>$request->semana,
            'base'=>$request->base
        ]);
        return view('comercial.requerimiento_tienda.reposicion.lista', compact('list_requerimiento_resposicion'));
    }

    public function excel_re($base, $anio, $semana)
    {
        $list_requerimiento_resposicion = MercaderiaSurtida::get_list_requerimiento_reposicion([
            'anio'=>$anio,
            'semana'=>$semana,
            'base'=>$base
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Requerimiento de reposición');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(80);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);

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

        $sheet->setCellValue("A1", 'Base');
        $sheet->setCellValue("B1", 'Estilo');
        $sheet->setCellValue("C1", 'Tipo usuario');
        $sheet->setCellValue("D1", 'Color');
        $sheet->setCellValue("E1", 'Talla');
        $sheet->setCellValue("F1", 'Descripción');
        $sheet->setCellValue("G1", 'Cantidad');
        $sheet->setCellValue("H1", 'Estado');

        $contador = 1;

        foreach ($list_requerimiento_resposicion as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->base); 
            $sheet->setCellValue("B{$contador}", $list->estilo); 
            $sheet->setCellValue("C{$contador}", $list->tipo_usuario); 
            $sheet->setCellValue("D{$contador}", $list->color); 
            $sheet->setCellValue("E{$contador}", $list->talla); 
            $sheet->setCellValue("F{$contador}", $list->descripcion); 
            $sheet->setCellValue("G{$contador}", $list->cantidad); 
            $sheet->setCellValue("H{$contador}", $list->nom_estado); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Requerimiento de reposición';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function index_mn()
    {
        $list_base = BaseActiva::all();
        $list_anio = Anio::select('cod_anio')->where('estado',1)
                    ->where('cod_anio','>=','2024')->get();
        return view('comercial.requerimiento_tienda.mercaderia_nueva.index', compact(
            'list_base',
            'list_anio'
        ));
    }

    public function list_mn(Request $request)
    {
        $list_mercaderia_nueva = MercaderiaSurtida::get_list_mercaderia_nueva([
            'anio'=>$request->anio,
            'semana'=>$request->semana,
            'base'=>$request->base
        ]);
        return view('comercial.requerimiento_tienda.mercaderia_nueva.lista', compact('list_mercaderia_nueva'));
    }

    public function excel_mn($base, $anio, $semana)
    {
        $list_requerimiento_resposicion = MercaderiaSurtida::get_list_mercaderia_nueva([
            'anio'=>$anio,
            'semana'=>$semana,
            'base'=>$base
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:J1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:J1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Mercadería nueva');

        $sheet->setAutoFilter('A1:J1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(80);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:J1")->getFill()
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

        $sheet->getStyle("A1:J1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Base');
        $sheet->setCellValue("B1", 'SKU');
        $sheet->setCellValue("C1", 'Estilo');
        $sheet->setCellValue("D1", 'Tipo usuario');
        $sheet->setCellValue("E1", 'Tipo prenda');
        $sheet->setCellValue("F1", 'Color');
        $sheet->setCellValue("G1", 'Talla');
        $sheet->setCellValue("H1", 'Descripción');
        $sheet->setCellValue("I1", 'Cantidad');
        $sheet->setCellValue("J1", 'Estado');

        $contador = 1;

        foreach ($list_requerimiento_resposicion as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:J{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->base); 
            $sheet->setCellValue("B{$contador}", $list->sku); 
            $sheet->setCellValue("C{$contador}", $list->estilo); 
            $sheet->setCellValue("D{$contador}", $list->tipo_usuario); 
            $sheet->setCellValue("E{$contador}", $list->tipo_prenda); 
            $sheet->setCellValue("F{$contador}", $list->color); 
            $sheet->setCellValue("G{$contador}", $list->talla); 
            $sheet->setCellValue("H{$contador}", $list->descripcion); 
            $sheet->setCellValue("I{$contador}", $list->cantidad); 
            $sheet->setCellValue("J{$contador}", $list->nom_estado); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Mercadería nueva';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

}

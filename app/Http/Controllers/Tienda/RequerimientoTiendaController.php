<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Anio;
use App\Models\MercaderiaSurtida;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        $list_subgerencia = SubGerencia::list_subgerencia(2);      
        return view('tienda.requerimiento_tienda.index',compact('list_notificacion','list_subgerencia'));
    }

    public function index_mn()
    {
        $list_anio = Anio::select('cod_anio')->where('estado',1)
                    ->where('cod_anio','>=','2024')->get();
        return view('tienda.requerimiento_tienda.mercaderia_nueva.index', compact(
            'list_anio'
        ));
    }

    public function list_mn(Request $request)
    {
        $list_mercaderia_nueva = MercaderiaSurtida::get_list_mercaderia_nueva_tienda([
            'anio' => $request->anio,
            'semana' => $request->semana,
            'base' => session('usuario')->centro_labores,
            'estado' => $request->estado
        ]);
        return view('tienda.requerimiento_tienda.mercaderia_nueva.lista', compact('list_mercaderia_nueva'));
    }

    public function excel_mn($anio, $semana, $estado)
    {
        $list_requerimiento_resposicion = MercaderiaSurtida::get_list_mercaderia_nueva_tienda([
            'anio' => $anio,
            'semana' => $semana,
            'base' => session('usuario')->centro_labores,
            'estado' => $estado
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Mercadería nueva');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(80);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()
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

        $sheet->getStyle("A1:I1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'SKU');
        $sheet->setCellValue("B1", 'Estilo');
        $sheet->setCellValue("C1", 'Tipo usuario');
        $sheet->setCellValue("D1", 'Tipo prenda');
        $sheet->setCellValue("E1", 'Color');
        $sheet->setCellValue("F1", 'Talla');
        $sheet->setCellValue("G1", 'Descripción');
        $sheet->setCellValue("H1", 'Cantidad');
        $sheet->setCellValue("I1", 'Estado');

        $contador = 1;

        foreach ($list_requerimiento_resposicion as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->sku); 
            $sheet->setCellValue("B{$contador}", $list->estilo); 
            $sheet->setCellValue("C{$contador}", $list->tipo_usuario); 
            $sheet->setCellValue("D{$contador}", $list->tipo_prenda); 
            $sheet->setCellValue("E{$contador}", $list->color); 
            $sheet->setCellValue("F{$contador}", $list->talla); 
            $sheet->setCellValue("G{$contador}", $list->descripcion); 
            $sheet->setCellValue("H{$contador}", $list->cantidad); 
            $sheet->setCellValue("I{$contador}", $list->nom_estado); 
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

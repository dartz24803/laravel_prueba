<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use App\Models\UsuarioReproceso;
use App\Models\Reproceso;
use App\Models\SubGerencia;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class ReprocesoController extends Controller
{
    public function __construct(){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario')->except(['validar_reporte_fotografico_dia_job']);
    }
    //-------------------------------REPROCESO--------------------------------
    public function Reproceso(){
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);        
        return view('logistica/Reproceso/index', compact('list_notificacion','list_subgerencia'));
    }

    public function Lista_Reproceso(){
        $dato['list_reproceso'] = Reproceso::get_list_reproceso();
        return view('logistica/Reproceso/lista',$dato);
    }

    public function Modal_Reproceso(){
        $dato['list_usuario'] = UsuarioReproceso::get();
        return view('logistica/Reproceso/modal_registrar', $dato);   
    }

    public function Insert_Reproceso(Request $request){
        $request->validate([
            'usuario' => 'not_in:0',
            'fecha_documento' => 'required',
            'documento' => 'required',
            'descripcion' => 'required',
            'cantidad' => 'required',
            'proveedor' => 'required',
            'estado_r' => 'not_in:0',
        ],[
            'fecha_documento.required' => 'Debe ingresar fecha de documento',
            'documento.required' => 'Debe ingresar documento',
            'usuario.not_in' => 'Debe seleccionar usuario',
            'descripcion.required' => 'Debe ingresar descripciion',
            'cantidad.required' => 'Debe ingresar cantidad',
            'proveedor.required' => 'Debe ingresar proveedor',
            'estado_r.not_in' => 'Debe seleccionar status',
        ]);

        $valida = Reproceso::where('fecha_documento', $request->fecha_documento)
                    ->where('estado', 1)
                    ->where('documento', $request->documento)
                    ->where('usuario', $request->usuario)
                    ->where('descripcion', $request->descripcion)
                    ->where('cantidad', $request->cantidad)
                    ->where('proveedor', $request->proveedor)
                    ->where('estado_r', $request->estado_r)
                    ->exists();

        if($valida){
            echo "error";
        }else{
            $dato['fecha_documento']= $request->input("fecha_documento"); 
            $dato['documento']= $request->input("documento");
            $dato['usuario']=  $request->input("usuario"); 
            $dato['descripcion']=  $request->input("descripcion"); 
            $dato['cantidad']=  $request->input("cantidad"); 
            $dato['proveedor']=  $request->input("proveedor"); 
            $dato['estado_r']=  $request->input("estado_r"); 
            $dato['estado'] = 1;
            $dato['fec_reg'] = now();
            $dato['user_reg'] = session('usuario')->id_usuario;
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Reproceso::create($dato);
        }
    }

    public function Modal_Update_Reproceso($id){
        $dato['get_id'] = Reproceso::where('id', $id)
                        ->get();
        
        $dato['list_usuario'] = UsuarioReproceso::get();
        return view('logistica/Reproceso/modal_editar', $dato);   
    }

    public function Update_Reproceso(Request $request){
        $request->validate([
            'usuarioe' => 'not_in:0',
            'fecha_documentoe' => 'required',
            'documentoe' => 'required',
            'descripcione' => 'required',
            'cantidade' => 'required',
            'proveedore' => 'required',
            'estado_re' => 'not_in:0',
        ],[
            'fecha_documentoe.required' => 'Debe ingresar fecha de documento',
            'documentoe.required' => 'Debe ingresar documento',
            'usuarioe.not_in' => 'Debe seleccionar usuario',
            'descripcione.required' => 'Debe ingresar descripciion',
            'cantidade.required' => 'Debe ingresar cantidad',
            'proveedore.required' => 'Debe ingresar proveedor',
            'estado_re.not_in' => 'Debe seleccionar status',
        ]);

        $valida = Reproceso::where('fecha_documento', $request->fecha_documento)
                    ->where('estado', 1)
                    ->where('documento', $request->documento)
                    ->where('usuario', $request->usuario)
                    ->where('descripcion', $request->descripcion)
                    ->where('cantidad', $request->cantidad)
                    ->where('proveedor', $request->proveedor)
                    ->where('estado_r', $request->estado_r)
                    ->exists();

        if($valida){
            echo "error";
        }else{
            $id = $request->input("id"); 
            $dato['fecha_documento'] = $request->input("fecha_documentoe"); 
            $dato['documento'] = $request->input("documentoe");
            $dato['usuario'] =  $request->input("usuarioe"); 
            $dato['descripcion'] =  $request->input("descripcione"); 
            $dato['cantidad'] =  $request->input("cantidade"); 
            $dato['proveedor'] =  $request->input("proveedore"); 
            $dato['estado_r'] =  $request->input("estado_re"); 
            $dato['fec_act'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            Reproceso::findOrFail($id)->update($dato);
        }
    }

    public function Modal_Ver_Reproceso($id){
        $dato['get_id'] = Reproceso::where('id', $id)
                        ->get();
        
        $dato['list_usuario'] = UsuarioReproceso::get();
        return view('logistica/Reproceso/modal_ver', $dato);   
    }

    public function Delete_Reproceso(Request $request){ 
        $id = $request->input("id");
        $dato = [
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario,
        ];
        Reproceso::findOrFail($id)->update($dato);
    }

    public function Excel_Reproceso(){
        $list_reproceso = Reproceso::get_list_reproceso();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Reproceso');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(15); 
        $sheet->getColumnDimension('E')->setWidth(70);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(50); 
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

        $sheet->setCellValue("A1", 'Mes');     
        $sheet->setCellValue("B1", 'Fecha documento');           
        $sheet->setCellValue("C1", 'Documento');             
        $sheet->setCellValue("D1", 'Usuario');             
        $sheet->setCellValue("E1", 'Descripción');             
        $sheet->setCellValue("F1", 'Cantidad');  
        $sheet->setCellValue("G1", 'Proveedor');
        $sheet->setCellValue("H1", 'Status');       

        $contador=1;
        
        foreach($list_reproceso as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['mes']);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list['fecha_documento']));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY); 
            $sheet->setCellValue("C{$contador}", $list['documento']);
            $sheet->setCellValue("D{$contador}", $list['usuario']);
            $sheet->setCellValue("E{$contador}", $list['descripcion']);
            $sheet->setCellValue("F{$contador}", $list['cantidad']);
            $sheet->setCellValue("G{$contador}", $list['proveedor']);
            $sheet->setCellValue("H{$contador}", $list['status']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Reproceso';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
}
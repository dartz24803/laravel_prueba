<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\CalendarioLogistico;
use App\Models\ProveedorGeneral;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReporteProveedoresController extends Controller{
    protected $request;
    
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function RProveedores(){
        $id_puesto=session('usuario')->id_puesto;
        $id_nivel=session('usuario')->id_nivel;
        $dato['desde']=date('Y-m-d');
        $dato['hasta']=date('Y-m-d');
        
        $dato['estado']=3;
        if($id_puesto==23 || $id_nivel==1 || $id_puesto==24){
            $dato['base']=0;
            if($id_puesto==24){
                $dato['list_base'] = Base::where('estado', 1)
                                    ->whereIn('id_base', [15,19,34])
                                    ->groupBy('cod_base')
                                    ->orderBy('cod_base', 'ASC')
                                    ->get();
                
            }else{
                $dato['list_base'] = Base::select('cod_base')
                                    ->where('estado', 1)
                                    ->groupBy('cod_base')
                                    ->orderBy('cod_base', 'ASC')
                                    ->get();
            }
            $dato['list_rproveedor'] = CalendarioLogistico::get_list_rproveedor($dato);
            
        }elseif($id_puesto==36){
            
            $dato['base']=session('usuario')->centro_labores;

            $dato['list_rproveedor'] = CalendarioLogistico::get_list_rproveedor($dato);
        }
        //NOTIFICACIÓN-NO BORRAR
        /*
        $dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
        $dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();*/
        return view('seguridad.reporte_proveedores.index',$dato);
    }

    public function Actualizar_Hora_RProveedor(Request $request){
        $dato['id_calendario']= $request->input("id_calendario");
        $id_calendario= $request->input("id_calendario");
        $dato['tipo']= $request->input("tipo");
        $dato['get_id'] = CalendarioLogistico::where('id_calendario', $id_calendario);

        CalendarioLogistico::findOrFail($request->id_calendario)->update([
            'flag' => 1,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
        ]);
        
        $hora=date('H:i:s');

        if($dato['tipo']==1){
            CalendarioLogistico::findOrFail($request->id_calendario)->update([
                'hora_real_llegada' => $hora,
                'fec_real_llegada' => now(),
                'estado_reporte' => 1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }if($dato['tipo']==2){
            CalendarioLogistico::findOrFail($request->id_calendario)->update([
                'hora_ingreso_insta' => $hora,
                'fec_ingreso_instalaciones' => now(),
                'estado_reporte' => 2,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }if($dato['tipo']==3){
            CalendarioLogistico::findOrFail($request->id_calendario)->update([
                'hora_descargo_merca' => $hora,
                'fec_descarga_merca' => now(),
                'estado_reporte' => 3,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }if($dato['tipo']==4){
            CalendarioLogistico::findOrFail($request->id_calendario)->update([
                'hora_salida' => $hora,
                'fec_hora_salida' => now(),
                'estado_reporte' => 4,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }
    }

    public function Buscar_RProveedor(Request $request){
        $id_puesto=session('usuario')->id_puesto;
        $id_nivel=session('usuario')->id_nivel;
        $dato['desde']=date('Y-m-d');
        $dato['hasta']=date('Y-m-d');
        $dato['base'] = $request->base;
        $dato['desde'] = $request->fecha_inicio;
        $dato['hasta'] = $request->fecha_fin;
        $dato['estado']=3;
        if($id_puesto==23 || $id_nivel==1 || $id_puesto==24){
            if($id_puesto==24){
                $dato['list_base'] = Base::where('estado', 1)
                                    ->whereIn('id_base', [15,19,34])
                                    ->groupBy('cod_base')
                                    ->orderBy('cod_base', 'ASC')
                                    ->get();
                
            }else{
                $dato['list_base'] = Base::select('cod_base')
                                    ->where('estado', 1)
                                    ->groupBy('cod_base')
                                    ->orderBy('cod_base', 'ASC')
                                    ->get();
            }
            $dato['list_rproveedor'] = CalendarioLogistico::get_list_rproveedor($dato);
            
        }elseif($id_puesto==36){
            $dato['list_rproveedor'] = CalendarioLogistico::get_list_rproveedor($dato);
        }

        $dato['list_proveedor'] = DB::connection('sqlsrv')
                                ->table('tge_entidades')
                                ->where('clp_tipenti', 'PR')
                                ->where('clp_estado', '<>', '*')
                                ->get()
                                ->toArray();
        $dato['list_proveedor2'] = ProveedorGeneral::where('estado', 1)
                                ->whereIn('id_proveedor_mae', [1,2])
                                ->get()
                                ->toArray();
        //NOTIFICACIÓN-NO BORRAR
        /*
        $dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
        $dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();*/
        return view('seguridad.reporte_proveedores.lista_rproveedor',$dato);
    }

    public function Excel_RProveedor($base,$estado_interno,$fecha_inicio,$fecha_fin){
        $dato['desde']=$fecha_inicio;
        $dato['hasta']=$fecha_fin;
        $dato['base']=$base;
        $dato['estado']=$estado_interno;
        $data = CalendarioLogistico::get_list_rproveedor($dato);
        $list_proveedor = DB::connection('sqlsrv')
                                ->table('tge_entidades')
                                ->where('clp_tipenti', 'PR')
                                ->where('clp_estado', '<>', '*')
                                ->get()
                                ->toArray();
        $list_proveedor2 = ProveedorGeneral::where('estado', 1)
                                ->whereIn('id_proveedor_mae', [1,2])
                                ->get()
                                ->toArray();
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Reporte Proveedores');

        $sheet->setCellValue('A1', 'Base');
        $sheet->setCellValue('B1', 'Proveedor');
		$sheet->setCellValue('C1', 'Usuario Registro');
		$sheet->setCellValue('D1', 'Fecha Registro');
        $sheet->setCellValue('E1', 'Hora Programada');
        $sheet->setCellValue('F1', 'H. Real Llegada');
        $sheet->setCellValue('G1', 'H. Ingreso a Instalaciones');
        $sheet->setCellValue('H1', 'H. Descarga de Mercadería');
        $sheet->setCellValue('I1', 'H. de Salida');
        $sheet->setCellValue('J1', 'Estado');

        $spreadsheet->getActiveSheet()->setAutoFilter('A1:J1');  
        $sheet->getStyle('A1:J1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //Le aplicamos color a la cabecera
        $spreadsheet->getActiveSheet()->getStyle("A1:J1")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');
        //border
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        //fONT SIZE
		$sheet->getStyle("A1:J1")->getFont()->setSize(12);

        //Font BOLD
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);		
        
		$start = 1;
		foreach($data as $d){
            $start = $start+1;

            $sheet->getStyle("A{$start}:J{$start}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$start}:J{$start}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$start}:J{$start}")->getAlignment()->setWrapText(true);

            $spreadsheet->getActiveSheet()->setCellValue("A{$start}", $d['base']);

            $proveedorf="";

            if($d['infosap']==1){
                $busqueda = in_array($d['id_proveedor'], array_column($list_proveedor, 'clp_codigo'));
                $posicion = array_search($d['id_proveedor'], array_column($list_proveedor, 'clp_codigo'));
                if ($busqueda != false) {
                    $proveedorf=$list_proveedor[$posicion]->clp_razsoc;
                } 
            }else{
                $busqueda = in_array($d['id_proveedor'], array_column($list_proveedor2, 'id_proveedor'));
                $posicion = array_search($d['id_proveedor'], array_column($list_proveedor2, 'id_proveedor'));
                if ($busqueda != false) {
                    $proveedorf=$list_proveedor2[$posicion]['nombre_proveedor'];
                }
            }

            if ($busqueda != false) {
                //$spreadsheet->getActiveSheet()->setCellValue("B{$start}", $list_proveedor[$posicion]['clp_razsoc']);
                $spreadsheet->getActiveSheet()->setCellValue("B{$start}", $proveedorf);
            }
            $spreadsheet->getActiveSheet()->setCellValue("C{$start}", $d['usuario_apater']." ".$d['usuario_amater'].", ".$d['usuario_nombres']);
            $spreadsheet->getActiveSheet()->setCellValue("D{$start}", $d['fecha_registro_excel']);
            $spreadsheet->getActiveSheet()->setCellValue("E{$start}", $d['hora_programada']);
            if($d['hora_real_llegada']!="00:00:00"){
                $spreadsheet->getActiveSheet()->setCellValue("F{$start}", $d['fecha_real_llegada']);
            }if($d['hora_ingreso_insta']!="00:00:00"){
                $spreadsheet->getActiveSheet()->setCellValue("G{$start}", $d['fecha_ingreso_insta']);
            }if($d['hora_descargo_merca']!="00:00:00"){
                $spreadsheet->getActiveSheet()->setCellValue("H{$start}", $d['fecha_descarga_merca']);
            }if($d['hora_salida']!="00:00:00"){
                $spreadsheet->getActiveSheet()->setCellValue("I{$start}", $d['fecha_salida']);
            }
            if($d['estado_interno']==1){
                $spreadsheet->getActiveSheet()->setCellValue("J{$start}", "PROGRAMADO");
            }elseif($d['estado_interno']==2){
                $spreadsheet->getActiveSheet()->setCellValue("J{$start}", "NO PROGRAMADO");
            }
            //$spreadsheet->getActiveSheet()->setCellValue("F{$start}", date_format(date_create($d['fec_solicitud']), "d/m/Y"));

		}

		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(35);
		$sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('j')->setWidth(20);
        
        //final part
		$curdate = $fecha_inicio;
		$writer = new Xlsx($spreadsheet);
		$filename = 'Reporte_Proveedores_'.$curdate;
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }
}
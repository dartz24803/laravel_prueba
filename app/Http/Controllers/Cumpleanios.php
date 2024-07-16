<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\Mes;
use App\Models\Usuario;

class Cumpleanios extends Controller
{
    //cumpleanios
    public function index(){
        $get_foto = Config::where('descrip_config', 'Foto_Colaborador')
                            ->where('estado', 1)
                            ->get();
        $list_mes = Mes::where('estado', 1)
                            ->get();
        return view('rrhh.Cumpleanio.index',compact('get_foto', 'list_mes'));
    }
    
    public function Buscar_Cumpleanios(Request $request){
        $dato['cod_mes']= $request->input("cod_mes");
        $list_cumple = Usuario::get_list_proximos_cumpleanios_admin($dato);
        return view('rrhh.Cumpleanio.busqueda_cumple', compact('list_cumple'));
    }
    
    public function Modal_Lista_Saludo_Cumpleanio($id_usuario){
        $dato['id_usuario']=$id_usuario;
        $get_id = Usuario::get_list_usuario($id_usuario);
        $list_cumpleanio = Usuario::get_list_saludo_cumpleanios($id_usuario);

        return view('rrhh.Cumpleanio.modal_list_saludo', compact('get_id', 'list_cumpleanio'));
    }
    /*
    public function Aprobar_Saludo_Cumpleanio(){
        if ($this->session->userdata('usuario')) {
            $dato['id_historial']= $this->input->post("id_historial");
            $dato['estado_registro']= $this->input->post("estado_registro");
            $this->Model_Corporacion->aprobar_saludo_cumpleanio($dato); 
        }
        else{
            redirect('');
        }
    }

    public function List_Saludo_cumpleanio($id_usuario){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario']=$id_usuario;
            $dato['list_cumpleanio'] = $this->Model_Corporacion->get_list_saludo_cumpleanios($id_usuario);

            $this->load->view('Recursos_Humanos/Cumpleanio/list_saludo',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Excel_Saludo_Cumpleanio($id_usuario){
        
        if ($this->session->userdata('usuario')) {
            $data = $this->Model_Corporacion->get_list_saludo_cumpleanios($id_usuario);
            // Create new Spreadsheet object
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getActiveSheet()->setTitle('Lista de Saludos');
            $sheet->setCellValue('A1', 'FECHA DE REGISTRO');
            $sheet->setCellValue('B1', 'CUMPLEAÑOS');
            $sheet->setCellValue('C1', 'CUMPLEAÑERO');
            $sheet->setCellValue('D1', 'SALUDADO POR');
            $sheet->setCellValue('E1', 'SALUDO');
            $sheet->setCellValue('F1', 'ESTADO');
            //border
            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            //Font BOLD
            //$sheet->getStyle("A1:G1")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A1:F1")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle('A1:F1')->getFont()->setBold(true);
            //$slno = 1;
            $start = 1;
            foreach($data as $d){
                $start = $start+1;          
                
                $spreadsheet->getActiveSheet()->setCellValue("A{$start}", date('d/m/Y',strtotime($d['fec_reg'])));
                $spreadsheet->getActiveSheet()->setCellValue("B{$start}", date('d/m/Y',strtotime($d['cumpleanio'])));
                $spreadsheet->getActiveSheet()->setCellValue("C{$start}", $d['usuario_nombres']." ".$d['usuario_apater']." ".$d['usuario_amater']);
                $spreadsheet->getActiveSheet()->setCellValue("D{$start}", $d['saludado_por']);
                $spreadsheet->getActiveSheet()->setCellValue("E{$start}", $d['mensaje']);
                $spreadsheet->getActiveSheet()->setCellValue("F{$start}", $d['desc_estado_registro']);

                $sheet->getStyle("A{$start}:F{$start}")->applyFromArray($styleThinBlackBorderOutline);
            }
            //Custom width for Individual Columns
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(50);
            $sheet->getColumnDimension('F')->setWidth(25);
            //$sheet->getColumnDimension('C')->setWidth(55);
            //$sheet->getColumnDimension('C')->setWidth(55);
            //final part
            $curdate = date('d-m-Y');
           // $writer = new Xlsx($spreadsheet);
            $filename = 'Lista de Saludos '.$curdate;
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
        
            $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
            $writer->save('php://output');

        }else{
            redirect('');
        }
    }

    public function Imprimir_Saludo($id_usuario){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_usuario($id_usuario);
            $dato['list_cumpleanio'] = $this->Model_Corporacion->get_list_saludo_cumpleanios_aprobados($id_usuario);
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => "A4",
                'margin_top' => 25,
                'margin_bottom' => 20,
                'collapseBlockMargins' => false,
                'default_font' => 'gothic',
            ]);
            $html = $this->load->view('Recursos_Humanos/Cumpleanio/saludos_pdf',$dato,true);
            $footer = "";
            
            $mpdf->SetFooter($footer,'O', '', '', true);
            
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }
        else{
            redirect('');
        }
    }
        */
}

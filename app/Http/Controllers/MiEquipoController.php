<?php

namespace App\Http\Controllers;

use App\Models\AsignacionJefatura;
use App\Models\Base;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MiEquipoController extends Controller
{
    protected $input;
    protected $Model_Asignacion;
    // protected $Model_Permiso;
    // protected $Model_Perfil;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Asignacion = new AsignacionJefatura();
        // $this->Model_Permiso = new PermisoPapeletasSalida();
        // $this->Model_Perfil = new Model_Perfil();
    }
    public function ListaMiequipo() {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
            return view('rrhh.Mi_equipo.index', compact('list_subgerencia', 'list_notificacion'));
    }

    public function Cargar_Mi_Equipo(){ 
            $dato['lista_bases'] = Base::select('cod_base')
                        ->where('estado', '1')
                        ->distinct()
                        ->orderBy('cod_base', 'asc')
                        ->get();
            return view('rrhh.Mi_equipo.mi_equipo',$dato);
    }

    public function Cargar_Bases_Equipo($busq_base){ 
            $centro_labores = session('usuario')->centro_labores;
            $id_puesto = session('usuario')->id_puesto;

            $dato['list_ajefatura'] = $this->Model_Asignacion->get_list_ajefatura_puesto($id_puesto);

            $result="";

            foreach($dato['list_ajefatura'] as $char){
                $result.= $char['id_puesto_permitido'].",";
            }

            $cadena = substr($result, 0, -1);

            $dato['cadena'] = "(".$cadena.")";

            $data['base']=$busq_base;
            $dato['colaborador_porcentaje'] = Usuario::colaborador_porcentaje(0,$centro_labores,$dato,$data);

            
            return view('rrhh.Mi_equipo.lista_equipo',$dato);
    }
    
    public function Excel_Mi_Equipo($base){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Mi Equipo');
        $sheet->setCellValue('A1', 'ESTADO');
        $sheet->setCellValue('B1', 'FECHA DE INGRESO');
        $sheet->setCellValue('C1', 'CENTRO DE LABORES');
        $sheet->setCellValue('D1', 'APELLIDO PATERNO');
        $sheet->setCellValue('E1', 'APELLIDO MATERNO');
        $sheet->setCellValue('F1', 'NOMBRES');

        $sheet->setCellValue('G1', 'CARGO');
        $sheet->setCellValue('H1', 'TIPO DOCUMENTO');
        $sheet->setCellValue('I1', 'NUM. DOCUMENTO');
        $sheet->setCellValue('J1', 'FECHA DE NACIMIENTO');
        $sheet->setCellValue('K1', 'CORREO ELECTRÓNICO');
        $sheet->setCellValue('L1', 'TELÉFONO CELULAR');

        $sheet->setCellValue('M1', 'DOMICILIO ACTUAL');
        
        $sheet->setCellValue('N1', 'DISTRITO');
        $sheet->setCellValue('O1', 'PROVINCIA');
        $sheet->setCellValue('P1', 'DEPARTAMENTO');
        $sheet->setCellValue('Q1', 'ANTIGUEDAD EN AÑOS');
        $sheet->setCellValue('R1', 'ANTIGUEDAD EN MESES');
        $sheet->setCellValue('S1', 'SITUACIÓN LABORAL');
        $sheet->setCellValue('T1', 'GENERACIÓN');
        
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:T1');  
        //Le aplicamos color a la cabecera
        $spreadsheet->getActiveSheet()->getStyle("A1:T1")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('657099');

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
		$sheet->getStyle('A1:T1')->getFont()->setBold(true);		
		
        $centro_labores = session('usuario')->centro_labores;
        $id_puesto = session('usuario')->id_puesto;
		
        $dato['list_ajefatura'] = $this->Model_Asignacion->get_list_ajefatura_puesto($id_puesto);

        $result="";

        foreach($dato['list_ajefatura'] as $char){
            $result.= $char['id_puesto_permitido'].",";
        }

        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(".$cadena.")";
		$parametro['base']=$base;
		$data = Usuario::colaborador_porcentaje(0,$centro_labores,$dato,$parametro);
		//$slno = 1;
		$start = 1;
		foreach($data as $d){
            $start = $start+1;

            $spreadsheet->getActiveSheet()->setCellValue("A{$start}", $d['nom_estado_usuario']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$start}", $d['ini_funciones']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$start}", $d['centro_labores']);
            $spreadsheet->getActiveSheet()->setCellValue("D{$start}", $d['usuario_apater']);
            $spreadsheet->getActiveSheet()->setCellValue("E{$start}", $d['usuario_amater']);
            $spreadsheet->getActiveSheet()->setCellValue("F{$start}", $d['usuario_nombres']);

            $spreadsheet->getActiveSheet()->setCellValue("G{$start}", $d['nom_cargo']);
            $spreadsheet->getActiveSheet()->setCellValue("H{$start}", $d['cod_tipo_documento']);
            $spreadsheet->getActiveSheet()->setCellValue("I{$start}", $d['num_doc']);
            $spreadsheet->getActiveSheet()->setCellValue("J{$start}", $d['fec_nac']);
            $spreadsheet->getActiveSheet()->setCellValue("K{$start}", $d['usuario_email']);                
            $spreadsheet->getActiveSheet()->setCellValue("L{$start}", $d['num_celp']);

            $spreadsheet->getActiveSheet()->setCellValue("M{$start}", $d['nom_via'].' '.$d['num_via']);

            $spreadsheet->getActiveSheet()->setCellValue("N{$start}", $d['nombre_distrito']);
            $spreadsheet->getActiveSheet()->setCellValue("O{$start}", $d['nombre_provincia']);
            $spreadsheet->getActiveSheet()->setCellValue("P{$start}", $d['nombre_departamento']);
            $diferencia = date_diff(date_create($d['ini_funciones']),date_create(date('d-m-Y')));
            $anio= $diferencia->y;
            $mes= $diferencia->m;
            
            if($d['ini_funciones']==null){
                $spreadsheet->getActiveSheet()->setCellValue("Q{$start}", $d['ini_funciones']);    
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("Q{$start}", $anio);    
            }
            if($d['ini_funciones']==null){
                $spreadsheet->getActiveSheet()->setCellValue("R{$start}", $d['ini_funciones']);     
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("R{$start}", $mes);    
            }
            
            $spreadsheet->getActiveSheet()->setCellValue("S{$start}", $d['nom_situacion_laboral']);
            $spreadsheet->getActiveSheet()->setCellValue("T{$start}", $d['generacion']);
            
            //border
            $sheet->getStyle("A{$start}:S{$start}")->applyFromArray($styleThinBlackBorderOutline);

		}
		//Alignment
		//fONT SIZE
		$sheet->getStyle("A{$start}:T{$start}")->getFont()->setSize(12);
		$sheet->getStyle('A1:T1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		//Custom width for Individual Columns
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(35);
        $sheet->getColumnDimension('J')->setWidth(35);
        $sheet->getColumnDimension('K')->setWidth(35);
        $sheet->getColumnDimension('L')->setWidth(35);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(35);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(25);
        
        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Lista_Miequipo_'.$curdate;
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');    
    }
}

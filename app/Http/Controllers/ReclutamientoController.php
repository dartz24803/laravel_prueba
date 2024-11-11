<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Base;
use App\Models\ModalidadLaboral;
use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\Puesto;
use App\Models\Reclutamiento;
use App\Models\ReclutamientoDetalle;
use App\Models\ReclutamientoReclutado;
use App\Models\SubGerencia;
use App\Models\Ubicacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReclutamientoController extends Controller
{
    protected $input;
    protected $modelo;
    protected $modelo_puestos;
    protected $modelo_users;
    protected $Model_Perfil;
    protected $modelo_detalles;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->input = $request;
        $this->modelo = new Reclutamiento();
        $this->modelo_puestos = new Puesto();
        $this->modelo_users = new Usuario();
        $this->Model_Perfil = new Model_Perfil();
        $this->modelo_detalles = new ReclutamientoDetalle();
    }

    public function Reclutamiento(){
            $dato['id_usuario'] = session('usuario')->id_usuario;
            $dato['list_reclutamiento_asig'] = $this->modelo->get_list_reclutamiento_asig();

            $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
            //NOTIFICACIONES
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('rrhh.Reclutamiento.index', $dato);
    }

    public function Buscador_Reclutamiento(){
            $id_usuario=$this->input->post("id_usuario");
            $dato['pestania']=$this->input->post("pestania");
            $dato['list_reclutamiento'] = $this->modelo->get_list_reclutamiento($id_reclutamiento=null,$id_usuario,$dato['pestania']);
            return view('rrhh.Reclutamiento.lista_reclutamiento', $dato);
    }

    public function Modal_Reclutamiento() {
        $dato['id_nivel'] = session('usuario')->id_nivel;
        $dato['id_puesto'] = session('usuario')->id_puesto;
        if($dato['id_nivel']==1 || $dato['id_nivel']==2 || $dato['id_puesto']==21 || $dato['id_puesto']==279){
            $dato['list_area'] = $this->Model_Perfil->get_list_area();
            $dato['puestos_jefes'] = $this->modelo_puestos->list_puestos_jefes();
            $dato['list_responsables'] = $this->modelo_users->list_usuarios_responsables($dato);
            $dato['list_rrhh'] = Usuario::select('id_usuario', 'usuario_nombres', 'usuario_apater', 'usuario_amater')
                            ->whereIn('id_puesto', [21, 277, 278])
                            ->where('estado', 1)
                            ->get();
        }else{
            $dato['id_gerencia'] = session('usuario')->id_gerencia;
            $dato['list_area'] = $this->Model_Perfil->get_list_area($dato['id_gerencia'], $id_area=null);
            $dato['id_area'] = session('usuario')->id_area;
        }
        $dato['list_colaborador'] = $this->modelo_users->get_list_colaborador();
        $dato['list_base'] = Base::get_list_todas_bases_agrupadas();
        $dato['list_ubicacion'] = Ubicacion::where('estado', 1)
                        ->orderBy('cod_ubi', 'ASC')
                        ->get();
        $dato['list_modalidad_laboral'] = ModalidadLaboral::where('estado', 1)
                                    ->get();
        return view('rrhh.Reclutamiento.modal_reg',$dato);
    }

    public function Buscar_Puesto_Area($id_area,$t) {
        $dato['list_puesto'] = $this->modelo_puestos->where('id_area', $id_area)
                            ->where('estado', 1)
                            ->get();
        $dato['t']=$t;
        return view('rrhh.Reclutamiento.cmb_puesto',$dato);
    }

    public function Insert_Reclutamiento(){
        $this->input->validate([
            'id_area' => 'not_in:0',
            'id_puesto' => 'not_in:0',
            'id_solicitante' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'id_evaluador' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'vacantes' => 'required',
            'id_ubicacion' => 'not_in:0',
            'id_modalidad_laboral' => 'not_in:0',
            'tipo_sueldo' => 'not_in:0',
            'sueldo' => 'required_if:tipo_sueldo,1',
            'desde' => 'required_if:tipo_sueldo,2',
            'a' => 'required_if:tipo_sueldo,2',
            'id_asignado' => 'not_in:0',
            'prioridad' => 'not_in:0',
            'fec_cierre' => 'required',
        ], [
            'id_area' => 'Debe seleccionar Área.',
            'id_puesto' => 'Debe seleccionar Puesto.',
            'id_solicitante' => 'Debe seleccionar Solicitante.',
            'id_evaluador' => 'Debe seleccionar Evaluador.',
            'vacantes' => 'Debe ingresar vacantes.',
            'id_ubicacion' => 'Debe seleccionar Centro de Labores.',
            'id_modalidad_laboral' => 'Debe seleccionar modalidad',
            'tipo_sueldo' => 'Debe seleccionar tipo de remuneración.',
            'sueldo' => 'Debe ingresar sueldo.',
            'desde' => 'Debe ingresar Desde.',
            'a' => 'Debe ingresar A.',
            'id_asignado' => 'Debe seleccionar Asignado a',
            'prioridad' => 'Debe seleccionar Prioridad.',
            'fec_cierre' => 'Debe ingresar Fecha de Cierre.',
        ]);
            $dato['id_area']= $this->input->post("id_area");
            $dato['id_puesto']= $this->input->post("id_puesto");
            $dato['id_solicitante']= $this->input->post("id_solicitante");
            $dato['id_evaluador']= $this->input->post("id_evaluador");
            $dato['vacantes']= $this->input->post("vacantes");
            $dato['id_ubicacion']= $this->input->post("id_ubicacion");
            $dato['id_modalidad_laboral']= $this->input->post("id_modalidad_laboral");
            $dato['tipo_sueldo']= $this->input->post("tipo_sueldo");
            $dato['sueldo']= $this->input->post("sueldo")?: '0.00';
            $dato['desde']= $this->input->post("desde")?: '0.00';
            $dato['a']= $this->input->post("a")?: '0.00';
            $dato['id_asignado']= $this->input->post("id_asignado");
            $dato['prioridad']= $this->input->post("prioridad");
            $dato['fec_cierre']= $this->input->post("fec_cierre");
            $dato['observacion']= $this->input->post("observacion");
            $dato['mod']=1;
                $anio=date('Y');
                $totalRows_t = Reclutamiento::count();
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigofinal="PR".$aniof."0000".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                        $codigofinal="PR".$aniof."000".($totalRows_t+1);
                }
                if($totalRows_t>98 && $totalRows_t<999){
                    $codigofinal="PR".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>998 && $totalRows_t<9999){
                    $codigofinal="PR".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>9998){
                    $codigofinal="PR".$aniof.($totalRows_t+1);
                }
                $dato['cod_reclutamiento']=$codigofinal;

                Reclutamiento::create([
                    'cod_reclutamiento' => $dato['cod_reclutamiento'],
                    'id_area' => $dato['id_area'],
                    'id_puesto' => $dato['id_puesto'],
                    'id_solicitante' => $dato['id_solicitante'],
                    'id_evaluador' => $dato['id_evaluador'],
                    'vacantes' => $dato['vacantes'],
                    'id_ubicacion' => $dato['id_ubicacion'],
                    'id_modalidad_laboral' => $dato['id_modalidad_laboral'],
                    'tipo_sueldo' => $dato['tipo_sueldo'],
                    'sueldo' => $dato['sueldo'],
                    'desde' => $dato['desde'],
                    'a' => $dato['a'],
                    'id_asignado' => $dato['id_asignado'],
                    'prioridad' => $dato['prioridad'],
                    'fec_cierre' => $dato['fec_cierre'],
                    'observacion' => $dato['observacion'],
                    'estado_reclutamiento' => 1,
                    'estado' => 1,
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_reg' => now(),
                    'user_act' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                ]);
    }

    public function Modal_Update_Reclutamiento($id_reclutamiento) {
        $dato['get_id'] = $this->modelo->get_list_reclutamiento($id_reclutamiento,0,0);
        $dato['list_detalle_reclutamiento'] = $this->modelo_detalles->get_list_detalle_reclutamiento($id_reclutamiento);
        $dato['id_nivel'] = session('usuario')->id_nivel;
        $dato['id_puesto'] = session('usuario')->id_puesto;
        if($dato['id_nivel']==1 || $dato['id_nivel']==2 || $dato['id_puesto']==21 || $dato['id_puesto']==279){
            $dato['list_area'] = $this->Model_Perfil->get_list_area();
            $dato['puestos_jefes'] = $this->modelo_puestos->list_puestos_jefes();
            $dato['list_responsables'] = $this->modelo_users->list_usuarios_responsables($dato);
            $dato['list_rrhh'] = Usuario::select('id_usuario', 'usuario_nombres', 'usuario_apater', 'usuario_amater')
                            ->whereIn('id_puesto', [21, 277, 278])
                            ->where('estado', 1)
                            ->get();
        }else{
            $dato['id_gerencia'] = session('usuario')->id_gerencia;
            $dato['list_area'] = $this->Model_Perfil->get_list_area($dato['id_gerencia'], $id_area=null);
            $dato['id_area'] = session('usuario')->id_area;
        }
        $dato['list_colaborador'] = $this->modelo_users->get_list_colaborador();
        $dato['list_puesto'] = Puesto::where('id_area', $dato['get_id'][0]['id_area'])
                            ->where('estado', 1)
                            ->get();

        $dato['list_ubicacion'] = Ubicacion::where('estado', 1)
                            ->orderBy('cod_ubi', 'ASC')
                            ->get();
        $dato['list_base'] = Base::get_list_todas_bases_agrupadas();
        $dato['list_modalidad_laboral'] = ModalidadLaboral::where('estado', 1)
                            ->get();

        return view('rrhh.Reclutamiento.modal_upd',$dato);
    }

    public function Delete_Reclutamiento_Detalle(){
            $dato['id_reclutamiento']= $this->input->post("id_reclutamiento");

            Reclutamiento::where('id_reclutamiento', $dato['id_reclutamiento'])
                            ->update([
                                'estado' => 2,
                                'fec_eli' => now(),
                                'user_eli' => session('usuario')->id_usuario,
                            ]);

            ReclutamientoReclutado::where('id_reclutamiento', $dato['id_reclutamiento'])
                            ->update([
                                'estado' => 2,
                                'fec_eli' => now(),
                                'user_eli' => session('usuario')->id_usuario,
                            ]);
    }

    public function Delete_Reclutado(){
            $id_detalle= $this->input->post("id_detalle");
            ReclutamientoReclutado::where('id_detalle', $id_detalle)
                            ->update([
                                'estado' => 2,
                                'fec_eli' => now(),
                                'user_eli' => session('usuario')->id_usuario,
                            ]);
    }

    public function Update_Reclutamiento(){
        $this->input->validate([
            'id_areae' => 'not_in:0',
            'id_puestoe' => 'not_in:0',
            'id_solicitantee' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'id_evaluadore' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'vacantese' => 'required',
            'id_ubicacione' => 'not_in:0',
            'id_modalidad_laborale' => 'not_in:0',
            'tipo_sueldoe' => 'not_in:0',
            'sueldoe' => 'required_if:tipo_sueldo,1',
            'desdee' => 'required_if:tipo_sueldo,2',
            'ae' => 'required_if:tipo_sueldo,2',
            'id_asignadoe' => 'not_in:0',
            'prioridade' => 'not_in:0',
        ], [
            'id_area' => 'Debe seleccionar Área.',
            'id_puesto' => 'Debe seleccionar Puesto.',
            'id_solicitante' => 'Debe seleccionar Solicitante.',
            'id_evaluador' => 'Debe seleccionar Evaluador.',
            'vacantes' => 'Debe ingresar vacantes.',
            'id_ubicacione' => 'Debe seleccionar Centro de Labores.',
            'id_modalidad_laboral' => 'Debe seleccionar modalidad',
            'tipo_sueldo' => 'Debe seleccionar tipo de remuneración.',
            'sueldo' => 'Debe ingresar sueldo.',
            'desde' => 'Debe ingresar Desde.',
            'a' => 'Debe ingresar A.',
            'id_asignado' => 'Debe seleccionar Asignado a',
            'prioridad' => 'Debe seleccionar Prioridad.',
        ]);
            $dato['id_reclutamiento']= $this->input->post("id_reclutamiento");
            $dato['id_evaluador']= $this->input->post("id_evaluadore");
            $dato['id_modalidad_laboral']= $this->input->post("id_modalidad_laborale");
            $dato['tipo_sueldo']= $this->input->post("tipo_sueldoe");
            $dato['sueldo']= $this->input->post("sueldoe");
            $dato['desde']= $this->input->post("desdee");
            $dato['a']= $this->input->post("ae");
            $dato['id_asignado']= $this->input->post("id_asignadoe");
            $dato['observacion']= $this->input->post("observacione");
            $dato['estado_reclutamiento']= $this->input->post("estado_reclutamientoe");
            $dato['fec_termino']= $this->input->post("fec_terminoe");
            $dato['vacantes']= $this->input->post("vacantese");
            $dato['id_ubicacion']= $this->input->post("id_ubicacione");

            $id_usuario = session('usuario')->id_usuario;
            $dia = date('Y-m-d');
            $fecha = [];

            // Determina el valor de los campos de fecha basados en el estado de reclutamiento
            if ($dato['estado_reclutamiento'] == 2) {
                $fecha['fec_enproceso'] = $dia;
            } elseif ($dato['estado_reclutamiento'] == 3) {
                $fecha['fec_cierre_r'] = $dia;
            }

            // Realiza la actualización
            Reclutamiento::where('id_reclutamiento', $dato['id_reclutamiento'])
                ->update(array_merge([
                    'id_evaluador' => $dato['id_evaluador'],
                    'id_modalidad_laboral' => $dato['id_modalidad_laboral'],
                    'tipo_sueldo' => $dato['tipo_sueldo'],
                    'id_asignado' => $dato['id_asignado'],
                    'sueldo' => $dato['sueldo'],
                    'desde' => $dato['desde'],
                    'a' => $dato['a'],
                    'observacion' => $dato['observacion'],
                    'vacantes' => $dato['vacantes'],
                    'id_ubicacion' => $dato['id_ubicacion'],
                    'estado_reclutamiento' => $dato['estado_reclutamiento'],
                    'fec_termino' => $dato['fec_termino'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ], $fecha));
    }

    public function Excel_Reclutamiento($id_usuario,$pestania){
            $dato['pestania']=$pestania;
            $data = $this->modelo->get_list_reclutamiento($id_reclutamiento=null,$id_usuario,$dato['pestania']);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $spreadsheet->getActiveSheet()->setTitle('Lista Reclutamiento');
            $sheet->setCellValue('A1', 'F REGISTRO');
            $sheet->setCellValue('B1', 'ÁREA');
            $sheet->setCellValue('C1', 'PUESTO');
            $sheet->setCellValue('D1', 'SOLICITANTE');
            $sheet->setCellValue('E1', 'EVALUADOR');
            $sheet->setCellValue('F1', 'VACANTES');
            $sheet->setCellValue('G1', 'PENDIENTES');
            $sheet->setCellValue('H1', 'CENTRO LABORES');
            $sheet->setCellValue('I1', 'MODALIDAD');
            $sheet->setCellValue('J1', 'T REMUNERACION');
            $sheet->setCellValue('K1', 'SUELDO');
            $sheet->setCellValue('L1', 'DESDE');
            $sheet->setCellValue('M1', 'A');
            $sheet->setCellValue('N1', 'ASIGNADO A');
            $sheet->setCellValue('O1', 'PRIORIDAD');
            $sheet->setCellValue('P1', 'VENCIMIENTO');
            $sheet->setCellValue('Q1', 'OBSERVACIONES');
            $sheet->setCellValue('R1', 'ESTADO');

            $spreadsheet->getActiveSheet()->setAutoFilter('A1:R1');
            //Le aplicamos color a la cabecera
            $spreadsheet->getActiveSheet()->getStyle("A1:R1")->getFill()
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
            $sheet->getStyle('A1:R1')->getFont()->setBold(true);
            $dato['list_area'] = $this->Model_Perfil->get_list_area();
            //$slno = 1;
            $start = 1;
            $t_vacantes=0;
            $t_pendientes=0;
            foreach($data as $d){
                $start = $start+1;
                $t_vacantes=$t_vacantes+$d['vacantes'];
                $t_pendientes=$t_pendientes+($d['vacantes']-$d['reclutados']);

                $spreadsheet->getActiveSheet()->setCellValue("A{$start}", $d['fecha_registro']);
                $spreadsheet->getActiveSheet()->setCellValue("B{$start}", $d['nom_area']);
                $spreadsheet->getActiveSheet()->setCellValue("C{$start}", $d['nom_puesto']);
                $spreadsheet->getActiveSheet()->setCellValue("D{$start}", $d['solicitado']);
                $spreadsheet->getActiveSheet()->setCellValue("E{$start}", $d['evaluador']);
                $spreadsheet->getActiveSheet()->setCellValue("F{$start}", $d['vacantes']);
                $spreadsheet->getActiveSheet()->setCellValue("G{$start}", ($d['vacantes']-$d['reclutados']));
                $spreadsheet->getActiveSheet()->setCellValue("H{$start}", $d['cod_base']);
                $spreadsheet->getActiveSheet()->setCellValue("I{$start}", $d['nom_modalidad_laboral']);
                $spreadsheet->getActiveSheet()->setCellValue("J{$start}", $d['tipo_remuneracion']);
                if($d['tipo_sueldo']==1){
                    $spreadsheet->getActiveSheet()->setCellValue("K{$start}", $d['sueldo']);
                }
                if($d['tipo_sueldo']==2){
                    $spreadsheet->getActiveSheet()->setCellValue("L{$start}", $d['desde']);
                    $spreadsheet->getActiveSheet()->setCellValue("M{$start}", $d['a']);
                }

                $spreadsheet->getActiveSheet()->setCellValue("N{$start}", $d['asignado_a']);
                $spreadsheet->getActiveSheet()->setCellValue("O{$start}", $d['nom_prioridad']);
                if($d['fecha_cierre']!="00-00-0000"){
                    $spreadsheet->getActiveSheet()->setCellValue("P{$start}", $d['fecha_cierre']);
                }

                $spreadsheet->getActiveSheet()->setCellValue("Q{$start}", $d['observacion']);
                $spreadsheet->getActiveSheet()->setCellValue("R{$start}", $d['nom_estado_reclutamiento']);

                $sheet->getStyle("A{$start}:R{$start}")->applyFromArray($styleThinBlackBorderOutline);
            }
            //Alignment
            //fONT SIZE
            $sheet->getStyle('A1:R1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //Custom width for Individual Columns
            $sheet->getColumnDimension('A')->setWidth(13);
            $sheet->getColumnDimension('B')->setWidth(17);
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(13);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(30);
            $sheet->getColumnDimension('O')->setWidth(13);
            $sheet->getColumnDimension('P')->setWidth(15);
            $sheet->getColumnDimension('Q')->setWidth(30);
            $sheet->getColumnDimension('R')->setWidth(12);

            //final part
            $curdate = date('d-m-Y');
           // $writer = new Xlsx($spreadsheet);
            $filename = 'Lista Reclutamiento '.$curdate;
            if (ob_get_contents()) ob_end_clean();
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
            $writer->save('php://output');
    }

    public function Modal_Reclutamiento_Reclutado($id_reclutamiento) {
        $dato['id_reclutamiento']=$id_reclutamiento;
        $dato['list_colaborador'] = $this->modelo_users->get_list_colaborador();
        return view('rrhh.Reclutamiento.modal_reg_reclutado',$dato);
    }

    public function Insert_Reclutamiento_Reclutado(){
            $dato['id_reclutamiento']= $this->input->post("id_reclutamiento2");
            $dato['id_usuario']= $this->input->post("id_colaborador");


            // Realiza la consulta usando Eloquent
            $cant = ReclutamientoReclutado::where('estado', 1)
                        ->where('id_reclutamiento', $dato['id_reclutamiento'])
                        ->where('id_usuario', $dato['id_usuario'])
                        ->count();

            if($cant>0){
                echo "error1";
            }else{
                $dato['get_id'] = $this->modelo->get_list_reclutamiento($dato['id_reclutamiento'],0,0);
                $dato['list_detalle_reclutamiento'] = $this->modelo_detalles->get_list_detalle_reclutamiento($dato['id_reclutamiento']);
                if(count($dato['list_detalle_reclutamiento'])<$dato['get_id'][0]['vacantes']){
                    ReclutamientoReclutado::create([
                        'id_reclutamiento' => $dato['id_reclutamiento'],
                        'id_usuario' => $dato['id_usuario'],
                        'estado' => 1,
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_reg' => now(),
                    ]);
                }else{
                    echo "error2";
                }
            }
    }

    public function List_Reclutamiento_Reclutado(){
            $id_reclutamiento= $this->input->post("id_reclutamiento");
            $dato['list_detalle_reclutamiento'] = $this->modelo_detalles->get_list_detalle_reclutamiento($id_reclutamiento);
            return view('rrhh.Reclutamiento.list_reclutado',$dato);
    }

}

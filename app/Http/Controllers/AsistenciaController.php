<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Base;
use App\Models\Usuario;
use App\Models\Area;
use App\Models\Gerencia;
use App\Models\Mes;
use App\Models\Anio;
use App\Models\SubGerencia;
use DateTime;
use App\Models\Notificacion;
use App\Models\Ubicacion;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AsistenciaController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelobase;
    protected $modelousuarios;
    protected $modeloarea;
    protected $modelogerencia;
    protected $modelomes;
    protected $modeloanio;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new Asistencia();
        $this->modelobase = new Base();
        $this->modelousuarios = new Usuario();
        $this->modelogerencia = new Gerencia();
        $this->modeloarea = new Area();
        $this->modelomes = new Mes();
        $this->modeloanio = new Anio();
    }

    //parte superior de pestañas
    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        //$dato['list_asistencia'] = $this->Model_Asistencia->get_list_asistencia_biotime();
        $id_gerencia = 0;

        $id_area = Session('usuario')->id_area;
        $id_puesto = Session('usuario')->id_puesto;
        $centro_labores = Session('usuario')->id_centro_labor;
        $cod_base = 0;
        $num_doc = 0;
        $list_base = Ubicacion::select('id_ubicacion', 'cod_ubi')
                    ->where('estado', 1)
                    ->orderBy('cod_ubi', 'ASC')
                    ->get();
        //print_r($list_base[0]);
        
        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161  || $id_puesto==314) {
            $cod_base = $centro_labores;
        } else {
            $cod_base = 23;
        }
        $estado = 1;
        $list_colaborador = $this->modelousuarios->get_list_usuarios_x_baset($cod_base, $area = null, $estado);
        $list_area = $this->modeloarea->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        $list_gerencia = $this->modelogerencia->get_list_gerencia();
        $list_mes = $this->modelomes->where('estado', 1)->get();
        $list_anio = $this->modeloanio->where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161 || $id_puesto == 314) {
            return view('rrhh.Asistencia.reporte.indexct', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        } else {
            return view('rrhh.Asistencia.reporte.index', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        }
        /*
        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia('06','2024','OFC','76244986','1','2024-06-13','2024-06-13');
        print_r($list_asistencia);*/
    }

    public function Buscar_Reporte_Control_Asistencia(Request $request){
        set_time_limit(300);
        ini_set('max_execution_time', 300);

        $id_puesto = Session('usuario')->id_puesto;
        $cod_mes = $request->input("cod_mes");
        $cod_anio = $request->input("cod_anio");
        $cod_base = $request->input("cod_base");
        $num_doc = $request->input("num_doc");
        $area = $request->input("area");
        $estado = $request->input("estado");
        $tipo = $request->input("tipo");
        $finicio = $request->input("finicio");
        $ffin = $request->input("ffin");

        $usuarios = Usuario::select('usuario_codigo', 'id_usuario');

        if ($estado == 1 || $estado == 2) {
            $usuarios->where('users.estado', $estado);
        }
        if ($num_doc != 0) {
            $usuarios->where('users.usuario_codigo', $num_doc);
        }
        if ($cod_base != 0) {
            if($cod_base === "t" ){
                $usuarios->leftJoin('ubicacion', 'users.id_centro_labor', 'ubicacion.id_ubicacion');
                $usuarios->where('ubicacion.estado', 1);
                $usuarios->where('ubicacion.id_sede', 6);
            }else{
                $usuarios->where('users.id_centro_labor', $cod_base);
            }
        }
        if ($area != 0) {
            $usuarios->leftJoin('puesto', 'users.id_puesto', 'puesto.id_puesto');
            $usuarios->where('puesto.id_area', $area);
        }

        // $query = $usuarios->toSql(); // Obtener la consulta SQL generada
        // $bindings = $usuarios->getBindings(); // Obtener los bindings (valores)

        // echo "Consulta: $query\n";
        // print_r($bindings); // Imprimir los valores que se utilizan en la consulta

        $usuarios = $usuarios->get();
        // print_r($cod_base);

        $year = date('Y');
        if ($tipo == 1) {
            $year = $cod_anio;
            $fecha_inicio = strtotime("01-$cod_mes-$year");
            $L = new DateTime("$year-$cod_mes-01");
            $fecha_fin = $L->format('Y-m-t');
            $timestamp = strtotime($fecha_fin);
            $fecha_fin = strtotime(date("d-m-Y", $timestamp));
        } else {
            $fecha_inicio = strtotime(date("d-m-Y", strtotime($request->input("finicio"))));
            $fecha_fin = strtotime(date("d-m-Y", strtotime($request->input("ffin"))));
        }

        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios);
        // print_r($list_asistencia);
        if ($num_doc != 0) {
            $list_colaborador = $this->modelo->get_list_usuario_xnum_doc($num_doc);
        } else {
            $list_colaborador = $this->modelo->get_list_usuarios_x_baset($cod_base, $area, $estado);
        }
        $n_documento = $num_doc;

        if ($id_puesto == 29 || $id_puesto == 161 || $id_puesto == 197) {
            return view('rrhh.Asistencia.reporte.listarct', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        } else {
            return view('rrhh.Asistencia.reporte.listar', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        }
    }

    public function Traer_Colaborador_Asistencia(Request $request){
            $dato['cod_base'] = $request->input('cod_base');
            $dato['id_area'] = $request->input('id_area');
            $dato['estado'] = $request->input('estado');
            $dato['list_colaborador'] = $this->modelousuarios->get_list_usuarios_x_baset($dato['cod_base'],$dato['id_area'],$dato['estado']);
            return view('rrhh.Asistencia.reporte.colaborador', $dato);
    }
    
    public function Excel_Reporte_Asistencia($cod_mes, $cod_anio, $cod_base, $num_doc, $area, $estado, $tipo, $finicio, $ffin, Request $request){
        // Crear una nueva instancia de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Reporte Control Asistencia');
    
        // Encabezados
        $headers = ['Fecha', 'Nombres', 'Apellido Paterno', 'Apellido Materno', 'Código', 'Total Marcaciones', 'Estado Marcación'];
        $sheet->fromArray($headers, NULL, 'A1');
    
        // Obtener usuarios según los parámetros
        $usuarios = Usuario::select('usuario_codigo', 'id_usuario');
    
        if ($estado == 1 || $estado == 2) {
            $usuarios->where('users.estado', $estado);
        }
        if ($num_doc != 0) {
            $usuarios->where('users.usuario_codigo', $num_doc);
        }
        if ($cod_base != 0) {
            if ($cod_base === "t") {
                $usuarios->leftJoin('ubicacion', 'users.id_centro_labor', 'ubicacion.id_ubicacion');
                $usuarios->where('ubicacion.estado', 1);
                $usuarios->where('ubicacion.id_sede', 6);
            } else {
                $usuarios->where('users.id_centro_labor', $cod_base);
            }
        }
        if ($area != 0) {
            $usuarios->leftJoin('puesto', 'users.id_puesto', 'puesto.id_puesto');
            $usuarios->where('puesto.id_area', $area);
        }
    
        // Obtener los usuarios
        $usuarios = $usuarios->get();
    
        // Establecer fechas de inicio y fin
        $year = date('Y');
        if ($tipo == 1) {
            $year = $cod_anio;
            $fecha_inicio = strtotime("01-$cod_mes-$year");
            $L = new DateTime("$year-$cod_mes-01");
            $fecha_fin = $L->format('Y-m-t');
            $timestamp = strtotime($fecha_fin);
            $fecha_fin = strtotime(date("d-m-Y", $timestamp));
        } else {
            $fecha_inicio = strtotime(date("d-m-Y", strtotime($finicio)));
            $fecha_fin = strtotime(date("d-m-Y", strtotime($ffin)));
        }
    
        // Llamada a la función para obtener los datos
        $data = $this->modelo->buscar_reporte_control_asistencia_excel($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios);
    
        // Agregar los datos al archivo Excel
        $row = 2; // Comenzamos en la fila 2
        foreach ($data as $num_doc => $registros) {
            foreach ($registros as $item) {
                // Agregar los datos en las celdas correspondientes
                $sheet->setCellValue('A' . $row, $item['fecha']);
                $sheet->setCellValue('B' . $row, $item['usuario_nombres']);
                $sheet->setCellValue('C' . $row, $item['usuario_apater']);
                $sheet->setCellValue('D' . $row, $item['usuario_amater']);
                $sheet->setCellValue('E' . $row, $item['emp_code']);
                $sheet->setCellValue('F' . $row, $item['total_marcaciones']);
                $sheet->setCellValue('G' . $row, $item['estado_marcacion']);
                $row++;
            }
        }
    
        // Parte final: crear y descargar el archivo Excel
        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Reporte Control Asistencia ' . $curdate;
    
        // Configuración de cabeceras para la descarga
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        
        // Guardar y enviar el archivo al navegador
        $writer->save('php://output');
    }

    public function Update_Asistencia_Diaria(Request $request){
        $request->validate([
            'hora' => 'required'
        ],[
            'hora' => 'Debe ingresar hora.',
        ]);

        $dato['hora'] = $request->post("hora");
        $dato['fecha'] = $request->post("fecha");
        $dato['punch_time']=$dato['fecha']." ".$dato['hora'];
        $dato['id_asistencia_remota'] = $request->post("id_asistencia_remota");
        
        DB::connection('second_mysql')
            ->table('iclock_transaction')
            ->where('id', $dato['id_asistencia_remota'])
            ->update([
                'punch_time' => $dato['punch_time']
            ]);
    }
    
    public function Modal_Reg_Asistencia(Request $request) {
        return view('rrhh.Asistencia.reporte.modal_reg');
    }    
    
    public function Modal_Registro_Dia($nombres,$num_doc,$orden,$time){
        $dato['nombres']=$nombres;
        $dato['num_doc']=$num_doc;
        $dato['fecha']=$orden;
        $dato['time']=$time;
        return view('rrhh.Asistencia.reporte.modal_reg',$dato);
    }

    public function Insert_Asistencia_Diaria(Request $request){
            $dato['hora']=$request->post("horar");
            $dato['fecha']=$request->post("fechar");
            $dato['num_doc']=$request->post("num_docr");
            $dato['punch_time']=$dato['fecha']." ".$dato['hora'];
            $dato['get_id'] = Usuario::select('ubicacion.cod_ubi AS centro_labores')
                            ->leftJoin('ubicacion', 'users.id_centro_labor' ,'=', 'ubicacion.id_ubicacion')
                            ->where('users.num_doc',$dato['num_doc'])
                            ->get();
            
            //print_r($dato['get_id']);
            if(empty($dato['get_id'])){
                echo "error";
            }else{
                $dato['base']=$dato['get_id'][0]->centro_labores;
                $dato['get_employee']=DB::connection('second_mysql')
                            ->table('personnel_employee')
                            ->select('id')
                            ->whereRaw("LPAD(emp_code, 8, '0') = ?", [$dato['num_doc']])
                            ->first();

                //print_r($dato['get_employee']);
                $dato['emp_id']=$dato['get_employee']->id;
                $dato['get_terminal']=DB::connection('second_mysql')
                            ->table('iclock_terminal')
                            ->select('id', 'sn', 'alias')
                            ->where('alias', $dato['base'])
                            ->get();
                if(count($dato['get_terminal'])>0){
                    $dato['terminal_id']=$dato['get_terminal'][0]->id;
                    $dato['terminal_sn']=$dato['get_terminal'][0]->sn;
                    $dato['terminal_alias']=$dato['get_terminal'][0]->alias;
                }else{
                    $dato['terminal_id']="23";
                    $dato['terminal_sn']="AF6P211660021";
                    $dato['terminal_alias']=$dato['base'];//"OFC";
                }
                DB::connection('second_mysql')
                    ->table('iclock_transaction')
                    ->insert([
                        'emp_code'      => $dato['num_doc'],
                        'punch_time'    => $dato['punch_time'],
                        'punch_state'   => 0,
                        'verify_type'   => 1,
                        'terminal_sn'   => $dato['terminal_sn'],
                        'terminal_alias'=> $dato['terminal_alias'],
                        'source'        => 1,
                        'purpose'       => 9,
                        'upload_time'   => $dato['punch_time'],
                        'emp_id'        => $dato['emp_id'],
                        'terminal_id'   => $dato['terminal_id'],
                        'is_mask'       => '255',
                        'temperature'   => '255.0',
                    ]);
            }
    }
    
    public function Buscar_No_Marcados(Request $request){
        $id_puesto = Session('usuario')->id_puesto;
        $cod_mes = $request->input("cod_mes");
        $cod_anio = $request->input("cod_anio");
        $cod_base = $request->input("cod_base");
        $num_doc = $request->input("num_doc");
        $area = $request->input("area");
        $estado = $request->input("estado");
        $tipo = $request->input("tipo");
        $finicio = $request->input("finicio");
        $ffin = $request->input("ffin");

        $usuarios = Usuario::select('usuario_codigo', 'id_usuario');

        if ($estado == 1 || $estado == 2) {
            $usuarios->where('users.estado', $estado);
        }
        if ($num_doc != 0) {
            $usuarios->where('users.usuario_codigo', $num_doc);
        }
        if ($cod_base != 0) {
            if($cod_base === "t" ){
                $usuarios->leftJoin('ubicacion', 'users.id_centro_labor', 'ubicacion.id_ubicacion');
                $usuarios->where('ubicacion.estado', 1);
                $usuarios->where('ubicacion.id_sede', 6);
            }else{
                $usuarios->where('users.id_centro_labor', $cod_base);
            }
        }
        if ($area != 0) {
            $usuarios->leftJoin('puesto', 'users.id_puesto', 'puesto.id_puesto');
            $usuarios->where('puesto.id_area', $area);
        }

        // $query = $usuarios->toSql(); // Obtener la consulta SQL generada
        // $bindings = $usuarios->getBindings(); // Obtener los bindings (valores)

        // echo "Consulta: $query\n";
        // print_r($bindings); // Imprimir los valores que se utilizan en la consulta

        $usuarios = $usuarios->get();
        // print_r($cod_base);

        $year = date('Y');
        if ($tipo == 1) {
            $year = $cod_anio;
            $fecha_inicio = strtotime("01-$cod_mes-$year");
            $L = new DateTime("$year-$cod_mes-01");
            $fecha_fin = $L->format('Y-m-t');
            $timestamp = strtotime($fecha_fin);
            $fecha_fin = strtotime(date("d-m-Y", $timestamp));
        } else {
            $fecha_inicio = strtotime(date("d-m-Y", strtotime($request->input("finicio"))));
            $fecha_fin = strtotime(date("d-m-Y", strtotime($request->input("ffin"))));
        }

        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia_nm($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios);
        // print_r($list_asistencia);
        if ($num_doc != 0) {
            $list_colaborador = $this->modelo->get_list_usuario_xnum_doc($num_doc);
        } else {
            $list_colaborador = $this->modelo->get_list_usuarios_x_baset($cod_base, $area, $estado);
        }
        $n_documento = $num_doc;

        if ($id_puesto == 29 || $id_puesto == 161 || $id_puesto == 197) {
            return view('rrhh.Asistencia.NoMarcados.listarct_nm', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        } else {
            return view('rrhh.Asistencia.NoMarcados.listar_nm', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        }
    }
}

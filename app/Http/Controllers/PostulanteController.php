<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Base;
use App\Models\Cargo;
use App\Models\Gerencia;
use App\Models\HistoricoPostulante;
use App\Models\Notificacion;
use App\Models\Postulante;
use App\Models\Puesto;
use App\Models\SubGerencia;
use App\Models\TipoDocumento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PostulanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        return view('rrhh.postulante.index', compact('list_notificacion','list_subgerencia'));
    }

    public function index_reg()
    {
        if(session('usuario')->id_puesto=="30" || 
        session('usuario')->id_puesto=="161" || 
        session('usuario')->id_puesto=="314"){
            $list_area = Area::select('id_area','nom_area')->whereIn('id_area',[14,44])->orderBy('nom_area','ASC')
                        ->get();
        }else{
            $list_area = Area::select('id_area','nom_area')->where('estado',1)->orderBy('nom_area','ASC')
                        ->get();                        
        }
        return view('rrhh.postulante.registro.index', compact('list_area'));
    }

    public function list_reg(Request $request)
    {
        $list_postulante = Postulante::get_list_postulante([
            'estado'=>$request->estado,
            'id_area'=>$request->id_area
        ]);
        return view('rrhh.postulante.registro.lista', compact('list_postulante'));
    }

    public function create_reg()
    {
        $list_tipo_documento = TipoDocumento::select('id_tipo_documento','cod_tipo_documento')
                                ->where('estado',1)->orderBy('cod_tipo_documento','ASC')->get();
        if(session('usuario')->id_nivel=="1" || 
        session('usuario')->id_puesto=="21" || 
        session('usuario')->id_puesto=="22" || 
        session('usuario')->id_puesto=="277" ||
        session('usuario')->id_puesto=="278"){
            $list_area = Area::select('id_area', 'nom_area')->where('estado', 1)
                        ->orderBy('nom_area','ASC')->get();
        }else{
            $list_area = Area::select('id_area', 'nom_area')
                        ->whereIn('id_area', [14,44])->orderBy('nom_area','ASC')->get();
        }
        $list_puesto_evaluador = Puesto::select('id_puesto','nom_puesto')->where('evaluador',1)
                                ->where('estado',1)->orderBy('nom_puesto','ASC')->get();
        return view('rrhh.postulante.registro.modal_registrar', compact(
            'list_tipo_documento',
            'list_area',
            'list_puesto_evaluador'
        ));
    }

    public function traer_puesto(Request $request)
    {
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')->where('id_area', $request->id_area)
                        ->where('estado', 1)->orderBy('nom_puesto','ASC')->get();
        return view('rrhh.postulante.registro.puesto', compact('list_puesto'));
    }

    public function traer_evaluador(Request $request)
    {
        $list_evaluador = Usuario::select('id_usuario',
                        DB::raw("CONCAT(usuario_apater,' ',usuario_amater,', ',
                        usuario_nombres) AS nom_usuario"))
                        ->where('id_puesto',$request->id_puesto_evaluador)->where('estado',1)->get();
        return view('rrhh.postulante.registro.evaluador', compact('list_evaluador'));
    }

    public function store_reg(Request $request)
    {
        if(session('usuario')->id_nivel=="1" ||
        session('usuario')->id_puesto=="21" ||
        session('usuario')->id_puesto=="22" ||
        session('usuario')->id_puesto=="277" ||
        session('usuario')->id_puesto=="278" ||
        session('usuario')->id_puesto=="314"){
            $request->validate([
                'id_tipo_documento' => 'gt:0',
                'num_doc' => 'required',
                'id_gerencia' => 'gt:0',
                'id_sub_gerencia' => 'gt:0',
                'id_area' => 'gt:0',
                'id_puesto' => 'gt:0',
                'id_puesto_evaluador' => 'gt:0',
                'id_evaluador' => 'gt:0'
            ],[
                'id_tipo_documento.gt' => 'Debe seleccionar tipo de documento.',
                'num_doc.required' => 'Debe ingresar número documento.',
                'id_gerencia.gt' => 'Debe seleccionar gerencia.',
                'id_sub_gerencia.gt' => 'Debe seleccionar sub-gerencia.',
                'id_area.gt' => 'Debe seleccionar área.',
                'id_puesto.gt' => 'Debe seleccionar puesto.',
                'id_puesto_evaluador.gt' => 'Debe seleccionar puesto evaluador.',
                'id_evaluador.gt' => 'Debe seleccionar evaluador.'
            ]);

            $get_usuario = Usuario::findOrFail($request->id_evaluador);
            $id_centro_labor = $get_usuario->id_centro_labor;
            $id_puesto_evaluador = $request->id_puesto_evaluador;
            $id_evaluador = $request->id_evaluador;
        }else{
            $request->validate([
                'id_tipo_documento' => 'gt:0',
                'num_doc' => 'required',
                'id_gerencia' => 'gt:0',
                'id_sub_gerencia' => 'gt:0',
                'id_area' => 'gt:0',
                'id_puesto' => 'gt:0'
            ],[
                'id_tipo_documento.gt' => 'Debe seleccionar tipo de documento.',
                'num_doc.required' => 'Debe ingresar número documento.',
                'id_gerencia.gt' => 'Debe seleccionar gerencia.',
                'id_sub_gerencia.gt' => 'Debe seleccionar sub-gerencia.',
                'id_area.gt' => 'Debe seleccionar área.',
                'id_puesto.gt' => 'Debe seleccionar puesto.'
            ]);

            $id_centro_labor = session('usuario')->id_centro_labor; 
            $id_puesto_evaluador = session('usuario')->id_puesto;
            $id_evaluador = session('usuario')->id_usuario;
        }

        $valida = Usuario::where('id_tipo_documento', $request->id_tipo_documento)
                ->where('num_doc', $request->num_doc)->whereIn('estado', [1,3,4])->exists();
        if($valida){
            echo "error_usuario";
        }else{
            $valida = Postulante::where('id_tipo_documento', $request->id_tipo_documento)
                    ->where('num_doc', $request->num_doc)->where('estado', 1)->exists();

            if($valida){
                echo "error_postulante";
            }else{
                $get_cargo = Cargo::where('id_puesto',$request->id_puesto)->count();
                if($get_cargo>0){
                    $id_cargo = $get_cargo->id_cargo;
                }else{
                    $id_cargo = NULL;
                }
                $postulante_password = password_hash($request->num_doce, PASSWORD_DEFAULT);

                $postulante = Postulante::create([
                    'id_centro_labor' => $id_centro_labor,
                    'postulante_codigo' => $request->num_doc,
                    'postulante_password' => $postulante_password,
                    'password_desencriptado' => $request->num_doc,
                    'id_tipo_documento' => $request->id_tipo_documento,
                    'num_doc' => $request->num_doc,
                    'id_puesto' => $request->id_puesto,
                    'id_puesto_evaluador' => $id_puesto_evaluador,
                    'id_evaluador' => $id_evaluador,
                    'estado_postulacion' => 1,
                    'id_cargo' => $id_cargo,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                HistoricoPostulante::create([
                    'id_postulante' => $postulante->id_postulante,
                    'observacion' => 'Primer histórico',
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }
    }

    public function edit_reg($id)
    {
        $get_id = Postulante::findOrFail($id);
        $list_tipo_documento = TipoDocumento::select('id_tipo_documento','cod_tipo_documento')
                                ->where('estado',1)->orderBy('cod_tipo_documento','ASC')->get();
        return view('rrhh.postulante.registro.modal_editar', compact('get_id','list_tipo_documento'));
    }

    public function update_reg(Request $request, $id)
    {
        $request->validate([
            'id_tipo_documentoe' => 'gt:0',
            'num_doce' => 'required'
        ],[
            'id_tipo_documentoe.gt' => 'Debe seleccionar tipo de documento.',
            'num_doce.required' => 'Debe ingresar número documento.'
        ]);

        $valida = Postulante::where('id_tipo_documento', $request->id_tipo_documentoe)
                ->where('num_doc', $request->num_doce)->where('estado', 1)
                ->where('id_postulante', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            $postulante_password = password_hash($request->num_doce, PASSWORD_DEFAULT);

            Postulante::findOrFail($id)->update([
                'postulante_codigo' => $request->num_doce,
                'postulante_password' => $postulante_password,
                'password_desencriptado' => $request->num_doce,
                'id_tipo_documento' => $request->id_tipo_documentoe,
                'num_doc' => $request->num_doce,
                'fec_eli' => now(),
                'user_eli' => session('usuario')->id_usuario
            ]);
        }
    }
    
    public function destroy_reg($id)
    {
        Postulante::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel_reg($estado, $id_area)
    {
        $list_postulante = Postulante::get_list_postulante([
            'estado'=>$estado,
            'id_area'=>$id_area
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Postulante');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getColumnDimension('H')->setWidth(25);

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

        $sheet->setCellValue("A1", 'F. de creación');
        $sheet->setCellValue("B1", 'Área');
        $sheet->setCellValue("C1", 'Puesto');
        $sheet->setCellValue("D1", 'Nombre(s)');
        $sheet->setCellValue("E1", 'Documento');
        $sheet->setCellValue("F1", 'Celular');
        $sheet->setCellValue("G1", 'Creado por');
        $sheet->setCellValue("H1", 'Estado');

        $contador = 1;

        foreach ($list_postulante as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->orden));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->nom_area); 
            $sheet->setCellValue("C{$contador}", $list->nom_puesto);
            $sheet->setCellValue("D{$contador}", $list->nom_postulante);
            $sheet->setCellValue("E{$contador}", $list->num_doc);
            $sheet->setCellValue("F{$contador}", $list->num_celp);
            $sheet->setCellValue("G{$contador}", $list->creado_por);
            $sheet->setCellValue("H{$contador}", $list->nom_estado); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Postulante';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function index_tod()
    {
        $list_area = Area::where('estado',1)->orderBy('nom_area','ASC')->get();
        return view('rrhh.postulante.todos.index', compact('list_area'));
    }

    public function list_tod(Request $request)
    {
        $list_todos = Postulante::get_list_todos([
            'estado'=>$request->estado,
            'id_area'=>$request->id_area
        ]);
        return view('rrhh.postulante.todos.lista', compact('list_todos'));
    }

    public function update_tod(Request $request, $id)
    {
        Postulante::findOrFail($id)->update([
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function excel_tod($estado, $id_area)
    {
        $list_todos = Postulante::get_list_todos([
            'estado'=>$estado,
            'id_area'=>$id_area
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Postulante (Todos)');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getColumnDimension('H')->setWidth(25);

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

        $sheet->setCellValue("A1", 'F. de creación');
        $sheet->setCellValue("B1", 'Área');
        $sheet->setCellValue("C1", 'Puesto');
        $sheet->setCellValue("D1", 'Nombre(s)');
        $sheet->setCellValue("E1", 'Documento');
        $sheet->setCellValue("F1", 'Celular');
        $sheet->setCellValue("G1", 'Creado por');
        $sheet->setCellValue("H1", 'Estado');

        $contador = 1;

        foreach ($list_todos as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->orden));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->nom_area); 
            $sheet->setCellValue("C{$contador}", $list->nom_puesto);
            $sheet->setCellValue("D{$contador}", $list->nom_postulante);
            $sheet->setCellValue("E{$contador}", $list->num_doc);
            $sheet->setCellValue("F{$contador}", $list->num_celp);
            $sheet->setCellValue("G{$contador}", $list->creado_por);
            $sheet->setCellValue("H{$contador}", $list->nom_estado); 
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Postulante (Todos)';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function index_prev()
    {
        return view('rrhh.postulante.revision.index');
    }

    public function list_prev(Request $request)
    {
        $list_revision = Postulante::select('id_postulante','centro_labores','num_doc','postulante_apater',
                        'postulante_amater','postulante_nombres')->where('estado_postulacion',11)
                        ->where('estado',1)->get();
        return view('rrhh.postulante.revision.lista', compact('list_revision'));
    }

    public function edit_prev($id)
    {
        $get_id = Postulante::findOrFail($id);
        $get_base = Base::where('cod_base',$get_id->centro_labores)->first();
        $get_base = Base::select(DB::raw("GROUP_CONCAT(DISTINCT CONCAT('\'',cod_base,'\'')) AS cadena"))
                    ->where('id_departamento',$get_base->id_departamento)->where('estado',1)->first();
        $list_vinculo = Usuario::select('users.centro_labores','users.num_doc','users.usuario_apater',
                        'users.usuario_amater','users.usuario_nombres','vw_estado_usuario.nom_estado_usuario',
                        DB::raw('CASE WHEN LEFT(users.fin_funciones,1)="2" THEN DATE_FORMAT(users.fin_funciones, 
                        "%d/%m/%Y") ELSE "" END AS fecha_cese'))
                        ->join('vw_estado_usuario','vw_estado_usuario.id_estado_usuario','=','users.estado')
                        ->whereRaw('users.centro_labores IN ('.$get_base->cadena.') AND (users.usuario_apater=? OR 
                        users.usuario_amater=?) AND users.estado IN (1,3)',[$get_id->postulante_apater, $get_id->postulante_amater])
                        ->get();
        return view('rrhh.postulante.revision.modal_editar',compact('get_id','list_vinculo'));
    }

    public function update_prev(Request $request,$id)
    {
        $request->validate([
            'resultado' => 'gt:0'
        ],[
            'resultado.gt' => 'Debe seleccionar resultado.'
        ]);

        echo "Siuuu";
        /*if($tipo=="ingreso"){
            $request->validate([
                'cod_sedee' => 'not_in:0',
                'h_ingresoe' => 'required'
            ],[
                'cod_sedee.not_in' => 'Debe seleccionar sede.',
                'h_ingresoe.required' => 'Debe ingresar hora ingreso.'
            ]);

            SeguridadAsistencia::findOrFail($id)->update([
                'cod_sede' => $request->cod_sedee,
                'h_ingreso' => $request->h_ingresoe,
                'observacion' => $request->observacione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }else{
            $request->validate([
                'fecha_salidae' => 'required',
                'cod_sedese' => 'not_in:0',
                'h_salidae' => 'required'
            ],[
                'fecha_salidae.required' => 'Debe ingresar fecha.',
                'cod_sedese.not_in' => 'Debe seleccionar sede.',
                'h_salidae.required' => 'Debe ingresar hora salida.'
            ]);

            SeguridadAsistencia::findOrFail($id)->update([
                'fecha_salida' => $request->fecha_salidae,
                'cod_sedes' => $request->cod_sedese,
                'h_salida' => $request->h_salidae,
                'observacion' => $request->observacione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }*/
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Base;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\DomicilioUsers;
use App\Models\DomicilioUsersP;
use App\Models\EstadoCivil;
use App\Models\EvalJefeDirecto;
use App\Models\EvalRrhhPostulante;
use App\Models\Genero;
use App\Models\HistoricoPostulante;
use App\Models\Nacionalidad;
use App\Models\Notificacion;
use App\Models\Organigrama;
use App\Models\Postulante;
use App\Models\Provincia;
use App\Models\Puesto;
use App\Models\SubGerencia;
use App\Models\TipoDocumento;
use App\Models\UsersHistoricoCentroLabores;
use App\Models\UsersHistoricoModalidad;
use App\Models\UsersHistoricoPuesto;
use App\Models\Usuario;
use App\Models\VerificacionSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

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

    public function traer_provincia(Request $request)
    {
        $list_provincia = Provincia::select('id_provincia', 'nombre_provincia')
                        ->where('id_departamento', $request->id_departamento)->where('estado', 1)->get();
        return view('rrhh.postulante.provincia', compact('list_provincia'));
    }

    public function traer_distrito(Request $request)
    {
        $list_distrito = Distrito::select('id_distrito', 'nombre_distrito')
                        ->where('id_provincia', $request->id_provincia)->where('estado', 1)->get();
        return view('rrhh.postulante.distrito', compact('list_distrito'));
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
        session('usuario')->id_puesto=="158" || 
        session('usuario')->id_puesto=="209" ||         
        session('usuario')->id_puesto=="277" ||
        session('usuario')->id_puesto=="278" ||
        session('usuario')->id_puesto=="314"){
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
        session('usuario')->id_puesto=="158" || 
        session('usuario')->id_puesto=="209" ||         
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

        $valida = Organigrama::where('id_puesto',$request->id_puesto)
                ->where('id_centro_labor',$id_centro_labor)->where('id_usuario',0)->count();

        if($valida>0){
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
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);

                    HistoricoPostulante::create([
                        'id_postulante' => $postulante->id_postulante,
                        'observacion' => 'CREACIÓN DE POSTULANTE',
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                }
            }
        }else{
            echo "error_organigrama";
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

    public function datos_iniciales_reg($id)
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //MÓDULO
        $get_id = Postulante::findOrFail($id);
        if($get_id->estado_postulacion=="1"){
            $list_nacionalidad = Nacionalidad::select('id_nacionalidad','nom_nacionalidad')
                                ->where('estado',1)->get();
            $list_genero = Genero::select('id_genero','nom_genero')->where('estado',1)->get();
            $list_estado_civil = EstadoCivil::select('id_estado_civil','nom_estado_civil')
                        ->where('estado',1)->get();
            $list_tipo_documento = TipoDocumento::select('id_tipo_documento','cod_tipo_documento')
                            ->where('estado',1)->orderBy('cod_tipo_documento','ASC')->get();
            $list_departamento = Departamento::select('id_departamento','nombre_departamento')
                        ->where('estado',1)->get();
            return view('rrhh.postulante.registro.datos_iniciales', compact(
                'list_notificacion',
                'list_subgerencia',
                'get_id',
                'list_nacionalidad',
                'list_genero',
                'list_estado_civil',
                'list_tipo_documento',
                'list_departamento'
            ));
        }else{
            return redirect()->route('postulante');
        }
    }

    public function update_datos_iniciales_reg(Request $request, $id)
    {
        $request->validate([
            'postulante_apater' => 'required',
            'postulante_amater' => 'required',
            'postulante_nombres' => 'required',
            'id_tipo_documento' => 'gt:0',
            'num_doc' => 'required',
            'id_nacionalidad' => 'gt:0',
            'id_genero' => 'gt:0',
            'id_estado_civil' => 'gt:0',
            'fec_nac' => 'required',
            'emailp' => 'required',
            'num_celp' => 'required'
        ],[
            'postulante_apater.required' => 'Debe ingresar apellido paterno.',
            'postulante_amater.required' => 'Debe ingresar apellido materno.',
            'postulante_nombres.required' => 'Debe ingresar nombres.',
            'id_tipo_documento.gt' => 'Debe seleccionar tipo de documento.',
            'num_doc.required' => 'Debe ingresar número documento.',
            'id_nacionalidad.gt' => 'Debe seleccionar nacionalidad.',
            'id_genero.gt' => 'Debe seleccionar género.',
            'id_estado_civil.gt' => 'Debe seleccionar estado civil.',
            'fec_nac.required' => 'Debe ingresar fecha de nacimiento.',
            'emailp.required' => 'Debe ingresar correo electrónico.',
            'num_celp.required' => 'Debe ingresar número celular.'
        ]);

        $errors = [];
        $fecha_nacimiento = new \DateTime($request->fec_nac);
        $fecha_actual = new \DateTime();
        $edad = $fecha_actual->diff($fecha_nacimiento)->y;
        if($edad<18){
            $errors['edad'] = ['Debe ser mayor de edad para actualizar datos.'];
        }
        if ($request->id_departamento != "0") {
            if ($request->id_provincia == "0") {
                $errors['id_provincia'] = ['Debe seleccionar provincia.'];
            }
        }
        if ($request->id_provincia != "0") {
            if ($request->id_distrito == "0") {
                $errors['id_distrito'] = ['Debe seleccionar distrito.'];
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $get_id = Postulante::from('postulante AS po')->select('po.foto','pu.id_area')
                ->join('puesto AS pu','pu.id_puesto','=','po.id_puesto')
                ->where('id_postulante',$id)->first();
        $archivo = $get_id->foto;
        if($_FILES["foto"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if($get_id->foto!=""){
                    ftp_delete($con_id, "POSTULANTE/FOTO/".basename($get_id->foto));
                }

                $path = $_FILES["foto"]["name"];
                $source_file = $_FILES['foto']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Foto_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"POSTULANTE/FOTO/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/POSTULANTE/FOTO/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        if($get_id->id_area=="14" || $get_id->id_area=="44"){
            $estado_postulacion = 4;
        }else{
            $estado_postulacion = 2;
        }

        Postulante::findOrFail($id)->update([
            'postulante_apater' => $request->postulante_apater,
            'postulante_amater' => $request->postulante_amater,
            'postulante_nombres' => $request->postulante_nombres,
            'id_tipo_documento' => $request->id_tipo_documento,
            'num_doc' => $request->num_doc,
            'id_nacionalidad' => $request->id_nacionalidad,
            'id_genero' => $request->id_genero,
            'id_estado_civil' => $request->id_estado_civil,
            'fec_nac' => $request->fec_nac,
            'emailp' => $request->emailp,
            'num_celp' => $request->num_celp,
            'num_fijop' => $request->num_fijop,
            'foto' => $archivo,
            'estado_postulacion' => $estado_postulacion,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        HistoricoPostulante::create([
            'id_postulante' => $id,
            'observacion' => 'INGRESO DE DATOS PERSONALES',
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($request->id_distrito!="0"){
            DomicilioUsersP::create([
                'id_postulante' => $id,
                'id_distrito' => $request->id_distrito,
                'lat' => $request->coordsltd,
                'lng' => $request->coordslng,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function perfil_reg($id)
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //MÓDULO
        $get_id = Postulante::from('postulante AS po')->select('po.*',DB::raw('TIMESTAMPDIFF(YEAR, po.fec_nac, CURDATE()) AS edad'))
                ->where('id_postulante',$id)->first();
        $get_base = Base::select('id_departamento')->where('id_ubicacion',$get_id->id_centro_labor)
                    ->first();
        if(isset($get_base->id_departamento)){
            $list_revision = Usuario::get_list_familiar_postulante([
                'id_departamento' => $get_base->id_departamento,
                'postulante_apater' => $get_id->postulante_apater,
                'postulante_amater' => $get_id->postulante_amater
            ]);
        }else{
            $list_revision = [];
        }
        return view('rrhh.postulante.registro.perfil.index', compact(
            'list_notificacion',
            'list_subgerencia',
            'get_id',
            'list_revision'
        ));
    }

    public function datos_personales_reg($id)
    {
        $get_id = Postulante::from('postulante AS po')
                ->select('po.*',DB::raw('TIMESTAMPDIFF(YEAR, po.fec_nac, CURDATE()) AS edad'))
                ->where('id_postulante',$id)->first();
        $list_nacionalidad = Nacionalidad::select('id_nacionalidad','nom_nacionalidad')
                            ->where('estado',1)->get();
        $list_genero = Genero::select('id_genero','nom_genero')->where('estado',1)->get();
        $list_estado_civil = EstadoCivil::select('id_estado_civil','nom_estado_civil')
                            ->where('estado',1)->get();
        $list_tipo_documento = TipoDocumento::select('id_tipo_documento','cod_tipo_documento')
                                ->where('estado',1)->orderBy('cod_tipo_documento','ASC')->get();
        return view('rrhh.postulante.registro.perfil.datos_personales', compact(
            'get_id',
            'list_nacionalidad',
            'list_genero',
            'list_estado_civil',
            'list_tipo_documento'
        ));
    }

    public function update_datos_personales_reg(Request $request, $id)
    {
        $request->validate([
            'postulante_apater' => 'required',
            'postulante_amater' => 'required',
            'postulante_nombres' => 'required',
            'id_tipo_documento' => 'gt:0',
            'num_doc' => 'required',
            'id_nacionalidad' => 'gt:0',
            'id_genero' => 'gt:0',
            'id_estado_civil' => 'gt:0',
            'fec_nac' => 'required',
            'emailp' => 'required',
            'num_celp' => 'required'
        ],[
            'postulante_apater.required' => 'Debe ingresar apellido paterno.',
            'postulante_amater.required' => 'Debe ingresar apellido materno.',
            'postulante_nombres.required' => 'Debe ingresar nombres.',
            'id_tipo_documento.gt' => 'Debe seleccionar tipo de documento.',
            'num_doc.required' => 'Debe ingresar número documento.',
            'id_nacionalidad.gt' => 'Debe seleccionar nacionalidad.',
            'id_genero.gt' => 'Debe seleccionar género.',
            'id_estado_civil.gt' => 'Debe seleccionar estado civil.',
            'fec_nac.required' => 'Debe ingresar fecha de nacimiento.',
            'emailp.required' => 'Debe ingresar correo electrónico.',
            'num_celp.required' => 'Debe ingresar número celular.'
        ]);

        $errors = [];
        $fecha_nacimiento = new \DateTime($request->fec_nac);
        $fecha_actual = new \DateTime();
        $edad = $fecha_actual->diff($fecha_nacimiento)->y;
        if($edad<18){
            $errors['edad'] = ['Debe ser mayor de edad para actualizar datos.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $get_id = Postulante::findOrFail($id);
        $archivo = $get_id->foto;
        if($_FILES["foto"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if($get_id->foto!=""){
                    ftp_delete($con_id, "POSTULANTE/FOTO/".basename($get_id->foto));
                }

                $path = $_FILES["foto"]["name"];
                $source_file = $_FILES['foto']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Foto_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"POSTULANTE/FOTO/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/POSTULANTE/FOTO/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        Postulante::findOrFail($id)->update([
            'postulante_apater' => $request->postulante_apater,
            'postulante_amater' => $request->postulante_amater,
            'postulante_nombres' => $request->postulante_nombres,
            'id_tipo_documento' => $request->id_tipo_documento,
            'num_doc' => $request->num_doc,
            'id_nacionalidad' => $request->id_nacionalidad,
            'id_genero' => $request->id_genero,
            'id_estado_civil' => $request->id_estado_civil,
            'fec_nac' => $request->fec_nac,
            'emailp' => $request->emailp,
            'num_celp' => $request->num_celp,
            'num_fijop' => $request->num_fijop,
            'foto' => $archivo,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function domicilio_titulo_reg($id)
    {
        $get_domicilio = DomicilioUsersP::from('domicilio_usersp AS do')
                        ->select('do.id_domicilio_usersp','pr.id_departamento',
                        'di.id_provincia','do.id_distrito','do.lat','do.lng')
                        ->join('distrito AS di','di.id_distrito','=','do.id_distrito')
                        ->join('provincia AS pr','pr.id_provincia','=','di.id_provincia')
                        ->where('id_postulante',$id)->orderBy('id_domicilio_usersp','DESC')->first();
        return view('rrhh.postulante.registro.perfil.domicilio_titulo', compact(
            'get_domicilio'
        ));
    }

    public function domicilio_contenido_reg($id)
    {
        $get_domicilio = DomicilioUsersP::from('domicilio_usersp AS do')
                        ->select('do.id_domicilio_usersp','pr.id_departamento',
                        'di.id_provincia','do.id_distrito','do.lat','do.lng')
                        ->join('distrito AS di','di.id_distrito','=','do.id_distrito')
                        ->join('provincia AS pr','pr.id_provincia','=','di.id_provincia')
                        ->where('id_postulante',$id)->orderBy('id_domicilio_usersp','DESC')->first();
        $list_departamento = Departamento::select('id_departamento','nombre_departamento')
                            ->where('estado',1)->get();
        if(isset($get_domicilio->id_domicilio_usersp)){
            $list_provincia = Provincia::select('id_provincia','nombre_provincia')
                            ->where('id_departamento',$get_domicilio->id_departamento)->where('estado',1)->get();
            $list_distrito = Distrito::select('id_distrito','nombre_distrito')
                            ->where('id_provincia',$get_domicilio->id_provincia)->where('estado',1)->get();
        }else{
            $list_provincia = [];
            $list_distrito = [];
        }
        return view('rrhh.postulante.registro.perfil.domicilio_contenido', compact(
            'get_domicilio',
            'list_departamento',
            'list_provincia',
            'list_distrito'
        ));
    }

    public function update_domicilio_reg(Request $request, $id)
    {
        $request->validate([
            'id_departamento' => 'not_in:0',
            'id_provincia' => 'not_in:0',
            'id_distrito' => 'not_in:0'
        ],[
            'id_departamento.not_in' => 'Debe seleccionar departamento.',
            'id_provincia.not_in' => 'Debe seleccionar provincia.',
            'id_distrito.not_in' => 'Debe seleccionar distrito.'
        ]);

        DomicilioUsersP::where('id_postulante',$id)->delete();
        DomicilioUsersP::create([
            'id_postulante' => $id,
            'id_distrito' => $request->id_distrito,
            'lat' => $request->coordsltd,
            'lng' => $request->coordslng,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function eval_rrhh_reg($id)
    {
        $get_id = Postulante::from('postulante AS po')->select('pu.id_area','po.estado_postulacion')
                ->join('puesto AS pu','pu.id_puesto','=','po.id_puesto')
                ->where('id_postulante',$id)->first();
        $get_eval_rrhh = EvalRrhhPostulante::from('eval_rrhh_postulante AS er')->select('er.*',
                        DB::raw("CASE WHEN SUBSTRING(er.eval_sicologica,1,5)='https' 
                        THEN er.eval_sicologica 
                        ELSE CONCAT('https://grupolanumero1.com.pe/intranet/',er.eval_sicologica) END AS 
                        eval_sicologica"))
                        ->where('er.id_postulante',$id)
                        ->orderBy('er.id_eval_rrhh_postulante','DESC')->first();
        return view('rrhh.postulante.registro.perfil.evaluacion_rrhh', compact(
            'get_id',
            'get_eval_rrhh'
        ));
    }

    public function update_eval_rrhh_reg(Request $request, $id)
    {
        $get_postulante = Postulante::from('postulante AS po')->select('pu.id_area',
                        'po.estado_postulacion')
                        ->join('puesto AS pu','pu.id_puesto','=','po.id_puesto')
                        ->where('id_postulante',$id)->first();

        if($get_postulante->id_area=="14" || $get_postulante->id_area=="44"){
            $request->validate([
                'resultado_rrhh' => 'gt:0'
            ],[
                'resultado_rrhh.gt' => 'Debe seleccionar resultado.'
            ]);
        }else{
            $request->validate([
                'resultado_rrhh' => 'gt:0',
                'eval_sicologica' => 'required'
            ],[
                'resultado_rrhh.gt' => 'Debe seleccionar resultado.',
                'eval_sicologica.required' => 'Debe adjuntar evaluación psicológica.'
            ]);
        }

        $list_eval_rrhh = EvalRrhhPostulante::where('id_postulante',$id)->get();
        foreach($list_eval_rrhh as $list){
            if($list->eval_sicologica!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $file_to_delete = "POSTULANTE/EVALUACION_PSICOLOGICA/".basename($list->eval_sicologica);
                    ftp_delete($con_id, $file_to_delete);
                }
            }
        }
        EvalRrhhPostulante::where('id_postulante',$id)->delete();

        $archivo = NULL;
        if(isset($_FILES["eval_sicologica"]["name"]) && $_FILES["eval_sicologica"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $path = $_FILES["eval_sicologica"]["name"];
                $source_file = $_FILES['eval_sicologica']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Errhh_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"POSTULANTE/EVALUACION_PSICOLOGICA/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/POSTULANTE/EVALUACION_PSICOLOGICA/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        EvalRrhhPostulante::create([
            'id_postulante' => $id,
            'resultado' => $request->resultado_rrhh,
            'eval_sicologica' => $archivo,
            'observaciones' => $request->observaciones_rrhh,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        Postulante::findOrFail($id)->update([
            'estado_postulacion' => $request->resultado_rrhh,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($request->observaciones_rrhh!=""){
            HistoricoPostulante::create([
                'id_postulante' => $id,
                'observacion' => $request->observaciones_rrhh,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }
    
    public function update_evaluacion_psicologica_reg(Request $request, $id)
    {
        $request->validate([
            'eval_sicologica' => 'required'
        ],[
            'eval_sicologica.required' => 'Debe adjuntar evaluación psicológica.'
        ]);

        $get_id = EvalRrhhPostulante::where('id_postulante',$id)
                ->orderBy('id_eval_rrhh_postulante','DESC')->first();

        $archivo = $get_id->eval_sicologica;
        if($_FILES["eval_sicologica"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if($get_id->eval_sicologica!=""){
                    ftp_delete($con_id, "POSTULANTE/EVALUACION_PSICOLOGICA/".basename($get_id->eval_sicologica));
                }

                $path = $_FILES["eval_sicologica"]["name"];
                $source_file = $_FILES['eval_sicologica']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Errhh_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"POSTULANTE/EVALUACION_PSICOLOGICA/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/POSTULANTE/EVALUACION_PSICOLOGICA/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        EvalRrhhPostulante::findOrFail($get_id->id_eval_rrhh_postulante)->update([
            'eval_sicologica' => $archivo,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function eval_jefe_directo_reg($id)
    {
        $get_id = Postulante::from('postulante AS po')->select('pu.id_area','po.estado_postulacion')
                ->join('puesto AS pu','pu.id_puesto','=','po.id_puesto')
                ->where('id_postulante',$id)->first();
        $get_eval_jd = EvalJefeDirecto::from('eval_jefe_directo AS ej')->select('ej.*',
                        DB::raw("CASE WHEN SUBSTRING(ej.eval_sicologica,1,5)='https' 
                        THEN ej.eval_sicologica 
                        ELSE CONCAT('https://grupolanumero1.com.pe/intranet/',ej.eval_sicologica) END AS 
                        eval_sicologica"))
                        ->where('ej.id_postulante',$id)
                        ->orderBy('ej.id_eval_jefe_directo','DESC')->first();
        return view('rrhh.postulante.registro.perfil.evaluacion_jefe_directo', compact(
            'get_id',
            'get_eval_jd'
        ));
    }

    public function update_eval_jefe_directo_reg(Request $request, $id)
    {
        $get_postulante = Postulante::from('postulante AS po')->select('pu.id_area',
                        'po.estado_postulacion')
                        ->join('puesto AS pu','pu.id_puesto','=','po.id_puesto')
                        ->where('id_postulante',$id)->first();

        if($get_postulante->id_area=="14" || $get_postulante->id_area=="44"){
            $request->validate([
                'resultado_jd' => 'gt:0',
                'eval_sicologica' => 'required'
            ],[
                'resultado_jd.gt' => 'Debe seleccionar resultado.',
                'eval_sicologica.required' => 'Debe adjuntar evaluación psicológica.'
            ]);
        }else{
            $request->validate([
                'resultado_jd' => 'gt:0'
            ],[
                'resultado_jd.gt' => 'Debe seleccionar resultado.'
            ]);
        }

        $list_eval_jd = EvalJefeDirecto::where('id_postulante',$id)->get();
        foreach($list_eval_jd as $list){
            if($list->eval_sicologica!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $file_to_delete = "POSTULANTE/EVALUACION_JEFE_DIRECTO/".basename($list->eval_sicologica);
                    ftp_delete($con_id, $file_to_delete);
                }
            }
        }
        EvalJefeDirecto::where('id_postulante',$id)->delete();

        $archivo = NULL;
        if(isset($_FILES["eval_sicologica"]["name"]) && $_FILES["eval_sicologica"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $path = $_FILES["eval_sicologica"]["name"];
                $source_file = $_FILES['eval_sicologica']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Ejd_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"POSTULANTE/EVALUACION_JEFE_DIRECTO/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/POSTULANTE/EVALUACION_JEFE_DIRECTO/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        EvalJefeDirecto::create([
            'id_postulante' => $id,
            'resultado' => $request->resultado_jd,
            'eval_sicologica' => $archivo,
            'observaciones' => $request->observaciones_jd,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        Postulante::findOrFail($id)->update([
            'estado_postulacion' => $request->resultado_jd,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($request->observaciones_jd!=""){
            HistoricoPostulante::create([
                'id_postulante' => $id,
                'observacion' => $request->observaciones_jd,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }

        if($request->resultado_jd=="2"){
            $get_id = Postulante::from('postulante AS po')
                    ->select('po.flag_email',DB::raw("CONCAT(po.postulante_nombres,' ',
                    po.postulante_apater,' ',po.postulante_amater) AS nom_postulante"),
                    'td.cod_tipo_documento','po.num_doc','po.postulante_nombres',
                    'po.postulante_apater','po.postulante_amater','ub.cod_ubi','ge.nom_gerencia',
                    'sg.nom_sub_gerencia','ar.nom_area','pu.nom_puesto')
                    ->join('tipo_documento AS td','td.id_tipo_documento','=','po.id_tipo_documento')
                    ->join('ubicacion AS ub','ub.id_ubicacion','=','po.id_centro_labor')
                    ->join('puesto AS pu','pu.id_puesto','=','po.id_puesto')
                    ->join('area AS ar','ar.id_area','=','pu.id_area')
                    ->join('sub_gerencia AS sg','sg.id_sub_gerencia','=','ar.id_departamento')
                    ->join('gerencia AS ge','ge.id_gerencia','=','sg.id_gerencia')
                    ->where('id_postulante',$id)->first();

            if($get_id->flag_email!="1"){
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       =  'mail.lanumero1.com.pe';
                    $mail->SMTPAuth   =  true;
                    $mail->Username   =  'intranet@lanumero1.com.pe';
                    $mail->Password   =  'lanumero1$1';
                    $mail->SMTPSecure =  'tls';
                    $mail->Port     =  587; 
                    $mail->setFrom('intranet@lanumero1.com.pe','Intranet La Número 1');
        
                    $mail->addAddress('rrhh@lanumero1.com.pe');
                    //$mail->addAddress('dpalomino@lanumero1.com.pe');
        
                    $mail->isHTML(true);
        
                    $mail->Subject = "Registro de postulante - ".$get_id->nom_postulante;
                
                    $mail->Body = "<FONT SIZE=3>¡Hola!<br><br>
                                        Se ha registrado el siguiente postulante:<br><br>
                                        ".$get_id->cod_tipo_documento.": ".$get_id->num_doc."<br>
                                        Nombres: ".$get_id->postulante_nombres."<br>
                                        Apellido paterno: ".$get_id->postulante_apater."<br> 
                                        Apellido materno: ".$get_id->postulante_amater."<br>
                                        Centro de Labores: ".$get_id->cod_ubi."<br>
                                        Gerencia: ".$get_id->nom_gerencia."<br>
                                        Sub-gerencia: ".$get_id->nom_sub_gerencia."<br>
                                        Área: ".$get_id->nom_area."<br>
                                        Puesto: ".$get_id->nom_puesto."<br>
                                </FONT SIZE>";
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
        
                    Postulante::findOrFail($id)->update([
                        'flag_email' => 1,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        }
    }

    public function verificacion_social_reg($id)
    {
        $get_id = Postulante::findOrFail($id);
        $get_vs = VerificacionSocial::from('verificacion_social AS vs')->select('vs.*',
                DB::raw("CASE WHEN SUBSTRING(vs.ver_social,1,5)='https' 
                THEN vs.ver_social ELSE 
                CONCAT('https://grupolanumero1.com.pe/intranet/',vs.ver_social) END AS ver_social"))
                ->where('vs.id_postulante',$id)->orderBy('vs.id_ver_social','DESC')->first();
        return view('rrhh.postulante.registro.perfil.verificacion_social', compact(
            'get_id',
            'get_vs'
        ));
    }

    public function update_verificacion_social_reg(Request $request, $id)
    {
        $request->validate([
            'resultado_vs' => 'gt:0',
            'ver_social' => 'required'
        ],[
            'resultado_vs.gt' => 'Debe seleccionar resultado.',
            'ver_social.required' => 'Debe adjuntar verificación social.'
        ]);

        $list_ver_social = VerificacionSocial::where('id_postulante',$id)->get();
        foreach($list_ver_social as $list){
            if($list->ver_social!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $file_to_delete = "POSTULANTE/VERIFICACION_SOCIAL/".basename($list->ver_social);
                    ftp_delete($con_id, $file_to_delete);
                }
            }
        }
        VerificacionSocial::where('id_postulante',$id)->delete();

        $archivo = NULL;
        if($_FILES["ver_social"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $path = $_FILES["ver_social"]["name"];
                $source_file = $_FILES['ver_social']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Vs_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"POSTULANTE/VERIFICACION_SOCIAL/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/POSTULANTE/VERIFICACION_SOCIAL/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        VerificacionSocial::create([
            'id_postulante' => $id,
            'resultado' => $request->resultado_vs,
            'ver_social' => $archivo,
            'observaciones' => $request->observaciones_vs,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        Postulante::findOrFail($id)->update([
            'estado_postulacion' => $request->resultado_vs,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($request->observaciones_vs!=""){
            HistoricoPostulante::create([
                'id_postulante' => $id,
                'observacion' => $request->observaciones_vs,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function update_ver_social_reg(Request $request, $id)
    {
        $request->validate([
            'ver_social' => 'required'
        ],[
            'ver_social.required' => 'Debe adjuntar verificación social.'
        ]);

        $get_id = VerificacionSocial::where('id_postulante',$id)
                ->orderBy('id_ver_social','DESC')->first();

        $archivo = $get_id->ver_social;
        if($_FILES["ver_social"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if($get_id->ver_social!=""){
                    ftp_delete($con_id, "POSTULANTE/VERIFICACION_SOCIAL/".basename($get_id->ver_social));
                }

                $path = $_FILES["ver_social"]["name"];
                $source_file = $_FILES['ver_social']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Vs_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"POSTULANTE/VERIFICACION_SOCIAL/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/POSTULANTE/VERIFICACION_SOCIAL/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        VerificacionSocial::findOrFail($get_id->id_ver_social)->update([
            'ver_social' => $archivo,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function resultado_final_reg($id)
    {
        $get_id = Postulante::findOrFail($id);
        return view('rrhh.postulante.registro.perfil.resultado_final', compact(
            'get_id'
        ));
    }

    public function update_resultado_final_reg(Request $request, $id)
    {
        $request->validate([
            'resultado_final' => 'gt:0'
        ],[
            'resultado_final.gt' => 'Debe seleccionar resultado.'
        ]);

        $get_id = Postulante::findOrFail($id);

        if($request->resultado_final=="10"){
            $valida = Usuario::where('num_doc',$get_id->num_doc)->whereIn('estado',[1,3,4])->count();

            if($valida>0){
                echo "2¡El postulante ya fue seleccionado!";
            }else{
                $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
                $longitud_cadena = strlen($cadena);
                $password = "";
                $longitud_pass = 6;

                for($i=1 ; $i<=$longitud_pass ; $i++){
                    $pos = rand(0,$longitud_cadena-1);
                    $password .= substr($cadena,$pos,1);
                }
        
                $usuario_password = password_hash($password, PASSWORD_DEFAULT);            

                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       =  'mail.lanumero1.com.pe';
                    $mail->SMTPAuth   =  true;
                    $mail->Username   =  'intranet@lanumero1.com.pe';
                    $mail->Password   =  'lanumero1$1';
                    $mail->SMTPSecure =  'tls';
                    $mail->Port     =  587; 
                    $mail->setFrom('intranet@lanumero1.com.pe','Intranet La Número 1');

                    $mail->addAddress($get_id->emailp);
                    //$mail->addAddress('dpalomino@lanumero1.com.pe');

                    $mail->isHTML(true);
        
                    $mail->Subject = "Bienvenido a Nuestra Familia";
                
                    $mail->Body = "<FONT SIZE=3><h1>Hola, ".$get_id->postulante_nombres." ".
                                        $get_id->postulante_apater."</h1><br>
                                        Te damos la bienvenida a la gran familia La Número 1.<br>
                                        A continuación deberás colocar tu nueva contraseña 
                                        para ingresar a nuestro portal: $password <br>
                                        Link del portal: https://demo.grupolanumero1.com.pe/ <br>
                                        Gracias.<br>
                                        Atte. Grupo La Número 1<br>
                                </FONT SIZE>";
                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                    Postulante::findOrFail($id)->update([
                        'estado_postulacion' => $request->resultado_final,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                    
                    HistoricoPostulante::create([
                        'id_postulante' => $id,
                        'observacion' => 'POSTULANTE SELECCIONADO',
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);

                    $usuario = Usuario::create([
                        'nuevo' => 1,
                        'id_centro_labor' => $get_id->id_centro_labor,
                        'id_ubicacion' => $get_id->id_centro_labor,
                        'usuario_nombres' => $get_id->postulante_nombres,
                        'usuario_apater' => $get_id->postulante_apater,
                        'usuario_amater' => $get_id->postulante_amater,
                        'id_puesto' => $get_id->id_puesto,
                        'id_modalidad_laboral' => 1,
                        'usuario_codigo' => $get_id->postulante_codigo,
                        'usuario_password' => $usuario_password,
                        'password_desencriptado' => $password,
                        'id_nacionalidad' => $get_id->id_nacionalidad,
                        'id_tipo_documento' => $get_id->id_tipo_documento,
                        'num_doc' => $get_id->num_doc,
                        'id_genero' => $get_id->id_genero,
                        'fec_nac' => $get_id->fec_nac,
                        'id_estado_civil' => $get_id->id_estado_civil,
                        'usuario_email' => $get_id->emailp,
                        'num_celp' => $get_id->num_celp,
                        'num_fijop' => $get_id->num_fijop,
                        'id_nivel' => 6,
                        'induccion' => 0,
                        'desvinculacion' => 0,
                        'acceso' => 0,
                        'foto' => $get_id->foto,
                        'urladm' => 1,
                        'estado' => 4,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);

                    if($get_id->foto!=""){
                        $ftp_server = "lanumerounocloud.com";
                        $ftp_usuario = "intranet@lanumerounocloud.com";
                        $ftp_pass = "Intranet2022@";
                        $con_id = ftp_connect($ftp_server);
                        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                        if ($con_id && $lr) {
                            // Rutas del archivo en el servidor FTP
                            $source_file = "POSTULANTE/FOTO/".basename($get_id->foto);
                            $destination_file = "PERFIL/DOCUMENTACION/FOTO_PERFIL/Foto_".$usuario->id_usuario."_".date('YmdHis').".".pathinfo($get_id->foto, PATHINFO_EXTENSION);
                            // Crear archivo temporal
                            $temp_file = storage_path("app/temp/archivo_temporal_".date('YmdHis').".".pathinfo($get_id->foto, PATHINFO_EXTENSION));
                            // Guardar archivo temporal en nuevo archivo
                            ftp_get($con_id, $temp_file, $source_file, FTP_BINARY);
                            // Guardar archivo en la nueva ruta
                            ftp_put($con_id, $destination_file, $temp_file, FTP_BINARY);
                            // Borrar archivo temporal
                            unlink($temp_file);
                        }
                    }

                    UsersHistoricoPuesto::create([
                        'id_usuario' => $usuario->id_usuario,
                        'id_puesto' => $usuario->id_puesto,
                        'id_centro_labor' => $usuario->id_centro_labor,
                        'fec_inicio' => now(),
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);

                    UsersHistoricoCentroLabores::create([
                        'id_usuario' => $usuario->id_usuario,
                        'id_ubicacion' => $usuario->id_centro_labor,
                        'fec_inicio' => now(),
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);

                    UsersHistoricoModalidad::create([
                        'id_usuario' => $usuario->id_usuario,
                        'id_modalidad_laboral' => 1,
                        'fec_inicio' => now(),
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);

                    $valida = Organigrama::where('id_puesto',$usuario->id_puesto)
                            ->where('id_centro_labor',$usuario->id_centro_labor)
                            ->where('id_usuario',0)->first();

                    if(isset($valida->id)){
                        Organigrama::findOrFail($valida->id)->update([
                            'id_usuario' => $usuario->id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }else{
                        Organigrama::create([
                            'id_puesto' => $usuario->id_puesto,
                            'id_centro_labor' => $usuario->id_centro_labor,
                            'id_usuario' => $usuario->id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }

                    $valida = DomicilioUsersP::where('id_postulante',$id)->first();

                    if(isset($valida->id_domicilio_usersp)){
                        DomicilioUsers::create([
                            'id_usuario' => $usuario->id_usuario,
                            'id_distrito' => $valida->id_distrito,
                            'lat' => $valida->lat,
                            'lng' => $valida->lng,
                            'estado' => 1,
                            'fec_reg' => now(),
                            'user_reg' => session('usuario')->id_usuario,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario
                        ]);
                    }

                    echo "1¡Haga clic en el botón!";
                }catch(Exception $e) {
                    echo "3Hubo un error al enviar el correo: Debe ingresar un correo para el postulante!";
                }
            }
        }else{
            Postulante::findOrFail($id)->update([
                'estado_postulacion' => $request->resultado_final,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            HistoricoPostulante::create([
                'id_postulante' => $id,
                'observacion' => 'POSTULANTE NO SELECCIONADO',
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            echo "1¡Haga clic en el botón!";
        }
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
}

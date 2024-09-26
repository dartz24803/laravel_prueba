<?php

namespace App\Http\Controllers;

use App\Models\Accesorio;
use App\Models\Area;
use App\Models\Banco;
use App\Models\Base;
use App\Models\ComisionAFP;
use App\Models\Gerencia;
use App\Models\Organigrama;
use App\Models\Usuario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\Config;
use App\Models\DatacorpAccesos;
use App\Models\DocumentacionUsuario;
use App\Models\Empresas;
use App\Models\EstadoCivil;
use App\Models\GradoInstruccion;
use App\Models\GrupoSanguineo;
use App\Models\HistoricoEstadoColaborador;
use App\Models\Horario;
use App\Models\HorarioDia;
use App\Models\Idioma;
use App\Models\ModalidadLaboral;
use App\Models\Model_Perfil;
use App\Models\PaginasWebAccesos;
use App\Models\Parentesco;
use App\Models\ProgramaAccesos;
use App\Models\Puesto;
use App\Models\ReferenciaLaboral;
use App\Models\Regimen;
use App\Models\SituacionLaboral;
use App\Models\TipoContrato;
use App\Models\TipoDocumento;
use App\Models\TipoVia;
use App\Models\TipoVivienda;
use App\Models\ToleranciaHorario;
use App\Models\Turno;
use App\Models\UsersHistoricoCentroLabores;
use App\Models\HistoricoColaborador;
use App\Models\UsersHistoricoHorario;
use App\Models\UsersHistoricoModalidad;
use App\Models\UsersHistoricoPuesto;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;
use Datetime;
use Intervention\Image\ImageManagerStatic as Image;

class ColaboradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.colaborador.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_co()
    {
        $list_gerencia = Gerencia::where('estado', 1)->orderBy('nom_gerencia', 'ASC')->get();
        return view('rrhh.colaborador.colaborador.index', compact('list_gerencia'));
    }

    public function list_co(Request $request)
    {
        $list_colaborador = Organigrama::get_list_colaborador(['id_gerencia' => $request->id_gerencia]);
        return view('rrhh.colaborador.colaborador.lista', compact('list_colaborador'));
    }

    public function mail_co(Request $request)
    {
        $get_id = Usuario::findOrFail($request->id_usuario);

        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena = strlen($cadena);
        $password = "";
        $longitudPass = 6;

        for ($i = 1; $i <= $longitudPass; $i++) {
            $pos = rand(0, $longitudCadena - 1);
            $password .= substr($cadena, $pos, 1);
        }

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
            $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

            $mail->addAddress($get_id->usuario_email);

            $mail->isHTML(true);

            $mail->Subject = "Actualización de contraseña";

            $mail->Body =  "<h1> Hola, " . $get_id->usuario_nombres . " " . $get_id->usuario_apater . "</h1>
                            <p>Te damos la bienvenida a la gran familia La Número 1.</p>
                            <p>A continuación deberás colocar tu nueva contraseña para ingresar a nuestro
                            portal: $password</p>
                            <p>Gracias.<br>Atte. Grupo La Número 1</p>";
            $mail->CharSet = 'UTF-8';
            $mail->send();

            Usuario::findOrFail($request->id_usuario)->update([
                'verif_email' => 1,
                'acceso' => 0,
                'usuario_password' => password_hash($password, PASSWORD_DEFAULT),
                'password_desencriptado' => $password,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            echo 'Nombre y Apellidos ' . $get_id->usuario_nombres . ' ' . $get_id->usuario_apater . ' ' .
                $get_id->usuario_amater . '<br>Correo: ' . $get_id->usuario_email;
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function edit_co($id)
    {
        $get_id = Usuario::findOrFail($id);
        return view('rrhh.colaborador.colaborador.modal_editar', compact('get_id'));
    }

    public function update_co(Request $request, $id)
    {
        $request->validate([
            'usuario_codigoe' => 'required'
        ], [
            'usuario_codigoe.required' => 'Debe ingresar usuario.'
        ]);

        $valida = Usuario::where('usuario_codigo', $request->usuario_codigoe)->where('id_usuario', '!=', $id)->exists();

        if ($valida) {
            echo "error";
        } else {
            if ($request->usuario_passworde) {
                Usuario::findOrFail($id)->update([
                    'usuario_codigo' => $request->usuario_codigoe,
                    'usuario_password' => password_hash($request->usuario_passworde, PASSWORD_DEFAULT),
                    'password_desencriptado' => $request->usuario_passworde,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            } else {
                Usuario::findOrFail($id)->update([
                    'usuario_codigo' => $request->usuario_codigoe,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }
    }

    public function download_co($id)
    {
        $get_id = Usuario::findOrFail($id);

        // URL del archivo
        $url = $get_id->foto;

        // Crear un cliente Guzzle
        $client = new Client();

        // Realizar la solicitud GET para obtener el archivo
        $response = $client->get($url);

        // Obtener el contenido del archivo
        $content = $response->getBody()->getContents();

        // Obtener el nombre del archivo desde la URL
        $filename = basename($url);

        // Devolver el contenido del archivo en la respuesta
        return response($content, 200)
            ->header('Content-Type', $response->getHeaderLine('Content-Type'))
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /*public function excel_co($id_gerencia)
    {
        $list_colaborador = Organigrama::get_list_colaborador(['id_gerencia'=>$id_gerencia,'excel'=>1]);

        //$url = $this->Model_Corporacion->ruta_archivos();
        //$dato['url_archivo'] = $url[0]['url_config'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:BN1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:BN1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Colaborador');

        $sheet->setAutoFilter('A1:BN1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setWidth(25);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(18);
        $sheet->getColumnDimension('P')->setWidth(28);
        $sheet->getColumnDimension('Q')->setWidth(28);
        $sheet->getColumnDimension('R')->setWidth(28);
        $sheet->getColumnDimension('S')->setWidth(30);
        $sheet->getColumnDimension('T')->setWidth(25);
        $sheet->getColumnDimension('U')->setWidth(25);
        $sheet->getColumnDimension('V')->setWidth(25);
        $sheet->getColumnDimension('W')->setWidth(25);
        $sheet->getColumnDimension('X')->setWidth(20);
        $sheet->getColumnDimension('Y')->setWidth(20);
        $sheet->getColumnDimension('Z')->setWidth(30);
        $sheet->getColumnDimension('AA')->setWidth(20);
        $sheet->getColumnDimension('AB')->setWidth(20);
        $sheet->getColumnDimension('AC')->setWidth(20);
        $sheet->getColumnDimension('AD')->setWidth(25);
        $sheet->getColumnDimension('AE')->setWidth(20);
        $sheet->getColumnDimension('AF')->setWidth(20);
        $sheet->getColumnDimension('AG')->setWidth(20);
        $sheet->getColumnDimension('AH')->setWidth(20);
        $sheet->getColumnDimension('AI')->setWidth(20);
        $sheet->getColumnDimension('AJ')->setWidth(60);
        $sheet->getColumnDimension('AK')->setWidth(120);
        $sheet->getColumnDimension('AL')->setWidth(30);
        $sheet->getColumnDimension('AM')->setWidth(25);
        $sheet->getColumnDimension('AN')->setWidth(30);
        $sheet->getColumnDimension('AO')->setWidth(28);
        $sheet->getColumnDimension('AP')->setWidth(28);
        $sheet->getColumnDimension('AQ')->setWidth(28);
        $sheet->getColumnDimension('AR')->setWidth(60);
        $sheet->getColumnDimension('AS')->setWidth(20);
        $sheet->getColumnDimension('AT')->setWidth(20);
        $sheet->getColumnDimension('AU')->setWidth(28);
        $sheet->getColumnDimension('AV')->setWidth(20);
        $sheet->getColumnDimension('AW')->setWidth(20);
        $sheet->getColumnDimension('AX')->setWidth(18);
        $sheet->getColumnDimension('AY')->setWidth(18);
        $sheet->getColumnDimension('AZ')->setWidth(18);
        $sheet->getColumnDimension('BA')->setWidth(18);
        $sheet->getColumnDimension('BB')->setWidth(18);
        $sheet->getColumnDimension('BC')->setWidth(18);
        $sheet->getColumnDimension('BD')->setWidth(18);
        $sheet->getColumnDimension('BE')->setWidth(18);
        $sheet->getColumnDimension('BF')->setWidth(18);
        $sheet->getColumnDimension('BG')->setWidth(18);
        $sheet->getColumnDimension('BH')->setWidth(18);
        $sheet->getColumnDimension('BI')->setWidth(18);
        $sheet->getColumnDimension('BJ')->setWidth(18);
        $sheet->getColumnDimension('BK')->setWidth(18);
        $sheet->getColumnDimension('BL')->setWidth(18);
        $sheet->getColumnDimension('BM')->setWidth(18);
        $sheet->getColumnDimension('BN')->setWidth(18);

        $sheet->getStyle('A1:BN1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:BN1")->getFill()
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

        $sheet->getStyle("A1:BN1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'ESTADO');
        $sheet->setCellValue('B1', 'FECHA DE PLANILLA');
        $sheet->setCellValue('C1', 'CENTRO DE LABORES');
        $sheet->setCellValue('D1', 'APELLIDO PATERNO');
        $sheet->setCellValue('E1', 'APELLIDO MATERNO');
        $sheet->setCellValue('F1', 'NOMBRES');
        $sheet->setCellValue('G1', 'CARGO');
        $sheet->setCellValue('H1', 'PUESTO');
        $sheet->setCellValue('I1', 'ÁREA');
        $sheet->setCellValue('J1', 'DEPARTAMENTO');
        $sheet->setCellValue('K1', 'GERENCIA');
        $sheet->setCellValue('L1', 'TIPO DOCUMENTO');
        $sheet->setCellValue('M1', 'NUM. DOCUMENTO');
        $sheet->setCellValue('N1', 'DOCUMENTO');
        $sheet->setCellValue('O1', 'GENERO');
        $sheet->setCellValue('P1', 'FECHA DE NACIMIENTO');
        $sheet->setCellValue('Q1', 'DÍA DE NACIMIENTO');
        $sheet->setCellValue('R1', 'MES DE NACIMIENTO');
        $sheet->setCellValue('S1', 'CORREO ELECTRÓNICO');
        $sheet->setCellValue('T1', 'TELÉFONO CELULAR');
        $sheet->setCellValue('U1', 'DEPARTAMENTO');
        $sheet->setCellValue('V1', 'PROVINCIA');
        $sheet->setCellValue('W1', 'DISTRITO');
        $sheet->setCellValue('X1', 'TIPO VÍA');
        $sheet->setCellValue('Y1', 'NOMBRE VÍA');
        $sheet->setCellValue('Z1', 'NÚMERO VÍA');
        $sheet->setCellValue('AA1', 'KM');
        $sheet->setCellValue('AB1', 'MZ');
        $sheet->setCellValue('AC1', 'INTERIOR');
        $sheet->setCellValue('AD1', 'N° DEPARTAMENTO');
        $sheet->setCellValue('AE1', 'LOTE');
        $sheet->setCellValue('AF1', 'PISO');
        $sheet->setCellValue('AG1', 'TIPO ZONA');
        $sheet->setCellValue('AH1', 'NOMBRE ZONA');
        $sheet->setCellValue('AI1', 'TIPO VIVIENDA');
        $sheet->setCellValue('AJ1', 'REFERENCIA DOMICILIO');
        $sheet->setCellValue('AK1', 'DIRECCIÓN COMPLETA');
        $sheet->setCellValue('AL1', 'SISTEMA DE PENSIONES');
        $sheet->setCellValue('AM1', 'BANCO');
        $sheet->setCellValue('AN1', 'NÚMERO DE CUENTA');
        $sheet->setCellValue('AO1', 'ANTIGUEDAD EN AÑOS');
        $sheet->setCellValue('AP1', 'ANTIGUEDAD EN MESES');
        $sheet->setCellValue('AQ1', 'SITUACIÓN LABORAL');
        $sheet->setCellValue('AR1', 'RAZON SOCIAL');
        $sheet->setCellValue('AS1', 'HIJOS');
        $sheet->setCellValue('AT1', 'PROGRESO');
        $sheet->setCellValue('AU1', 'CARNET VACUNACION');
        $sheet->setCellValue('AV1', 'HORARIO');
        $sheet->setCellValue('AW1', 'MODALIDAD');
        $sheet->setCellValue('AX1', 'T. POLO');
        $sheet->setCellValue('AY1', 'T. CAMISA');
        $sheet->setCellValue('AZ1', 'T. PANTALÓN');
        $sheet->setCellValue('BA1', 'T. ZAPATO');
        $sheet->setCellValue('BB1', 'T. SANGRE');
        $sheet->setCellValue('BC1', 'GENERACIÓN');
        $sheet->setCellValue('BD1', 'FECHA CESE');
        $sheet->setCellValue('BE1', 'PLATO POSTRE');
        $sheet->setCellValue('BF1', 'GOLOSINAS');
        $sheet->setCellValue('BG1', 'PASATIEMPOS');
        $sheet->setCellValue('BH1', 'ARTISTAS');
        $sheet->setCellValue('BI1', 'GENERO MUSICAL');
        $sheet->setCellValue('BJ1', 'PELICULAS');
        $sheet->setCellValue('BK1', 'COLORES');
        $sheet->setCellValue('BL1', 'REDES SOCIALES');
        $sheet->setCellValue('BM1', 'DEPORTE');
        $sheet->setCellValue('BN1', 'MASCOTA');

        $contador=1;

        foreach($list_colaborador as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:BD{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("S{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("U{$contador}:Y{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AG{$contador}:AK{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AM{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AQ{$contador}:AR{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("AV{$contador}:AW{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:BN{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:BN{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("AN{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
            $sheet->getStyle("AT{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);

            $sheet->setCellValue("A{$contador}", $list->nom_estado_usuario);
            if($list->ini_funciones!="" && $list->ini_funciones!="0000-00-00"){
                $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list->ini_funciones));
                $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("C{$contador}", $list->centro_labores);
            $sheet->setCellValue("D{$contador}", $list->usuario_apater);
            $sheet->setCellValue("E{$contador}", $list->usuario_amater);
            $sheet->setCellValue("F{$contador}", $list->usuario_nombres);
            $sheet->setCellValue("G{$contador}", $list->nom_cargo);
            $sheet->setCellValue("H{$contador}", $list->nom_puesto);
            $sheet->setCellValue("I{$contador}", $list->nom_area);
            $sheet->setCellValue("J{$contador}", $list->nom_sub_gerencia);
            $sheet->setCellValue("K{$contador}", $list->nom_gerencia);
            $sheet->setCellValue("L{$contador}", $list->cod_tipo_documento);
            $sheet->setCellValue("M{$contador}", $list->num_doc);
            $sheet->setCellValue("N{$contador}", $list->num_doc);
            $sheet->getCell("N{$contador}")->getHyperlink()->setUrl($dato['url_archivo'].$list->dni_doc);
            $sheet->setCellValue("O{$contador}", $list->nom_genero);
            if($list->fec_nac!="" && $list->fec_nac!="0000-00-00"){
                $sheet->setCellValue("P{$contador}", Date::PHPToExcel($list->fec_nac));
                $sheet->getStyle("P{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("Q{$contador}", $list->dia_nac);
            $sheet->setCellValue("R{$contador}", $list->mes_nac);
            $sheet->setCellValue("S{$contador}", $list->usuario_email);
            $sheet->setCellValue("T{$contador}", $list->num_celp);
            $sheet->setCellValue("U{$contador}", $list->nombre_departamento);
            $sheet->setCellValue("V{$contador}", $list->nombre_provincia);
            $sheet->setCellValue("W{$contador}", $list->nombre_distrito);
            $sheet->setCellValue("X{$contador}", $list->nom_tipo_via);
            $sheet->setCellValue("Y{$contador}", $list->nom_via);
            $sheet->setCellValue("Z{$contador}", $list->num_via);
            $sheet->setCellValue("AA{$contador}", $list->kilometro);
            $sheet->setCellValue("AB{$contador}", $list->manzana);
            $sheet->setCellValue("AC{$contador}", $list->interior);
            $sheet->setCellValue("AD{$contador}", $list->departamento);
            $sheet->setCellValue("AE{$contador}", $list->lote);
            $sheet->setCellValue("AF{$contador}", $list->piso);
            $sheet->setCellValue("AG{$contador}", $list->nom_tipo_zona);
            $sheet->setCellValue("AH{$contador}", $list->nom_zona);
            $sheet->setCellValue("AI{$contador}", $list->nom_tipo_vivienda);
            $sheet->setCellValue("AJ{$contador}", $list->referencia_domicilio);
            $sheet->setCellValue("AK{$contador}", $list->direccion_completa);
            $sheet->setCellValue("AL{$contador}", $list->cod_sistema_pensionario);
            $sheet->setCellValue("AM{$contador}", $list->nom_banco);
            $sheet->setCellValue("AN{$contador}", $list->num_cuenta_bancaria);
            $sheet->setCellValue("AO{$contador}", $list->anio_antiguedad);
            $sheet->setCellValue("AP{$contador}", $list->mes_antiguedad);
            $sheet->setCellValue("AQ{$contador}", $list->nom_situacion_laboral);
            $sheet->setCellValue("AR{$contador}", $list->nom_empresa);
            $sheet->setCellValue("AS{$contador}", $list->hijos);
            $sheet->setCellValue("AT{$contador}", round((($list->progreso)/21)*1,4));
            $sheet->setCellValue("AU{$contador}", $list->num_doc);
            if($list->covid!="0"){
                $sheet->getCell("AU{$contador}")->getHyperlink()->setUrl($dato['url_archivo'].$list->cert_vacu_covid);
            }
            $sheet->setCellValue("AV{$contador}", $list->horariof);
            $sheet->setCellValue("AW{$contador}", $list->modalidadf);
            $sheet->setCellValue("AX{$contador}", $list->polo);
            $sheet->setCellValue("AY{$contador}", $list->camisa);
            $sheet->setCellValue("AZ{$contador}", $list->pantalon);
            $sheet->setCellValue("BA{$contador}", $list->zapato);
            $sheet->setCellValue("BB{$contador}", $list->nom_grupo_sanguineo);
            $sheet->setCellValue("BC{$contador}", $list->generacion);
            if($list->fin_funciones!="" && $list->fin_funciones!="0000-00-00"){
                $sheet->setCellValue("BD{$contador}", Date::PHPToExcel($list->fin_funciones));
                $sheet->getStyle("BD{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("BE{$contador}", $list->plato_postre);
            $sheet->setCellValue("BF{$contador}", $list->galletas_golosinas);
            $sheet->setCellValue("BG{$contador}", $list->ocio_pasatiempos);
            $sheet->setCellValue("BH{$contador}", $list->artistas_banda);
            $sheet->setCellValue("BI{$contador}", $list->genero_musical);
            $sheet->setCellValue("BJ{$contador}", $list->pelicula_serie);
            $sheet->setCellValue("BK{$contador}", $list->colores_favorito);
            $sheet->setCellValue("BL{$contador}", $list->redes_sociales);
            $sheet->setCellValue("BM{$contador}", $list->deporte_favorito);
            $sheet->setCellValue("BN{$contador}", $list->mascota);
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Colaborador';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }*/

    public function index_ce()
    {
        $list_gerencia = Gerencia::where('estado', 1)->orderBy('nom_gerencia', 'ASC')->get();
        return view('rrhh.colaborador.cesado.index', compact('list_gerencia'));
    }

    public function list_ce(Request $request)
    {
        $list_cesado = Usuario::get_list_cesado(['id_gerencia' => $request->id_gerencia]);
        return view('rrhh.colaborador.cesado.lista', compact('list_cesado'));
    }

    public function edit_ce($id)
    {
        $get_id = Usuario::findOrFail($id);
        return view('rrhh.colaborador.cesado.modal_editar', compact('get_id'));
    }

    protected $Model_Perfil;

    public function Mi_Perfil($id_usuario=null){

            if(isset($id_usuario) && $id_usuario > 0){
                $id_usuario= $id_usuario;
            }else{
                $id_usuario= session('usuario')->id_usuario;
            }
            $this->Model_Perfil = new Model_Perfil();
            $dato['usuario'] = Usuario::get_list_usuario($id_usuario);
            $dato['domicilio'] = $this->Model_Perfil->get_id_domicilio_users($id_usuario);

            $dato['datosp_porcentaje'] = $this->Model_Perfil->datosp_porcentaje($id_usuario);
            $dato['gustos_pref'] = $this->Model_Perfil->get_id_gustosp($id_usuario);
            $dato['domiciliou_porcentaje'] = $this->Model_Perfil->domiciliou_porcentaje($id_usuario);
            $dato['referenciaf_porcentaje'] = $this->Model_Perfil->referenciaf_porcentaje($id_usuario);
            $dato['datoshu_porcentaje'] = $this->Model_Perfil->datoshu_porcentaje($id_usuario);
            $dato['contactoeu_porcentaje'] = $this->Model_Perfil->contactoeu_porcentaje($id_usuario);
            $dato['estudiosgu_porcentaje'] = $this->Model_Perfil->estudiosgu_porcentaje($id_usuario);
            $dato['oficceu_porcentaje'] = $this->Model_Perfil->oficceu_porcentaje($id_usuario);
            $dato['idiomau_porcentaje'] = $this->Model_Perfil->idiomau_porcentaje($id_usuario);
            $dato['cursocu_porcentaje'] = $this->Model_Perfil->cursocu_porcentaje($id_usuario);

            $dato['experiencialaboralu_porcentaje'] = $this->Model_Perfil->experiencialaboralu_porcentaje($id_usuario);
            $dato['enfermedadesu_porcentaje'] = $this->Model_Perfil->enfermedadesu_porcentaje($id_usuario);
            $dato['gestacionu_porcentaje'] = $this->Model_Perfil->gestacionu_porcentaje($id_usuario);
            $dato['alergiasu_porcentaje'] = $this->Model_Perfil->alergiasu_porcentaje($id_usuario);
            $dato['otrosu_porcentaje'] = $this->Model_Perfil->otrosu_porcentaje($id_usuario);
            $dato['referenciaconvocatoriau_porcentaje'] = $this->Model_Perfil->referenciaconvocatoriau_porcentaje($id_usuario);
            $dato['documentacionu_porcentaje'] = $this->Model_Perfil->documentarionu_porcentaje($id_usuario);
            $dato['ropau_porcentaje'] = $this->Model_Perfil->ropau_porcentaje($id_usuario);
            $dato['sist_pensu_porcentaje'] = $this->Model_Perfil->sist_pensu_porcentaje($id_usuario);
            $dato['cuentab_porcentaje'] = $this->Model_Perfil->cuentab_porcentaje($id_usuario);

            $dato['porcentaje'] = Usuario::perfil_porcentaje($id_usuario);
            if($dato['usuario'][0]['urladm']=="1"){
                $dato['get_foto'] = Config::where('descrip_config','Foto_Postulante')
                                ->where('estado', 1)
                                ->get();
            }else{
                $dato['get_foto'] = Config::where('descrip_config','Foto_Colaborador')
                                ->where('estado', 1)
                                ->get();
            }

        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        return view('rrhh.Perfil.miperfil', $dato);
    }

    public function Perfil($id_usuario=null){
            if(isset($id_usuario) && $id_usuario > 0){
                $id_usuario=$id_usuario;
            }
            else{
                $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
            }
            $this->Model_Perfil = new Model_Perfil();

            $dato['id_usuario']=$id_usuario;
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $id_gerencia = $dato['get_id'][0]['id_gerencia'];
            $id_area = $dato['get_id'][0]['id_area'];
            $id_puesto = $dato['get_id'][0]['id_puesto'];
            $id_departamento = $dato['get_id'][0]['id_departamento'];
            $id_provincia = $dato['get_id'][0]['id_provincia'];

            $dato['list_tipo_documento'] = TipoDocumento::get();
            $dato['list_situacion_laboral'] = SituacionLaboral::where('estado', 1)
                                        ->get();
            $dato['list_datos_planilla'] = $this->Model_Perfil->get_list_datoplanilla($id_usuario);
            $dato['list_accesos_datacorp'] = DatacorpAccesos::where('area', $id_area)
                                        ->where('puesto', $id_puesto)
                                        ->get();
            $dato['list_accesos_paginas_web'] = PaginasWebAccesos::where('area', $id_area)
                                        ->where('puesto', $id_puesto)
                                        ->get();
            $dato['list_accesos_programas'] = ProgramaAccesos::where('area', $id_area)
                                        ->where('puesto', $id_puesto)
                                        ->get();
            $dato['url'] = Config::where('descrip_config','Documentos_Perfil')
                ->where('estado', 1)
                ->get();
            $dato['list_estado_usuario'] = $this->Model_Perfil->get_list_estado_usuario();
            $dato['list_nacionalidad_perfil'] = $this->Model_Perfil->get_list_nacionalidad_perfil();
            $dato['list_genero'] = $this->Model_Perfil->get_list_genero();
            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            $dato['list_estado_civil'] = EstadoCivil::where('estado', 1)
                                    ->get();
            $dato['list_idiomas'] = Idioma::where('estado', 1)
                                ->get();
            $dato['list_nivel_instruccion'] = $this->Model_Perfil->get_list_nivel_instruccion();
            $dato['list_accesorio_polo'] = $this->Model_Perfil->get_list_accesorio_polo();
            $dato['list_accesorio_camisa'] = $this->Model_Perfil->get_list_accesorio_camisa();
            $dato['list_accesorio_pantalon'] = $this->Model_Perfil->get_list_accesorio_pantalon();
            $dato['list_accesorio_zapato'] = $this->Model_Perfil->get_list_accesorio_zapato();
            $dato['list_grado_instruccion'] = GradoInstruccion::where('estado', 1)
                                        ->get();
            $dato['list_banco'] = Banco::where('estado', 1)
                                ->get();
            $dato['list_referencia_laboral'] = ReferenciaLaboral::where('estado', 1)
                                        ->get();
            $dato['list_zona'] = Zona::where('estado', 1)
                                ->get();
            $dato['list_sistema_pensionario'] = DB::table('sistema_pensionario')
                                        ->where('estado', 1)
                                        ->get();
            $dato['list_afp'] = ComisionAFP::where('estado', 1)
                            ->get();
            $dato['list_grupo_sanguineo'] = GrupoSanguineo::where('estado', 1)
                                ->get();
            $dato['list_gerencia'] = $this->Model_Perfil->get_list_gerencia();
            $dato['list_area'] = $this->Model_Perfil->get_list_area($id_gerencia);
            $dato['list_puesto'] = $this->Model_Perfil->get_list_puesto($id_gerencia,$id_area);
            $dato['list_cargo'] = $this->Model_Perfil->get_list_cargo($id_gerencia, $id_area, $id_puesto);
            $dato['list_ubicacion_l'] = $this->Model_Perfil->get_list_ubicacion_l();
            $dato['list_empresa'] = Empresas::where('estado', 1)
                                ->get();
            $dato['list_modalidad_laboral'] = DB::table('modalidad_laboral')
                                    ->where('estado',1)
                                    ->get();
            /* Domicilio */
            $dato['list_dtipo_via'] = TipoVia::get();
            $dato['list_dtipo_vivienda'] = TipoVivienda::get();
            $dato['list_departamento'] = DB::table('departamento')
                                        ->where('estado', 1)
                                        ->get();
            $dato['list_provincia'] = DB::table('provincia')
                                        ->where('id_departamento', $id_departamento)
                                        ->where('estado', 1)
                                        ->get();
            $dato['list_distrito'] = DB::table('distrito')
                                        ->where('id_departamento', $id_departamento)
                                        ->where('id_provincia', $id_provincia)
                                        ->where('estado', 1)
                                        ->get();
            $dato['get_id_d'] = $this->Model_Perfil->get_id_domicilio_users($id_usuario);
            $dato['get_id_gp'] = $this->Model_Perfil->get_id_gustosp($id_usuario);
            $dato['get_id_c'] = $this->Model_Perfil->get_id_conoci_office($id_usuario);
            $dato['get_id_t'] = $this->Model_Perfil->get_id_ropa_usuario($id_usuario);
            $dato['list_parentesco'] = Parentesco::where('estado', 1)
                                        ->get();
            $dato['list_usuario'] = $this->Model_Perfil->get_list_usuario($id_usuario);
            $dato['list_referenciafu'] = $this->Model_Perfil->get_list_referenciafu($id_usuario);
            $dato['list_hijosu'] = $this->Model_Perfil->get_list_hijosu($id_usuario);
            $dato['list_contactoeu'] = $this->Model_Perfil->get_list_contactoeu($id_usuario);
            $dato['list_estudiosgu'] = $this->Model_Perfil->get_list_estudiosgu($id_usuario);
            $dato['listar_idiomas'] = $this->Model_Perfil->get_list_idiomasu($id_usuario);
            $dato['listar_cursosc'] = $this->Model_Perfil->get_list_cursoscu($id_usuario);
            $dato['get_id_cuentab'] = $this->Model_Perfil->get_id_cuentab($id_usuario);
            $dato['get_id_referenciac'] = $this->Model_Perfil->get_id_referenciac($id_usuario);
            $dato['get_id_gestacion'] = $this->Model_Perfil->get_id_gestacion($id_usuario);
            $dato['get_id_sist_pensu'] = $this->Model_Perfil->get_id_sist_pensu($id_usuario);
            $dato['get_id_otros'] = $this->Model_Perfil->get_id_otros($id_usuario);
            $dato['get_id_documentacion'] = $this->Model_Perfil->get_id_documentacion($id_usuario);
            $dato['list_enfermedadu'] = $this->Model_Perfil->get_list_enfermedadu($id_usuario);
            $dato['list_alergia'] = $this->Model_Perfil->get_list_alergia($id_usuario);
            $dato['list_experiencial'] = $this->Model_Perfil->get_list_experiencial($id_usuario);
            $dato['list_horario'] = $this->Model_Perfil->get_list_horario();

            //REPORTE BI CON ID
            $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
            //NOTIFICACIONES
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();

            if($dato['get_id'][0]['urladm']=="1"){
                $dato['get_foto'] = Config::where('descrip_config','Foto_Postulante')
                                ->where('estado', 1)
                                ->get();
            }else{
                $dato['get_foto'] = Config::where('descrip_config','Foto_Colaborador')
                                ->where('estado', 1)
                                ->get();
            }

            $dato['url_documentacion'] = Config::where('descrip_config','Documentacion_Perfil')
                                ->where('estado', 1)
                                ->get();
            $dato['url_cese'] = Config::where('descrip_config','Documento_Cese')
                                ->where('estado', 1)
                                ->get();
            $dato['url_docrrhh'] = Config::where('descrip_config','Documentacion_Rrhh')
                                ->where('estado', 1)
                                ->get();
            $dato['url_dochijo'] = Config::where('descrip_config','Datos_Hijos')
                                ->where('estado', 1)
                                ->get();
            $dato['url_estudiog'] = Config::where('descrip_config','Estudios_Generales')
                                ->where('estado', 1)
                                ->get();
            $dato['url_cursosc'] = Config::where('descrip_config','Cursos_Complementarios')
                                ->where('estado', 1)
                                ->get();
            $dato['url_exp'] = Config::where('descrip_config','Experiencia_Laboral')
                                ->where('estado', 1)
                                ->get();
            $dato['url_otro'] = Config::where('descrip_config','Documentacion_Otro')
                                ->where('estado', 1)
                                ->get();
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);

            return view('rrhh.Perfil.index',$dato);
    }
    
    public function Modal_Update_Historico_Base_Colaborador($id_usuario){
        $dato['id_usuario']=$id_usuario;
        $dato['get_historico'] = UsersHistoricoCentroLabores::where('id_usuario', $id_usuario)
                                ->where('estado', 1)
                                ->orderBy('fec_reg', 'DESC')
                                ->limit(1)
                                ->get();
        $dato['list_base'] = Base::select('cod_base')
                            ->where('estado', 1)
                            ->GroupBy('cod_base')
                            ->OrderBy('cod_base', 'ASC')
                            ->get();
        return view('rrhh.Perfil.Historico_Colaborador.modal_historico_base',$dato);
    }

    public function Update_Historico_Base(Request $request){
        $request->validate([
            'cod_base_hb' => 'required',
            'fec_inicio_hb' => 'required',
        ], [
            'cod_base_hb' => 'Debe seleccionar base',
            'fec_inicio_hb.required' => 'Debe ingresar fecha de inicio.',
        ]);

        $id_historico_centro_labores= $request->input("id_historico_centro_labores");
        
        if($id_historico_centro_labores!=""){
            UsersHistoricoCentroLabores::findOrFail($id_historico_centro_labores)->update([
                'centro_labores' => $request->cod_base_hb,
                'id_usuario' => $request->id_usuario_hb,
                'fec_inicio' => $request->fec_inicio_hb,
                'fec_fin' => $request->fec_fin_hb,
                'con_fec_fin' => $request->con_fec_fin_hb,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
            Usuario::findOrFail($request->id_usuario_hb)->update([
                'centro_labores' => $request->cod_base_hb,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
            if($request->cod_base_bd_hb!=$request->cod_base_hb){
                echo "crea";
                UsersHistoricoCentroLabores::create([
                    'id_usuario' => $request->id_usuario_hb,
                    'cod_base' => $request->cod_base_hb,
                    'fec_inicio' => $request->fec_inicio_hb,
                    'fec_fin' => $request->fec_fin_hb,
                    'con_fec_fin' => $request->con_fec_fin_hb,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                    'user_reg' => session('usuario')->id_usuario,
                ]);
                Usuario::findOrFail($request->id_usuario_hb)->update([
                    'centro_labores' => $request->cod_base_hb,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            }
        }else{
            UsersHistoricoCentroLabores::create([
                'id_usuario' => $request->id_usuario_hb,
                'cod_base' => $request->cod_base_hb,
                'fec_inicio' => $request->fec_inicio_hb,
                'fec_fin' => $request->fec_fin_hb,
                'con_fec_fin' => $request->con_fec_fin_hb,
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'user_reg' => session('usuario')->id_usuario,
            ]);
            Usuario::findOrFail($request->id_usuario_hb)->update([
                'centro_labores' => $request->cod_base_hb,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }
    }
    
    public function List_Datos_Laborales(Request $request){
        $this->Model_Perfil = new Model_Perfil();
        $id_usuario= $request->input("id_usuario");
        $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
        return view('rrhh.Perfil.Historico_Colaborador.datos_laborales',$dato);
    }

    public function Modal_Update_Historico_Modalidad_Colaborador($id_usuario){
        $dato['id_usuario']=$id_usuario;
        $dato['get_historico'] = UsersHistoricoModalidad::where('id_usuario', $id_usuario)
                                ->where('estado', 1)
                                ->orderBy('fec_reg', 'DESC')
                                ->limit(1)
                                ->get();
        $dato['list_modalidad_laboral'] = ModalidadLaboral::where('estado', 1)
                            ->get();
        return view('rrhh.Perfil.Historico_Colaborador.modal_historico_modalidad',$dato);
    }

    public function Update_Historico_Modalidad(Request $request){
        $request->validate([
            'id_modalidad_laboral_hm' => 'not_in:0',
            'fec_inicio_hm' => 'required',
        ], [
            'id_modalidad_laboral_hm' => 'Debe seleccionar modalidad laboral',
            'fec_inicio_hm.required' => 'Debe ingresar fecha de inicio.',
        ]);

            $id_historico_modalidadl= $request->input("id_historico_modalidadl");

            if($id_historico_modalidadl!=""){
                    UsersHistoricoModalidad::create([
                        'id_usuario' => $request->id_usuario_hm,
                        'id_modalidad_laboral' => $request->id_modalidad_laboral_hm,
                        'fec_inicio' => $request->fec_inicio_hm,
                        'fec_fin' => $request->fec_fin_hm,
                        'con_fec_fin' => $request->con_fec_fin_hm,
                        'estado' => 1,
                        'fec_reg' => now(),
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                    Usuario::findOrFail($request->id_usuario_hm)->update([
                        'id_modalidad_laboral' => $request->id_modalidad_laboral_hm,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                if($request->id_modalidad_laboral_bd_hm!=$request->id_modalidad_laboral_hm){
                    UsersHistoricoModalidad::findOrFail($id_historico_modalidadl)->update([
                        'id_usuario' => $request->id_usuario_hm,
                        'id_modalidad_laboral' => $request->id_modalidad_laboral_hm,
                        'fec_inicio' => $request->fec_inicio_hm,
                        'fec_fin' => $request->fec_fin_hm,
                        'con_fec_fin' => $request->con_fec_fin_hm,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                    Usuario::findOrFail($request->id_usuario_hm)->update([
                        'id_modalidad_laboral' => $request->id_modalidad_laboral_hm,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                UsersHistoricoModalidad::create([
                    'id_usuario' => $request->id_usuario_hm,
                    'id_modalidad_laboral' => $request->id_modalidad_laboral_hm,
                    'fec_inicio' => $request->fec_inicio_hm,
                    'fec_fin' => $request->fec_fin_hm,
                    'con_fec_fin' => $request->con_fec_fin_hm,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                    'user_reg' => session('usuario')->id_usuario,
                ]);
                Usuario::findOrFail($request->id_usuario_hm)->update([
                    'id_modalidad_laboral' => $request->id_modalidad_laboral_hm,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            }
    }

    public function Modal_Update_Historico_Horario_Colaborador($id_usuario){ 
        $this->Model_Perfil = new Model_Perfil();
        $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
        $dato['id_usuario']=$id_usuario;
        $dato['get_historico'] = UsersHistoricoHorario::where('id_usuario', $id_usuario)
                                ->where('estado', 1)
                                ->orderBy('fec_reg', 'DESC')
                                ->limit(1)
                                ->get();
        $dato['list_horario'] = Horario::where('cod_base', $get_id[0]['centro_labores'])
                            ->where('estado', 1)
                            ->get();
        return view('rrhh.Perfil.Historico_Colaborador.modal_historico_horario',$dato);
    }

    public function Update_Historico_Horario(Request $request){
        $request->validate([
            'id_horario_hh' => 'not_in:0',
            'fec_inicio_hh' => 'required',
        ], [
            'id_horario_hh' => 'Debe seleccionar horario',
            'fec_inicio_hh' => 'Debe ingresar fecha de inicio.',
        ]);
            $id_historico_horario = $request->input("id_historico_horario");
            if($request->con_fec_fin_hh == null){
                $con_fec_fin_hh = 0;
            }else{
                $con_fec_fin_hh = $request->conf_fec_fin_hh;
            }
            $dato['id_horario_bd']= $request->input("id_horario_bd_hh");
            if($id_historico_horario!=""){
                if($request->id_horario_bd_hh!=$request->id_horario_hh){
                    UsersHistoricoHorario::create([
                        'id_usuario' => $request->id_usuario_hh,
                        'id_horario' => $request->id_horario_hh,
                        'fec_inicio' => $request->fec_inicio_hh,
                        'fec_fin' => $request->fec_fin_hh,
                        'con_fec_fin' => $con_fec_fin_hh,
                        'estado' => 1,
                        'fec_reg' => now(),
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                    Usuario::findOrFail($request->id_usuario_hh)->update([
                        'id_horario' => $request->id_horario_hh,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    UsersHistoricoHorario::findOrFail($id_historico_horario)->update([
                        'id_usuario' => $request->id_usuario_hh,
                        'id_horario' => $request->id_horario_hh,
                        'fec_inicio' => $request->fec_inicio_hh,
                        'fec_fin' => $request->fec_fin_hh,
                        'con_fec_fin' => $con_fec_fin_hh,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                    Usuario::findOrFail($request->id_usuario_hh)->update([
                        'id_horario' => $request->id_horario_hh,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }
        }else{
            UsersHistoricoHorario::create([
                'id_usuario' => $request->id_usuario_hh,
                'id_horario' => $request->id_horario_hh,
                'fec_inicio' => $request->fec_inicio_hh,
                'fec_fin' => $request->fec_fin_hh,
                'con_fec_fin' => $con_fec_fin_hh,
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'user_reg' => session('usuario')->id_usuario,
            ]);
            Usuario::findOrFail($request->id_usuario_hh)->update([
                'id_horario' => $request->id_horario_hh,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }
            
            $list_inconsistencia = DB::table('asistencia_colaborador_inconsistencia')
                                ->where('id_usuario', $request->id_usuario_hh)
                                ->where('fecha', '>=', $request->fec_inicio_hh)
                                ->get();

            foreach($list_inconsistencia as $list){
                $dato['id_asistencia_inconsistencia'] = $list->id_asistencia_inconsistencia;
                $dia = $list->dia;
                $get_horario_dia = HorarioDia::where('id_horario', $request->id_horario_hh)
                                ->where('dia', $dia)
                                ->get();

                if(count($get_horario_dia)>0){
                    $dato['id_turno']= $get_horario_dia[0]['id_turno'];
                    $dato['get_id'] = Turno::get_list_turno($dato['id_turno']);
                    $dato['entrada']= $dato['get_id'][0]['entrada'];
                    $dato['salida']= $dato['get_id'][0]['salida'];
                    $dato['con_descanso']= $dato['get_id'][0]['t_refrigerio'];
                    $dato['ini_refri']= $dato['get_id'][0]['ini_refri'];
                    $dato['fin_refri']= $dato['get_id'][0]['fin_refri'];
    
                    $data = ToleranciaHorario::consulta_tolerancia_horario_activo();
                    $minutos=0;
                    if(count($data)>0){
                        $minutos=$data[0]['minutos'];
                    }
                    $id_usuario = session('usuario')->id_usuario;

                    DB::table('asistencia_colaborador_inconsistencia')
                        ->where('id_asistencia_inconsistencia', $dato['id_asistencia_inconsistencia'])
                        ->update([
                        'con_descanso' => $dato['con_descanso'],
                        'hora_entrada' => $dato['entrada'],
                        'hora_salida' => $dato['salida'],
                        'hora_descanso_e' => $dato['ini_refri'],
                        'hora_descanso_s' => $dato['fin_refri'],
                        'id_turno' => $dato['id_turno'],
                        'tipo_inconsistencia' => 0,
                        'user_act' => $id_usuario,
                        'fec_act' => now()
                    ]);
                    DB::table('asistencia_colaborador_inconsistencia')
                    ->where('id_asistencia_inconsistencia', $dato['id_asistencia_inconsistencia'])
                    ->update([
                        'hora_entrada_desde' => DB::raw("DATE_FORMAT(DATE_SUB(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                        'hora_entrada_hasta' => DB::raw("DATE_FORMAT(DATE_ADD(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                        'hora_salida_desde' => DB::raw("DATE_FORMAT(DATE_SUB(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                        'hora_salida_hasta' => DB::raw("DATE_FORMAT(DATE_ADD(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s')"),
                        'hora_descanso_e_desde' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_SUB(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                        'hora_descanso_e_hasta' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_ADD(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                        'hora_descanso_s_desde' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_SUB(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                        'hora_descanso_s_hasta' => DB::raw("CASE WHEN con_descanso=1 THEN DATE_FORMAT(DATE_ADD(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') END"),
                        'fec_act' => now()
                    ]);                
                }
            }
    }
/*
    public function Modal_Update_Historico_Horas_Semanales_Colaborador($id_usuario){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario'] = $id_usuario;
            $dato['get_historico'] = $this->Model_Corporacion->get_ultimo_horas_semanales_colaborador_historico($id_usuario);
            $this->load->view('Admin/Colaborador/Perfil/Historico_Colaborador/modal_historico_horas_semanales',$dato);
        }else{
            redirect('');
        }
    }

    public function Update_Historico_Horas_Semanales(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario']= $this->input->post("id_usuario_hhs");
            $dato['horas_semanales']= $this->input->post("horas_semanales_hhs");
            $dato['horas_semanales_bd']= $this->input->post("horas_semanales_bd_hhs");

            if($dato['horas_semanales']!=$dato['horas_semanales_bd']){
                $this->Model_Corporacion->insert_historico_horas_semanales_colaborador($dato);
            }
        }else{
            redirect('');
        }
    }
*/

    public function Modal_Update_Historico_Puesto($id_usuario){
            $dato['id_usuario']=$id_usuario;
            $dato['get_historico'] = UsersHistoricoPuesto::where('id_usuario', $id_usuario)
                                    ->where('estado', 1)
                                    ->orderBy('fec_reg', 'DESC')
                                    ->limit(1)
                                    ->get();
            $dato['list_gerencia'] = Gerencia::where('estado', 1)
                                    ->orderby('nom_gerencia', 'ASC')
                                    ->get();
            $dato['list_tipo_cambio'] = DB::table('tipo_cambio_puesto')
                                    ->where('estado',1)
                                    ->get();
            if(count($dato['get_historico'])>0){
                $dato['list_sub_gerencia'] = SubGerencia::where('id_gerencia', $dato['get_historico'][0]['id_gerencia'])
                                        ->orderBy('nom_sub_gerencia', 'ASC')
                                        ->get();
                $dato['list_area'] = Area::where('id_departamento', $dato['get_historico'][0]['id_sub_gerencia'])
                                    ->where('estado', 1)
                                    ->get();
                $dato['list_puesto'] = Puesto::where('id_area', $dato['get_historico'][0]['id_area'])
                                    ->where('estado', 1)
                                    ->get();
            }
            return view('rrhh.Perfil.Historico_Colaborador.modal_historico_puesto',$dato);
    }
    
    public function Busca_Sub_Gerencia_Hp(Request $request){
        $id_gerencia = $request->input("id_gerencia");

        $dato['list_sub_gerencia'] = SubGerencia::where('id_gerencia', $id_gerencia)
            ->orderBy('nom_sub_gerencia', 'ASC')
            ->get();
        return view('rrhh.Perfil.Historico_Colaborador.cmb_sub_gerencia',$dato);
    }
    
    public function Busca_Area_Hp(Request $request){
        $id_sub_gerencia = $request->input("id_sub_gerencia");
        $dato['list_area'] = Area::where('id_departamento', $id_sub_gerencia)
            ->where('estado', 1)
            ->get();
        return view('rrhh.Perfil.Historico_Colaborador.cmb_area',$dato);
    }

    public function Busca_Puesto_Hp(Request $request){
        $id_area = $request->input("id_area");
        $dato['list_puesto'] = Puesto::where('id_area', $id_area)
            ->where('estado', 1)
            ->get();
        return view('rrhh.Perfil.Historico_Colaborador.cmb_puesto',$dato);

    }

    public function Update_Historico_Puesto(Request $request){
            $id_historico_puesto= $request->input("id_historico_puesto");
            $dato['id_usuario']= $request->input("id_usuario_hp");
            $dato['id_gerencia']= $request->input("id_gerencia_hp");
            $dato['id_sub_gerencia']= $request->input("id_sub_gerencia_hp");
            $dato['id_area']= $request->input("id_area_hp");
            $dato['id_puesto']= $request->input("id_puesto_hp");
            $dato['fec_inicio']= $request->input("fec_inicio_hp");
            $dato['fec_fin']= $request->input("fec_fin_hp");
            $dato['id_tipo_cambio']= $request->input("id_tipo_cambio_hp");
            $dato['con_fec_fin']= $request->input("con_fec_fin_hp");
            $dato['id_puesto_bd']= $request->input("id_puesto_bd_hp");
            if($request->con_fec_fin_hp){
                $con_fec_fin_hp=$request->con_fec_fin_hp;
            }else{
                $con_fec_fin_hp=0;
            }
            if($id_historico_puesto!=""){
                if($dato['id_puesto']!=$dato['id_puesto_bd']){
                    UsersHistoricoPuesto::create([
                        'id_usuario' => $request->id_usuario_hp,
                        'id_gerencia' => $request->id_gerencia_hp,
                        'id_sub_gerencia' => $request->id_sub_gerencia_hp,
                        'id_area' => $request->id_area_hp,
                        'id_puesto' => $request->id_puesto_hp,
                        'fec_inicio' => $request->fec_inicio_hp,
                        'fec_fin' => $request->fec_fin_hp,
                        'con_fec_fin' => $con_fec_fin_hp,
                        'estado' => 1,
                        'fec_reg' => now(),
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                        'user_reg' => session('usuario')->id_usuario,
                    ]);
                    Usuario::findOrFail($request->id_usuario_hp)->update([
                        'id_gerencia' => $request->id_gerencia_hp,
                        'id_sub_gerencia' => $request->id_sub_gerencia_hp,
                        'id_area' => $request->id_area_hp,
                        'id_puesto' => $request->id_puesto_hp,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);

                    $get_id = Organigrama::where('id_usuario', $request->id_usuario_hp)
                            ->get();
                    Organigrama::where('id', $get_id[0]['id'])->update([
                        'id_usuario' => 0,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario,
                    ]);
                    $valida = Organigrama::where('id_puesto', $request->id_puesto_hp)
                            ->exists();
                    if($valida){
                        $az = Organigrama::where('id_puesto', $request->id_puesto_hp)
                                ->get();
                        $dato['id'] = $az[0]['id'];
                        Organigrama::where('id', $get_id[0]['id'])->update([
                            'id_usuario' => $request->id_usuario_hp,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario,
                        ]);
                    }else{
                        Organigrama::create([
                            'id_puesto' => $request->id_puesto_hp,
                            'id_usuario' => $request->id_usuario_hp,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario,
                        ]);
                    }
                }else{
                    UsersHistoricoPuesto::findOrfail($id_historico_puesto)->update([
                        'id_gerencia' => $request->id_gerencia_hp,
                        'id_sub_gerencia' => $request->id_sub_gerencia_hp,
                        'id_area' => $request->id_area_hp,
                        'id_puesto' => $request->id_puesto_hp,
                        'fec_inicio' => $request->fec_inicio_hp,
                        'id_tipo_cambio' => $request->id_tipo_cambio_hp,
                        'con_fec_fin' => $con_fec_fin_hp,
                        'fec_fin' => $request->fec_fin_hp,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                    Usuario::findOrFail($request->id_usuario_hp)->update([
                        'id_gerencia' => $request->id_gerencia_hp,
                        'id_sub_gerencia' => $request->id_sub_gerencia_hp,
                        'id_area' => $request->id_area_hp,
                        'id_puesto' => $request->id_puesto_hp,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }
            }else{
                UsersHistoricoPuesto::create([
                    'id_usuario' => $request->id_usuario_hp,
                    'id_gerencia' => $request->id_gerencia_hp,
                    'id_sub_gerencia' => $request->id_sub_gerencia_hp,
                    'id_area' => $request->id_area_hp,
                    'id_puesto' => $request->id_puesto_hp,
                    'fec_inicio' => $request->fec_inicio_hp,
                    'fec_fin' => $request->fec_fin_hp,
                    'id_tipo_cambio' => $request->id_tipo_cambio_hp,
                    'con_fec_fin' => $con_fec_fin_hp,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                    'user_reg' => session('usuario')->id_usuario,
                ]);
                Usuario::findOrFail($request->id_usuario_hp)->update([
                    'id_gerencia' => $request->id_gerencia_hp,
                    'id_sub_gerencia' => $request->id_sub_gerencia_hp,
                    'id_area' => $request->id_area_hp,
                    'id_puesto' => $request->id_puesto_hp,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);

                $get_id = Organigrama::where('id_usuario', $request->id_usuario_hp)
                    ->get();
                Organigrama::findOrFail('id', $get_id[0]['id'])->update([
                    'id_usuario' => 0,
                    'fecha' => now(),
                    'usuario' => session('usuario')->id_usuario,
                ]);
                $valida = Organigrama::where('id_puesto', $request->id_puesto_hp)
                        ->exists();
                if($valida){
                    $az = Organigrama::where('id_puesto', $request->id_puesto_hp)
                            ->get();
                    $dato['id'] = $az[0]['id'];
                    Organigrama::where('id', $get_id[0]['id'])->update([
                        'id_usuario' => $request->id_usuario_hp,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    Organigrama::create([
                        'id_puesto' => $request->id_puesto_hp,
                        'id_usuario' => $request->id_usuario_hp,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario,
                    ]);
                }
            }
    }
    public function Modal_Detalle_Historico_Colaborador($id_usuario,$tipo){
        $dato['id_usuario']=$id_usuario;
        $dato['tipo']=$tipo;
        if($tipo==1){
            $dato['list_historico_puesto'] = UsersHistoricoPuesto::get_list_historico_puesto_colaborador($id_usuario);
        }if($tipo==2){
            $dato['list_historico_base'] = UsersHistoricoCentroLabores::get_list_historico_base_colaborador($id_usuario);
        }if($tipo==3){
            $dato['list_historico_modalidad'] = UsersHistoricoModalidad::get_list_historico_modalidadl_colaborador($id_usuario);
        }if($tipo==4){
            $dato['list_historico_horario'] = UsersHistoricoHorario::get_list_historico_horario_colaborador($id_usuario);
        }/*if($tipo==5){
            $dato['list_historico_horas_semanales'] = $this->Model_Corporacion->get_list_historico_horas_semanales_colaborador($id_usuario);
        }*/
            
        return view('rrhh.Perfil.Historico_Colaborador.modal_historico_detalle',$dato);
    }
    
    public function Valida_Planilla_Activa(Request $request){
        $dato['id_usuario']= $request->input("id_usuario");
        $dato['cant_planilla']=HistoricoColaborador::valida_dato_planilla_activo($dato);
        echo count($dato['cant_planilla']);
    }

    public function Modal_Dato_Planilla($id_usuario,$cantidad){
        $this->Model_Perfil = new Model_Perfil();
        $dato['id_usuario']=$id_usuario;
        $dato['list_situacion_laboral'] = SituacionLaboral::where('estado',1)
                                        ->get();
        $dato['list_empresa'] = Empresas::where('estado', 1)
                                ->where('activo',1)
                                ->get();
        $dato['list_regimen'] = Regimen::where('estado', 1)
                                ->get();
        $dato['list_tipo_contrato'] = TipoContrato::where('estado',1)
                                ->get();
        $dato['get_ultimo'] = $this->Model_Perfil->get_list_datoplanilla($id_usuario);
        $dato['get_historico_estado'] = HistoricoEstadoColaborador::where('id_usuario', $id_usuario)
                                    ->where('estado', 1)
                                    ->orderBy('id_historico_estado_colaborador', 'DESC')
                                    ->get();
        $dato['cantidad']=$cantidad;
        return view('rrhh.Perfil.Datos_Planilla.modal_registrar',$dato);   
    }
    
    public function List_datosgenerales_planilla(Request $request){
        $this->Model_Perfil = new Model_Perfil();
        $id_usuario = $request->input("id_usuario");
        $dato['list_situacion_laboral'] = SituacionLaboral::where('estado', 1)
                                    ->get();
        $dato['list_estado_usuario'] = $this->Model_Perfil->get_list_estado_usuario();
        $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
        $dato['list_datos_planilla'] = $this->Model_Perfil->get_list_datoplanilla($id_usuario);
        $dato['list_empresa'] = Empresas::where('estado', 1)
                                ->where('activo',1)
                                ->get();
        $dato['list_regimen'] = Regimen::where('estado', 1)
                                ->get();
        $dato['list_tipo_contrato'] = TipoContrato::where('estado',1)
                                ->get();
        return view('rrhh.Perfil.Datos_Planilla.index_cabecera',$dato);   
    }
    
    public function List_datos_planilla(Request $request){
        $this->Model_Perfil = new Model_Perfil();
        $id_usuario = $request->input("id_usuario");
        $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
        $dato['list_datos_planilla'] = $this->Model_Perfil->get_list_datoplanilla($id_usuario);
        $dato['url_cese'] = Config::where('descrip_config','Documento_Cese')
                                ->where('estado', 1)
                                ->get();
        return view('rrhh.Perfil.Datos_Planilla.index',$dato);   
    }
    
    public function Btn_Planilla_Perfil(Request $request){
        $this->Model_Perfil = new Model_Perfil();
        $id_usuario = $request->input("id_usuario");
        $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
        $dato['list_datos_planilla'] = $this->Model_Perfil->get_list_datoplanilla($id_usuario);
        return view('rrhh.Perfil.Datos_Planilla.btn_planilla',$dato);   
    }
    
    public function Insert_Dato_Planilla(Request $request){
        $this->Model_Perfil = new Model_Perfil();
        $dato['id_usuario'] =$request->input("id_usuario");
        $dato['id_situacion_laboral'] =$request->input("id_situacion_laboral");
        $dato['fec_inicio']= $request->input("fec_inicio");
        $dato['fec_vencimiento']= $request->input("fec_vencimiento");
        $dato['id_empresa'] =$request->input("id_empresa");
        $dato['id_regimen'] =$request->input("id_regimen");
        $dato['id_tipo_contrato'] =$request->input("id_tipo_contrato");
        $dato['sueldo'] =$request->input("sueldo");
        $dato['id_tipo'] =$request->input("id_tipo");
        $dato['fecha_fin_historico_estado'] =$request->input("fecha_fin_historico_estado");
        $dato['bono'] =$request->input("bono");

        Usuario::findOrFail($request->id_usuario)->update([
            'correo_bienvenida' => null,
            'accesos_email' => null,
        ]);

        $total=count(HistoricoColaborador::valida_dato_planilla($dato));
        $total2=count(HistoricoColaborador::valida_dato_planilla_activo($dato));
        if($total>0){
            echo "error";
        }elseif($total2>0){
            echo "incompleto";
        }else{
            $dato['historico'] = HistoricoEstadoColaborador::where('id_usuario', $request->id_usuario)
                                ->where('fec_inicio', $request->fec_inicio);
            HistoricoColaborador::create([
                'id_usuario' => $request->id_usuario,
                'id_situacion_laboral' => $request->id_situacion_laboral,
                'fec_inicio' => $request->fec_inicio,
                'motivo_fin' => 0.00,
                'observacion' => '',
                'movilidad' => 0.00,
                'refrigerio' => 0.00,
                'asignacion_educac' => 0.00,
                'vale_alimento' => 0.00,
                'otra_remun' => 0.00,
                'remun_exoner' => 0.00,
                'hora_mes' => 0.00,
                'estado_intermedio' => 0,
                'id_motivo_cese' => 0,
                'archivo_cese' => '',
                'flag_cesado' => 0,
                'fec_vencimiento' => $request->fec_vencimiento,
                'id_empresa' => $request->id_empresa,
                'id_regimen' => $request->id_regimen,
                'id_tipo_contrato' => $request->id_tipo_contrato,
                'id_tipo' => $request->id_tipo,
                'sueldo' => $request->sueldo,
                'bono' => $request->bono,
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'user_reg' => session('usuario')->id_usuario,
            ]);
            $user['fec_inicio']= $request->input("fec_inicio");
            $user['fin_funciones']= '';
            $user['id_empresapl'] =$request->input("id_empresa");
            $user['id_regimen'] =$request->input("id_regimen");
            $user['id_tipo_contrato'] =$request->input("id_tipo_contrato");
            $user['fec_act'] = now();
            $user['fec_reg'] = now();
            $user['user_act'] = session('usuario')->id_usuario;
            $user['user_reg'] = session('usuario')->id_usuario;
            Usuario::findOrFail($request->id_usuario)->update($user);

            $get_id = Organigrama::where('id_usuario', $request->id_usuario)
                ->exists();
            
            if($get_id){
                $get_id = Organigrama::where('id_usuario', $request->id_usuario)
                    ->get();
                Organigrama::where('id', $get_id[0]['id'])->update([
                    'id_usuario' => 0,
                    'fecha' => now(),
                    'usuario' => session('usuario')->id_usuario,
                ]);
            }
            $get_id = $this->Model_Perfil->get_id_usuario($dato['id_usuario']);
            $id_puesto = $get_id[0]['id_puesto'];
            $valida = Organigrama::where('id_puesto', $id_puesto)
                ->exists();
            if($valida){
                $get_id = Organigrama::where('id_usuario', $request->id_usuario)
                    ->get();
                $az = Organigrama::where('id_puesto', $id_puesto)
                        ->get();
                $dato['id'] = $az[0]['id'];
                Organigrama::where('id', $dato['id'])->update([
                    'id_usuario' => $request->id_usuario,
                    'fecha' => now(),
                    'usuario' => session('usuario')->id_usuario,
                ]);
            }else{
                Organigrama::create([
                    'id_puesto' => $id_puesto,
                    'id_usuario' => $request->id_usuario,
                    'fecha' => now(),
                    'usuario' => session('usuario')->id_usuario,
                ]);
            }
        }
    }

    public function Modal_Enviar_Correo_Bienvenida($id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();

            if(isset($id_usuario) && $id_usuario > 0){
                $id_usuario=$id_usuario;
            }
            else{
                $id_usuario= session('usuario')->id_usuario;
            }
            $dato['usuario_mail'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            //print_r($dato);

            $template = imagecreatefromstring(file_get_contents( public_path('template/assets/img/Imagen_bienvenido.png')));

            // Cargar la imagen del nuevo
            if($dato['get_id'][0]['foto'] == ""){
                $foto_perfil = public_path('template/assets/img/avatar.jpg');
            }else{
                $foto_perfil=$dato['get_id'][0]['foto'];
            };
            $photo = imagecreatefromstring(file_get_contents($foto_perfil));
            $foto=$foto_perfil;
            
            $imageContent = file_get_contents($foto);
            // Carpeta local donde se guardará la imagen
            $carpetaLocal = public_path('ARCHIVO_TEMPORAL/');
            //$carpetaLocal = 'https://grupolanumero1.com.pe/intranet/ARCHIVO_TEMPORAL/';
            if (!file_exists($carpetaLocal)) {
                mkdir($carpetaLocal, 0777, true);
            }

            // Obtener información sobre la imagen para determinar la extensión
            $imageInfo = getimagesizefromstring($imageContent);

            // Obtener la extensión de la imagen
            $extension = image_type_to_extension($imageInfo[2], false);

            // Nombre del archivo local con la extensión
            $nombreArchivoLocal = "foto_tmp_bienvenido.". $extension;

            // Ruta completa del archivo local
            $rutaArchivoLocal = public_path('ARCHIVO_TEMPORAL/' . $nombreArchivoLocal);
            //$rutaArchivoLocal = 'https://grupolanumero1.com.pe/intranet/ARCHIVO_TEMPORAL/' . $nombreArchivoLocal;

            // Guardar la imagen descargada en la carpeta local
            file_put_contents($rutaArchivoLocal, $imageContent);

            $imagen_original = Image::make($rutaArchivoLocal);

            // Obtener las dimensiones originales de la imagen
            $original_ancho = $imagen_original->width();
            $original_alto = $imagen_original->height();

            // Definir el nuevo tamaño máximo
            $max_alto = 1000;
            $max_ancho = 1000;
            $ruta_local="";
            // Verificar si es necesario redimensionar
            if ($original_ancho > $max_ancho || $original_alto > $max_alto) {
                $ext = pathinfo($rutaArchivoLocal, PATHINFO_EXTENSION);
                $nombre_soli="foto_tmp_bienvenido";
                $nombre = $nombre_soli.".".$ext;

                // Calcular nuevas dimensiones manteniendo la proporción
                $imagen_original->resize($max_ancho, $max_alto, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // Orientar la imagen según la orientación original
                $imagen_original->orientate();

                // Guardar la imagen redimensionada localmente
                $ruta_local = public_path("ARCHIVO_TEMPORAL/" . $nombre);
                //$ruta_local = "https://grupolanumero1.com.pe/intranet/ARCHIVO_TEMPORAL/" . $nombre;
                $imagen_original->save($ruta_local);
                $photo=imagecreatefromstring(file_get_contents(public_path("ARCHIVO_TEMPORAL/" . $nombre)));
                //$photo=imagecreatefromstring(file_get_contents("https://grupolanumero1.com.pe/intranet/ARCHIVO_TEMPORAL/" . $nombre));
            }
            
            // Obtener las dimensiones de la imagen de la plantilla
            $width = imagesx($template);
            $height = imagesy($template);

            // Crear una imagen nueva con las mismas dimensiones que la imagen de la plantilla
            $newImage = imagecreatetruecolor($width, $height);

            // Copiar la imagen de la plantilla a la nueva imagen
            imagecopyresampled($newImage, $template, 0, 0, 0, 0, $width, $height, $width, $height);

            // Obtener las dimensiones de la imagen del cumpleañero
            $photoWidth = imagesx($photo);
            $photoHeight = imagesy($photo);

            // Obtener las dimensiones de la imagen de la plantilla
            $width = imagesx($template);
            $height = imagesy($template);

            // Crear una imagen nueva con las mismas dimensiones que la imagen de la plantilla
            $newImage = imagecreatetruecolor($width, $height);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagefill($newImage, 0, 0, $transparent);

            // Copiar la imagen de la plantilla a la nueva imagen
            imagecopyresampled($newImage, $template, 0, 0, 0, 0, $width, $height, $width, $height);

            // Obtener las dimensiones de la imagen del cumpleañero
            $photoWidth = imagesx($photo);
            $photoHeight = imagesy($photo);

            $newWidth = 320;
            $newHeight = 320;

            // Redimensionar la imagen del cumpleañero sin perder calidad ni proporciones
            $resizedPhoto = imagecreatetruecolor($newWidth, $newHeight);
            imagesavealpha($resizedPhoto, true);
            $transparent = imagecolorallocatealpha($resizedPhoto, 0, 0, 0, 127);
            imagefill($resizedPhoto, 0, 0, $transparent);
            imagecopyresampled($resizedPhoto, $photo, 0, 0, 0, 0, $newWidth, $newHeight, $photoWidth, $photoHeight);

            // Crear una máscara circular
            $mask = imagecreatetruecolor($newWidth, $newHeight);
            imagesavealpha($mask, true);
            $transparent = imagecolorallocatealpha($mask, 0, 0, 0, 127);
            imagefill($mask, 0, 0, $transparent);
            $white = imagecolorallocate($mask, 255, 255, 255);
            imagefilledellipse($mask, $newWidth / 2, $newHeight / 2, $newWidth, $newHeight, $white);

            // Aplicar la máscara circular a la imagen redimensionada
            $finalImage = imagecreatetruecolor($newWidth, $newHeight);
            imagesavealpha($finalImage, true);
            imagefill($finalImage, 0, 0, $transparent);

            for ($x = 0; $x < $newWidth; $x++) {
                for ($y = 0; $y < $newHeight; $y++) {
                    $maskAlpha = imagecolorat($mask, $x, $y) & 0xFF;
                    if ($maskAlpha > 0) {
                        $color = imagecolorat($resizedPhoto, $x, $y);
                        imagesetpixel($finalImage, $x, $y, $color);
                    } else {
                        imagesetpixel($finalImage, $x, $y, $transparent);
                    }
                }
            }

            // Limpiar la memoria de la máscara
            imagedestroy($mask);
            imagedestroy($resizedPhoto);

            // Combinar la imagen final (circular) con la plantilla
            $destX = 586; // Coordenada X en la plantilla donde se coloca la imagen circular
            $destY = 71; // Coordenada Y en la plantilla donde se coloca la imagen circular
            imagecopy($newImage, $finalImage, $destX, $destY, 0, 0, $newWidth, $newHeight);

            // Limpiar la memoria de la imagen final
            imagedestroy($finalImage);
            // Agregar texto en la imagen
            $nombre=explode(" ",$dato['get_id'][0]['usuario_nombres']);
            $texto=mb_convert_case($nombre[0].' '.$dato['get_id'][0]['usuario_apater'], MB_CASE_TITLE, "UTF-8");
            $tamano_fuente = 36;
            //$fuente = 'public_path('template/assets/fonts/Poppins.TTF'); // ruta a la fuente TTF
            $fuente = public_path('template/assets/fonts/Poppins.ttf'); // ruta a la fuente TTF
            $bbox = imagettfbbox($tamano_fuente, 0, $fuente, $texto);
            $texto_ancho = $bbox[2] - $bbox[0];
            $texto_alto = $bbox[1] - $bbox[7];

            $color_texto = imagecolorallocate($newImage, 255, 255, 255); // color blanco
            $posicion_texto_x = 50; // posición horizontal del texto
            $posicion_texto_y = 185; // posición vertical del texto
            imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x, $posicion_texto_y, $color_texto, $fuente, $texto);
            
            if($dato['get_id'][0]['id_genero'] == 1){
                $texto = "¡BIENVENIDO!";
            }else{
                $texto = "¡BIENVENIDA!";
            }

            $tamano_fuente = 28;
            $bbox = imagettfbbox($tamano_fuente, 0, $fuente, $texto);
            $texto_ancho = $bbox[2] - $bbox[0];
            $texto_alto = $bbox[1] - $bbox[7];
            $offset = 0.1; // Desplazamiento para el efecto de negrita
            $color_texto2 = imagecolorallocate($newImage, 255,167,0); // color amarillo

            $posicion_texto_x0 = 75; // posición horizontal del texto
            $posicion_texto_y0 = 125; // posición vertical del texto
            // Dibujar texto en negrita
            for ($c1 = -1; $c1 <= 1; $c1++) {
                for ($c2 = -1; $c2 <= 1; $c2++) {
                    imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x0 + ($c1*$offset), $posicion_texto_y0 + ($c2*$offset), $color_texto2, $fuente, $texto);
                }
            }
            //imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x0, $posicion_texto_y0, $color_texto2, $fuente, $texto);

            $texto = "Por sumarte a nuestro equipo el ";
            $tamano_fuente = 14;
            $bbox = imagettfbbox($tamano_fuente, 0, $fuente, $texto);
            $texto_ancho = $bbox[2] - $bbox[0];
            $texto_alto = $bbox[1] - $bbox[7];

            $posicion_texto_x = 64; // posición horizontal del texto
            $posicion_texto_y = 250; // posición vertical del texto
            imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x, $posicion_texto_y, $color_texto, $fuente, $texto);
            
            $fecha_original = $dato['get_id'][0]['ini_funciones'];
            $fecha = new DateTime($fecha_original);
            $fecha_formateada = $fecha->format('d/m/Y');
            $texto = $fecha_formateada;
            $tamano_fuente = 14;
            $bbox = imagettfbbox($tamano_fuente, 0, $fuente, $texto);
            $texto_ancho = $bbox[2] - $bbox[0];
            $texto_alto = $bbox[1] - $bbox[7];
            $offset = 0.1; // Desplazamiento para el efecto de negrita

            $posicion_texto_x2 = 375; // posición horizontal del texto
            $posicion_texto_y = 250; // posición vertical del texto
            // Dibujar texto en negrita
            for ($c1 = -1; $c1 <= 1; $c1++) {
                for ($c2 = -1; $c2 <= 1; $c2++) {
                    imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x2 + ($c1*$offset), $posicion_texto_y + ($c2*$offset), $color_texto, $fuente, $texto);
                }
            }

            $texto = $dato['get_id'][0]['nom_puesto'];
            $tamano_fuente = 15;
            $bbox = imagettfbbox($tamano_fuente, 0, $fuente, $texto);
            $texto_ancho = $bbox[2] - $bbox[0];
            $texto_alto = $bbox[1] - $bbox[7];

            $posicion_texto_x = 64; // posición horizontal del texto
            $posicion_texto_y2 = 335; // posición vertical del texto
            $offset = 0.1; // Desplazamiento para el efecto de negrita

            // Dibujar texto en negrita
            for ($c1 = -1; $c1 <= 1; $c1++) {
                for ($c2 = -1; $c2 <= 1; $c2++) {
                    imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x + ($c1*$offset), $posicion_texto_y2 + ($c2*$offset), $color_texto, $fuente, $texto);
                }
            }

            $texto = ucfirst(strtolower($dato['get_id'][0]['nom_area']));
            $tamano_fuente = 12;
            $bbox = imagettfbbox($tamano_fuente, 0, $fuente, $texto);
            $texto_ancho = $bbox[2] - $bbox[0];
            $texto_alto = $bbox[1] - $bbox[7];

            $posicion_texto_x = 64; // posición horizontal del texto
            $posicion_texto_y3 = 360; // posición vertical del texto
            imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x, $posicion_texto_y3, $color_texto, $fuente, $texto);

            $texto = strtolower($dato['get_id'][0]['emailp']);
            $tamano_fuente = 11;
            $bbox = imagettfbbox($tamano_fuente, 0, $fuente, $texto);
            $texto_ancho = $bbox[2] - $bbox[0];
            $texto_alto = $bbox[1] - $bbox[7];

            $posicion_texto_x2 = ($width - $texto_ancho) / 2 + 288; // posición horizontal del texto
            $posicion_texto_y4 = 520; // posición vertical del texto
            imagettftext($newImage, $tamano_fuente, 0, $posicion_texto_x2, $posicion_texto_y4, $color_texto, $fuente, $texto);
            $config['upload_path'] =  public_path('Bienvenido_Temporales/');
            //$config['upload_path'] =  'https://grupolanumero1.com.pe/intranet/Bienvenido_Temporales/';
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
                chmod($config['upload_path'], 0777);
            }
            ob_start();
            imagejpeg($newImage, public_path('Bienvenido_Temporales/imagen'.$dato['get_id'][0]['id_usuario'].'.jpg'),100);
            //imagejpeg($newImage, 'https://grupolanumero1.com.pe/intranet/Bienvenido_Temporales/imagen.jpg',100);
            $imageContent = ob_get_clean();
            return view('rrhh.Perfil.Accesos.modal_enviar_correo_bienvenido', $dato);
    }

    public function Enviar_Correo_Bienvenida($id_user){
        $this->Model_Perfil = new Model_Perfil();
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_user);

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
                $mail->setFrom('somosuno@lanumero1.com.pe','Somos Uno');

                // $mail->addAddress('pcardenas@lanumero1.com.pe');
                // $mail->addAddress('cmarcalaya@lanumero1.com.pe');
                // $mail->addAddress('ltaype@lanumero1.com.pe');
                // $mail->addAddress('practicante2.procesos@lanumero1.com.pe');

                $mail->addAddress('coordinadores@lanumero1.com.pe');
                $mail->addAddress('tiendas@lanumero1.com.pe');
                $mail->addAddress('oficina@lanumero1.com.pe');
                $mail->addAddress('amauta@lanumero1.com.pe');
                $mail->addAddress('cd@lanumero1.com.pe');
                $mail->addCC('gerencia@lanumero1.com.pe');
                $mail->addCC($dato['get_id'][0]['emailp']);
                $mail->AddEmbeddedImage(public_path("Bienvenido_Temporales/imagen".$dato['get_id'][0]['id_usuario'].".jpg"), "imagen", "imagen.jpg");

                $mail->isHTML(true);
                $nombreCompleto = $dato['get_id'][0]['usuario_nombres'];
                $palabras = explode(" ", $nombreCompleto);

                if($dato['get_id'][0]['id_genero']==1){
                    $mensaje_a = "BIENVENIDO";
                }else{
                    $mensaje_a = "BIENVENIDA";
                }
                $mail->Subject =  "$mensaje_a ".$palabras[0]." ".$dato['get_id'][0]['usuario_apater']. "!";
            
                //$mailContent = $this->load->view('Admin/Colaborador/Perfil/Accesos/mail_bienvenido', $dato, TRUE);
                $mail->Body = '<img src="cid:imagen">';
            
                $mail->CharSet = 'UTF-8';
                $mail->send();

                Usuario::findOrFail($id_user)->update([
                    'correo_bienvenida' => now(),
                ]);
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
            unlink( public_path("Bienvenido_Temporales/imagen".$dato['get_id'][0]['id_usuario'].".jpg"));
            unlink( public_path("ARCHIVO_TEMPORAL/foto_tmp_bienvenido.jpeg"));
            //unlink(FCPATH."ARCHIVO_TEMPORAL/fotodesc_tmp_bienvenido.jpeg");   
    }
    
    public function Modal_Enviar_Correo_Colaborador($id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();
            if(isset($id_usuario) && $id_usuario > 0){
                $id_usuario=$id_usuario;
            }
            else{
                $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
            }
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $id_area = $dato['get_id'][0]['id_area'];
            $id_puesto = $dato['get_id'][0]['id_puesto'];
            $dato['list_fec_inicio'] = HistoricoColaborador::select('fec_inicio')
                                    ->where('id_usuario', $id_usuario)
                                    ->where('estado', 1)
                                    ->get();
            
            $dato['list_accesos_datacorp'] = DatacorpAccesos::where('area', $id_area)
                                    ->where('puesto', $id_puesto)
                                    ->get()
                                    ->toArray();
            $dato['list_accesos_paginas_web'] = PaginasWebAccesos::where('area', $id_area)
                                        ->where('puesto', $id_puesto)
                                        ->get()
                                        ->toArray();
            $dato['list_accesos_programas'] = ProgramaAccesos::where('area', $id_area)
                                        ->where('puesto', $id_puesto)
                                        ->get()
                                        ->toArray();
            $dato['usuario_mail_soporte']=$this->Model_Perfil->get_id_usuario(173);
            //correo asistente soporte
            $dato['usuario_mail_soporte2']=$this->Model_Perfil->get_id_usuario(2952);
            $dato['usuario_mail_2']=$this->Model_Perfil->get_id_usuario(136);
            $dato['get_jefe_area'] = Usuario::get_jefe_area($id_area);
            return view('rrhh.Perfil.Accesos.modal_enviar_correo', $dato);
    }

    public function Enviar_Correo_Colaborador(Request $request){
        $this->Model_Perfil = new Model_Perfil();
            $id_usuario = $request->input("id_user");
            $dato['observaciones'] = $request->input("observaciones");
            
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $id_gerencia = $dato['get_id'][0]['id_gerencia'];
            $id_area = $dato['get_id'][0]['id_area'];
            $id_puesto = $dato['get_id'][0]['id_puesto'];
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $id_area = $dato['get_id'][0]['id_area'];
            $id_puesto = $dato['get_id'][0]['id_puesto'];
            $dato['list_fec_inicio'] = HistoricoColaborador::select('fec_inicio')
                                    ->where('id_usuario', $id_usuario)
                                    ->where('estado', 1)
                                    ->get();
            
            $dato['list_accesos_datacorp'] = DatacorpAccesos::where('area', $id_area)
                                    ->where('puesto', $id_puesto)
                                    ->get()
                                    ->toArray();
            $dato['list_accesos_paginas_web'] = PaginasWebAccesos::where('area', $id_area)
                                        ->where('puesto', $id_puesto)
                                        ->get()
                                        ->toArray();
            $dato['list_accesos_programas'] = ProgramaAccesos::where('area', $id_area)
                                        ->where('puesto', $id_puesto)
                                        ->get()
                                        ->toArray();
            $usuario_mail_soporte =$this->Model_Perfil->get_id_usuario(173);
            //correo asistente soporte
            $usuario_mail_soporte2 =$this->Model_Perfil->get_id_usuario(2952);
            //correo Sr. Fernando
            $usuario_mail_2 =$this->Model_Perfil->get_id_usuario(136);
            $get_jefe_area  = Usuario::get_jefe_area($id_area);
            $nombre=explode(" ",$dato['get_id'][0]['usuario_nombres']);

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
                //$mail->setFrom('intranet@lanumero1.com.pe','NUEVO PERSONAL');
                $mail->setFrom('somosuno@lanumero1.com.pe','NUEVO PERSONAL');

                // $mail->addAddress('pcardenas@lanumero1.com.pe');
                //$mail->addAddress('practicante2.procesos@lanumero1.com.pe');
                
                if (!empty($usuario_mail_soporte[0]['emailp'])) {
                    $mail->addAddress($usuario_mail_soporte[0]['emailp']);
                }
                
                if (!empty($usuario_mail_soporte2[0]['emailp'])) {
                    $mail->addAddress($usuario_mail_soporte2[0]['emailp']);
                }
                
                foreach($get_jefe_area as $get_jefes){
                    $mail->addCC($get_jefes['emailp']);
                }
                
                if (!empty($usuario_mail_2[0]['emailp'])) {
                    $mail->addCC($usuario_mail_2[0]['emailp']);
                }
                
                $mail->addCC("acanales@lanumero1.com.pe");
                $mail->addCC("dtrujillano@lanumero1.com.pe");
                $mail->addCC("dvilca@lanumero1.com.pe");
                $mail->addCC("ltaype@lanumero1.com.pe");

                $mail->isHTML(true);

                $mail->Subject = "SOLICITUD DE ACCESOS Y PREPARACIÓN DE EQUIPOS - ".$nombre[0]." ".$dato['get_id'][0]['usuario_apater'];
            
                $mailContent = view('rrhh.Perfil.Accesos.mail_nuevo_colaborador', $dato)->render();
                $mail->Body= $mailContent;
            
                $mail->CharSet = 'UTF-8';
                $mail->send();

                Usuario::findOrFail($id_usuario)->update([
                    'accesos_email' => now(),
                ]);
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
    }
    
    public function Update_Adjuntar_DocumentacionRRHH(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $url = Config::where('id_config', 8)
                ->get()
                ->toArray();
            $dato['url_archivo'] = $url[0]['url_config'];

            $dato['total'] = DocumentacionUsuario::where('id_usuario', $dato['id_usuario'])
                    ->where('estado', 1)
                    ->get();
            //print_r($dato['total']);
            $dato['carta_renuncia']="";
            $dato['eval_sicologico']="";
            $dato['convenio_laboral']="";
            if(count($dato['total'])>0){
                $dato['carta_renuncia']=$dato['total'][0]['carta_renuncia'];
                $dato['eval_sicologico']=$dato['total'][0]['eval_sicologico'];
                $dato['convenio_laboral']=$dato['total'][0]['convenio_laboral'];
            }
            
            if($_FILES["carta_renuncia"]["name"] != "" || $_FILES['eval_sicologico']['name']!="" || 
                $_FILES['convenio_laboral']['name']){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['carta_renuncia']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['carta_renuncia']['name']);
                        $source_file = $_FILES['carta_renuncia']['tmp_name'];

                        $fechaHoraActual = date('Y-m-dHis');
                        $caracteresPermitidos = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $codigoUnico = '';
                        do {
                            $cadenaAleatoria = '';
                            for ($i = 0; $i < 20; $i++) {
                                $cadenaAleatoria .= $caracteresPermitidos[rand(0, strlen($caracteresPermitidos) - 1)];
                            }
                            $codigoUnico = $cadenaAleatoria . $fechaHoraActual;
                            $nombre="cartarenunc_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/DOCUMENTACIONRRHH/".$nombre;
                            $duplicado=0;
                            
                        }while ($duplicado>0);
                        
                        ftp_pasv($con_id, true);
                        

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['carta_renuncia'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    
                    //
                    $path = $_FILES['eval_sicologico']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['eval_sicologico']['name']);
                        $source_file = $_FILES['eval_sicologico']['tmp_name'];
    
                        $fechaHoraActual = date('Y-m-dHis');
                        $caracteresPermitidos = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $codigoUnico = '';
                        do {
                            $cadenaAleatoria = '';
                            for ($i = 0; $i < 20; $i++) {
                                $cadenaAleatoria .= $caracteresPermitidos[rand(0, strlen($caracteresPermitidos) - 1)];
                            }
                            $codigoUnico = $cadenaAleatoria . $fechaHoraActual;
                            $nombre="eval_psicol_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/DOCUMENTACIONRRHH/".$nombre;
                            $duplicado=0;
                            
                        }while ($duplicado>0);
                        
                        ftp_pasv($con_id, true);
                        
    
                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['eval_sicologico'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    

                    //
                    $path = $_FILES['convenio_laboral']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['convenio_laboral']['name']);
                        $source_file = $_FILES['convenio_laboral']['tmp_name'];

                        $fechaHoraActual = date('Y-m-dHis');
                        $caracteresPermitidos = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $codigoUnico = '';
                        do {
                            $cadenaAleatoria = '';
                            for ($i = 0; $i < 20; $i++) {
                                $cadenaAleatoria .= $caracteresPermitidos[rand(0, strlen($caracteresPermitidos) - 1)];
                            }
                            $codigoUnico = $cadenaAleatoria . $fechaHoraActual;
                            $nombre="eval_psicol_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/DOCUMENTACIONRRHH/".$nombre;
                            $duplicado=0;
                            
                        }while ($duplicado>0);
                        
                        ftp_pasv($con_id, true);
                        

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['convenio_laboral'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    
                    ftp_close($con_id);
                }   
            }

            if(count($dato['total'])>0){
                DocumentacionUsuario::where('id_usuario', $dato['id_usuario'])->update([
                    'carta_renuncia' => $dato['carta_renuncia'],
                    'eval_sicologico' => $dato['eval_sicologico'],
                    'convenio_laboral' => $dato['convenio_laboral'],
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            }else{
                DocumentacionUsuario::create([
                    'id_usuario' => $dato['id_usuario'],
                    'carta_renuncia' => $dato['carta_renuncia'],
                    'eval_sicologico' => $dato['eval_sicologico'],
                    'convenio_laboral' => $dato['convenio_laboral'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);
            }
            $this->Model_Perfil = new Model_Perfil();

            $id_usuario= $request->input("id_usuariodp");

            $dato['get_id_documentacion'] = $this->Model_Perfil->get_id_documentacion($id_usuario);

            $dato['url_docrrhh'] = Config::where('descrip_config','Documentacion_Rrhh')
                                ->where('estado', 1)
                                ->get();

            return view('rrhh.Perfil.DocumentacionRRHH', $dato);
    }
}

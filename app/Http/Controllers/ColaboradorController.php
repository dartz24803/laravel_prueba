<?php

namespace App\Http\Controllers;

use App\Models\Accesorio;
use App\Models\AlergiaUsuario;
use App\Models\Area;
use App\Models\Banco;
use App\Models\Base;
use App\Models\CuentaBancaria;
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
use App\Models\ConociIdiomas;
use App\Models\ConociOffice;
use App\Models\ContactoEmergencia;
use App\Models\CursoComplementario;
use App\Models\DatacorpAccesos;
use App\Models\DocumentacionUsuario;
use App\Models\DomicilioUsers;
use App\Models\Empresas;
use App\Models\EnfermedadUsuario;
use App\Models\EstadoCivil;
use App\Models\EstudiosGenerales;
use App\Models\ExperienciaLaboral;
use App\Models\GestacionUsuario;
use App\Models\GradoInstruccion;
use App\Models\GrupoSanguineo;
use App\Models\GustoPreferenciaUsers;
use App\Models\Hijos;
use App\Models\Horario;
use App\Models\HorarioDia;
use App\Models\Idioma;
use App\Models\ModalidadLaboral;
use App\Models\Model_Perfil;
use App\Models\OtrosUsuario;
use App\Models\PaginasWebAccesos;
use App\Models\Parentesco;
use App\Models\ProgramaAccesos;
use App\Models\Puesto;
use App\Models\ReferenciaConvocatoria;
use App\Models\ReferenciaLaboral;
use App\Models\ReferenciaFamiliar;
use App\Models\Regimen;
use App\Models\RopaUsuario;
use App\Models\SituacionLaboral;
use App\Models\SistPensUsuario;
use App\Models\TipoContrato;
use App\Models\TipoDocumento;
use App\Models\TipoVia;
use App\Models\TipoVivienda;
use App\Models\ToleranciaHorario;
use App\Models\Turno;
use App\Models\UsersHistoricoCentroLabores;
use App\Models\HistoricoColaborador;
use App\Models\MotivoBajaRrhh;
use App\Models\TipoCambioPuesto;
use App\Models\Ubicacion;
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

    public function excel_co($id_gerencia)
    {
        $list_colaborador = Organigrama::get_list_colaborador(['id_gerencia'=>$id_gerencia,'excel'=>1]);
        $dato['url_archivo'] = Config::where('id_config', 8)
                            ->get();

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
        $sheet->getColumnDimension('G')->setWidth(0);
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
        // $sheet->setCellValue('G1', 'CARGO');
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
            $sheet->setCellValue("C{$contador}", $list->centro_labor);
            $sheet->setCellValue("D{$contador}", $list->usuario_apater);
            $sheet->setCellValue("E{$contador}", $list->usuario_amater);
            $sheet->setCellValue("F{$contador}", $list->usuario_nombres);
            // $sheet->setCellValue("G{$contador}", $list->nom_cargo);
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
    }

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
            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);
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
            $dato['list_regimen'] = Regimen::where('estado', 1)
                                ->get();

            $dato['list_horario'] = $this->Model_Perfil->get_list_horario();

            //REPORTE BI CON ID
            $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
            //NOTIFICACIONES
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();

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
        /*$dato['list_base'] = Base::select('cod_base')
                            ->where('estado', 1)
                            ->GroupBy('cod_base')
                            ->OrderBy('cod_base', 'ASC')
                            ->get();*/
        $dato['list_ubicacion'] = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)
                                ->orderBy('cod_ubi','ASC')->get();
        return view('rrhh.Perfil.Historico_Colaborador.modal_historico_base',$dato);
    }

    public function Update_Historico_Base(Request $request){
        $request->validate([
            'cod_base_hb' => 'gt:0',
            'fec_inicio_hb' => 'required',
        ], [
            'cod_base_hb.gt' => 'Debe seleccionar ubicación.',
            'fec_inicio_hb.required' => 'Debe ingresar fecha de inicio.',
        ]);

        $id_historico_centro_labores= $request->input("id_historico_centro_labores");

        if($id_historico_centro_labores!=""){
            if($request->cod_base_bd_hb!=$request->cod_base_hb){
                UsersHistoricoCentroLabores::create([
                    'id_usuario' => $request->id_usuario_hb,
                    'id_ubicacion' => $request->cod_base_hb,
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
                    'id_ubicacion' => $request->cod_base_hb,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            }else{
                UsersHistoricoCentroLabores::findOrFail($id_historico_centro_labores)->update([
                    'id_ubicacion' => $request->cod_base_hb,
                    'id_usuario' => $request->id_usuario_hb,
                    'fec_inicio' => $request->fec_inicio_hb,
                    'fec_fin' => $request->fec_fin_hb,
                    'con_fec_fin' => $request->con_fec_fin_hb,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
                Usuario::findOrFail($request->id_usuario_hb)->update([
                    'id_ubicacion' => $request->cod_base_hb,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            }
        }else{
            UsersHistoricoCentroLabores::create([
                'id_usuario' => $request->id_usuario_hb,
                'id_ubicacion' => $request->cod_base_hb,
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
                'id_ubicacion' => $request->cod_base_hb,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }
    }

    public function List_Datos_Laborales(Request $request){
        $dato['get_id'] = Usuario::from('users AS us')->select('us.id_usuario','ge.nom_gerencia',
                        'sg.nom_sub_gerencia','ar.nom_area','pu.nom_puesto','ub.cod_ubi AS ubicacion',
                        'ml.nom_modalidad_laboral','ho.nombre AS nom_horario','us.horas_semanales',
                        DB::raw('(SELECT COUNT(1) FROM users_historico_puesto p
                        WHERE p.estado=1 AND p.id_usuario=us.id_usuario) AS cant_historico_puesto'),
                        DB::raw('(SELECT COUNT(1) FROM users_historico_centro_labores q
                        WHERE q.estado=1 AND q.id_usuario=us.id_usuario) AS cant_historico_base'),
                        DB::raw('(SELECT COUNT(1) FROM users_historico_modalidadl r
                        WHERE r.estado=1 AND r.id_usuario=us.id_usuario) AS cant_historico_modalidad'),
                        DB::raw('(SELECT COUNT(1) FROM users_historico_horario s
                        WHERE s.estado=1 AND s.id_usuario=us.id_usuario) AS cant_historico_horario'),
                        DB::raw('(SELECT COUNT(1) FROM users_historico_horas_semanales s
                        WHERE s.id_usuario=us.id_usuario AND s.estado=1) AS cant_historico_horas_semanales'))
                        ->join('puesto AS pu','pu.id_puesto','=','us.id_puesto')
                        ->join('area AS ar','ar.id_area','=','pu.id_area')
                        ->join('sub_gerencia AS sg','sg.id_sub_gerencia','=','ar.id_departamento')
                        ->join('gerencia AS ge','ge.id_gerencia','=','sg.id_gerencia')
                        ->join('ubicacion AS ub','ub.id_ubicacion','=','us.id_ubicacion')
                        ->leftjoin('modalidad_laboral AS ml','ml.id_modalidad_laboral','=','us.id_modalidad_laboral')
                        ->leftjoin('horario AS ho','ho.id_horario','=','us.id_horario')
                        ->where('us.id_usuario',$request->id_usuario)->first();
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
        $dato['get_historico'] = UsersHistoricoPuesto::from('users_historico_puesto AS up')
                                ->select('pu.id_puesto','ar.id_area','sg.id_sub_gerencia',
                                'sg.id_gerencia','up.fec_inicio','up.id_tipo_cambio',
                                'up.con_fec_fin','up.fec_fin','up.id_centro_labor')
                                ->join('puesto AS pu','pu.id_puesto','=','up.id_puesto')
                                ->join('area AS ar','ar.id_area','=','pu.id_area')
                                ->join('sub_gerencia AS sg','sg.id_sub_gerencia','=','ar.id_departamento')
                                ->where('up.id_usuario', $id_usuario)
                                ->where('up.estado', 1)
                                ->orderBy('up.fec_reg', 'DESC')
                                ->first();
        $dato['list_gerencia'] = Gerencia::where('estado', 1)
                                ->orderby('nom_gerencia', 'ASC')
                                ->get();
        $dato['list_tipo_cambio'] = TipoCambioPuesto::all();
        if($dato['get_historico']){
            $dato['list_sub_gerencia'] = SubGerencia::where('id_gerencia', $dato['get_historico']->id_gerencia)
                                    ->orderBy('nom_sub_gerencia', 'ASC')
                                    ->get();
            $dato['list_area'] = Area::where('id_departamento', $dato['get_historico']->id_sub_gerencia)
                                ->where('estado', 1)
                                ->get();
            $dato['list_puesto'] = Puesto::where('id_area', $dato['get_historico']->id_area)
                                ->where('estado', 1)
                                ->get();
        }else{
            $dato['list_sub_gerencia'] = [];
            $dato['list_area'] = [];
            $dato['list_puesto'] = [];
        }
        $dato['list_ubicacion'] = Ubicacion::where('estado',1)->orderBy('cod_ubi','ASC')->get();
        return view('rrhh.Perfil.Historico_Colaborador.modal_historico_puesto',$dato);
    }

    public function Update_Historico_Puesto(Request $request, $id_usuario){
        $request->validate([
            'id_gerencia_hp' => 'gt:0',
            'id_sub_gerencia_hp' => 'gt:0',
            'id_area_hp' => 'gt:0',
            'id_puesto_hp' => 'gt:0',
            'id_centro_labor_hp' => 'gt:0',
            'fec_inicio_hp' => 'required',
            'fec_fin_hp' => 'required_if:con_fec_fin_hp,1'
        ], [
            'id_gerencia_hp.gt' => 'Debe seleccionar gerencia.',
            'id_sub_gerencia_hp.gt' => 'Debe seleccionar sub-gerencia.',
            'id_area_hp.gt' => 'Debe seleccionar área.',
            'id_puesto_hp.gt' => 'Debe seleccionar puesto.',
            'id_centro_labor_hp.gt' => 'Debe seleccionar centro de labor.',
            'fec_inicio_hp.required' => 'Debe ingresar fecha de inicio.',
            'fec_fin_hp.required_if' => 'Debe ingresar fecha fin.'
        ]);
        //VALIDACIÓN DE CAPACIDAD DE ORGANIGRAMA
        $get_id = Usuario::findOrFail($id_usuario);
        $valida = Organigrama::where('id_puesto',$request->id_puesto_hp)
                ->where('id_centro_labor',$request->id_centro_labor_hp)->where('id_usuario',0)->count();
        if($valida>0){
            $get_id = UsersHistoricoPuesto::from('users_historico_puesto AS up')
                    ->select('up.id_historico_puesto','pu.id_puesto','ar.id_area','sg.id_sub_gerencia',
                    'sg.id_gerencia','up.fec_inicio','up.id_tipo_cambio',
                    'up.con_fec_fin','up.fec_fin','up.id_centro_labor')
                    ->join('puesto AS pu','pu.id_puesto','=','up.id_puesto')
                    ->join('area AS ar','ar.id_area','=','pu.id_area')
                    ->join('sub_gerencia AS sg','sg.id_sub_gerencia','=','ar.id_departamento')
                    ->where('up.id_usuario', $id_usuario)
                    ->where('up.estado', 1)
                    ->orderBy('up.fec_reg', 'DESC')
                    ->first();

            if($get_id){
                if($request->id_puesto_hp!=$get_id->id_puesto || $request->id_centro_labor_hp!=$get_id->id_centro_labor){
                    UsersHistoricoPuesto::create([
                        'id_usuario' => $id_usuario,
                        'id_puesto' => $request->id_puesto_hp,
                        'id_centro_labor' => $request->id_centro_labor_hp,
                        'fec_inicio' => $request->fec_inicio_hp,
                        'id_tipo_cambio' => $request->id_tipo_cambio_hp,
                        'con_fec_fin' => $request->con_fec_fin_hp,
                        'fec_fin' => $request->fec_fin_hp,
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                    Usuario::findOrFail($id_usuario)->update([
                        'id_puesto' => $request->id_puesto_hp,
                        'id_centro_labor' => $request->id_centro_labor_hp,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);

                    $get_org = Organigrama::where('id_usuario', $id_usuario)
                            ->first();
                    if($get_org){
                        Organigrama::findOrFail($get_org->id)->update([
                            'id_usuario' => 0,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario,
                        ]);
                    }
                    $get_usuario = Usuario::findOrFail($id_usuario);
                    $valida = Organigrama::where('id_puesto', $request->id_puesto_hp)
                            ->where('id_centro_labor',$get_usuario->id_centro_labor)
                            ->where('id_usuario',0)
                            ->first();
                    if(isset($valida->id)){
                        Organigrama::findOrFail($valida->id)->update([
                            'id_usuario' => $id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }else{
                        Organigrama::create([
                            'id_puesto' => $request->id_puesto_hp,
                            'id_centro_labor' => $get_usuario->id_centro_labor,
                            'id_usuario' => $id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }
                }else{
                    UsersHistoricoPuesto::findOrfail($get_id->id_historico_puesto)->update([
                        'id_centro_labor' => $request->id_centro_labor_hp,
                        'fec_inicio' => $request->fec_inicio_hp,
                        'id_tipo_cambio' => $request->id_tipo_cambio_hp,
                        'con_fec_fin' => $request->con_fec_fin_hp,
                        'fec_fin' => $request->fec_fin_hp,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                    Usuario::findOrFail($id_usuario)->update([
                        'id_puesto' => $request->id_puesto_hp,
                        'id_centro_labor' => $request->id_centro_labor_hp,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                    $get_org = Organigrama::where('id_usuario', $id_usuario)
                            ->first();
                    if($get_org){
                        Organigrama::findOrFail($get_org->id)->update([
                            'id_usuario' => 0,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario,
                        ]);
                    }
                    $get_usuario = Usuario::findOrFail($id_usuario);
                    $valida = Organigrama::where('id_puesto', $request->id_puesto_hp)
                            ->where('id_centro_labor',$get_usuario->id_centro_labor)
                            ->where('id_usuario',0)
                            ->first();
                    if(isset($valida->id)){
                        Organigrama::findOrFail($valida->id)->update([
                            'id_usuario' => $id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }else{
                        Organigrama::create([
                            'id_puesto' => $request->id_puesto_hp,
                            'id_centro_labor' => $get_usuario->id_centro_labor,
                            'id_usuario' => $id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }
                }
            }else{
                UsersHistoricoPuesto::create([
                    'id_usuario' => $id_usuario,
                    'id_puesto' => $request->id_puesto_hp,
                    'id_centro_labor' => $request->id_centro_labor_hp,
                    'fec_inicio' => $request->fec_inicio_hp,
                    'id_tipo_cambio' => $request->id_tipo_cambio_hp,
                    'con_fec_fin' => $request->con_fec_fin_hp,
                    'fec_fin' => $request->fec_fin_hp,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
                Usuario::findOrFail($id_usuario)->update([
                    'id_puesto' => $request->id_puesto_hp,
                    'id_centro_labor' => $request->id_centro_labor_hp,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                $get_org = Organigrama::where('id_usuario', $id_usuario)
                        ->first();
                if($get_org){
                    Organigrama::findOrFail($get_org->id)->update([
                        'id_usuario' => 0,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario,
                    ]);
                }
                $get_usuario = Usuario::findOrFail($id_usuario);
                $valida = Organigrama::where('id_puesto', $request->id_puesto_hp)
                        ->where('id_centro_labor',$get_usuario->id_centro_labor)
                        ->where('id_usuario',0)
                        ->first();
                if(isset($valida->id)){
                    Organigrama::findOrFail($valida->id)->update([
                        'id_usuario' => $id_usuario,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario
                    ]);
                }else{
                    Organigrama::create([
                        'id_puesto' => $request->id_puesto_hp,
                        'id_centro_labor' => $get_usuario->id_centro_labor,
                        'id_usuario' => $id_usuario,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario
                    ]);
                }
            }
        }else{
            echo "error_organigrama";
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
        $cantidad = HistoricoColaborador::where('id_usuario',$request->id_usuario)
                    ->where(function ($query) {
                        $query->whereNull('fec_fin')->orWhere('fec_fin', '0000-00-00');
                    })->where('estado',1)->count();
        echo $cantidad;
    }

    public function Modal_Dato_Planilla($id_usuario){
        $dato['id_usuario']=$id_usuario;
        $dato['list_situacion_laboral'] = SituacionLaboral::where('ficha',1)->where('estado',1)->get();
        $dato['list_tipo_contrato'] = TipoContrato::where('estado',1)->get();
        $dato['list_empresa'] = Empresas::where('estado', 1)->where('activo',1)->get();
        $dato['list_regimen'] = Regimen::where('estado', 1)->get();
        $dato['ultimo'] = HistoricoColaborador::where('id_usuario',$id_usuario)
                        ->whereIn('estado',[1,3,4])
                        ->orderBy('id_historico_colaborador','DESC')->first();
        $dato['cantidad'] = HistoricoColaborador::where('id_usuario',$id_usuario)
                            ->whereIn('estado',[1,3,4])->count();
        return view('rrhh.Perfil.Datos_Planilla.modal_registrar',$dato);
    }

    public function store_pl(Request $request, $id_usuario)
    {
        $request->validate([
            'id_situacion_laboral' => 'gt:0',
            'sueldo' => 'required|gt:0',
            'fec_inicio' => 'required'
        ], [
            'id_situacion_laboral.gt' => 'Debe seleccionar situación laboral.',
            'sueldo.required' => 'Debe ingresar sueldo.',
            'sueldo.gt' => 'Debe ingresar sueldo mayor a 0.',
            'fec_inicio.required' => 'Debe ingresar fecha inicio.'
        ]);

        $errors = [];
        $ultimo = HistoricoColaborador::where('id_usuario',$id_usuario)
                ->whereIn('estado',[1,3,4])
                ->orderBy('id_historico_colaborador','DESC')->first();
        if(isset($ultimo->fec_fin) && $ultimo->fec_fin!=""){
            if($request->fec_inicio<=$ultimo->fec_fin){
                $errors['ultimo'] = ['Fecha inicio no debe ser menor o igual a la fecha fin del registro anterior.'];
            }
        }
        if ($request->id_situacion_laboral=="2") {
            if($request->id_tipo_contrato=="0"){
                $errors['id_tipo_contrato'] = ['Debe seleccionar tipo contrato.'];
            }
            if($request->id_empresa=="0"){
                $errors['id_empresa'] = ['Debe seleccionar empresa.'];
            }
            if($request->id_regimen=="0"){
                $errors['id_regimen'] = ['Debe seleccionar régimen.'];
            }
            if($request->id_tipo_contrato!="1"){
                if($request->fec_vencimiento==""){
                    $errors['fec_vencimiento'] = ['Debe ingresar fecha vencimiento.'];
                }
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        Usuario::findOrFail($id_usuario)->update([
            'correo_bienvenida' => null,
            'accesos_email' => null,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        $valida_1 = HistoricoColaborador::where('id_usuario',$id_usuario)
                    ->where('id_situacion_laboral',$request->id_situacion_laboral)
                    ->where('fec_inicio',$request->fec_inicio)->whereIn('estado',[1,3])->count();
        $valida_2 = HistoricoColaborador::where('id_usuario',$id_usuario)
                    ->where(function ($query) {
                        $query->whereNull('fec_fin')->orWhere('fec_fin', '0000-00-00');
                    })->where('estado',1)->count();

        if($valida_1>0){
            echo "error";
        }elseif($valida_2>0){
            echo "incompleto";
        }else{
            HistoricoColaborador::create([
                'id_usuario' => $id_usuario,
                'id_situacion_laboral' => $request->id_situacion_laboral,
                'fec_inicio' => $request->fec_inicio,
                'fec_vencimiento' => $request->fec_vencimiento,
                'id_tipo_contrato' => $request->id_tipo_contrato,
                'id_empresa' => $request->id_empresa,
                'id_regimen' => $request->id_regimen,
                'estado_intermedio' => $request->id_tipo,
                'sueldo' => $request->sueldo,
                'bono' => $request->bono,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            //BORRAR ESTO SERÍA LO IDEAL (Para eliminar esas columnas de usuario, que solo jale del histórico)
            Usuario::findOrFail($id_usuario)->update([
                'id_situacion_laboral' => $request->id_situacion_laboral,
                'ini_funciones' => $request->fec_inicio,
                'fin_funciones' => null,
                'id_tipo_contrato' => $request->id_tipo_contrato,
                'id_empresapl' => $request->id_empresa,
                'id_regimen' => $request->id_regimen,
                'estado' => 1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            $get_id = Usuario::findOrFail($id_usuario);
            $valida = Organigrama::where('id_usuario',$id_usuario)
                    ->where('id_puesto',$get_id->id_puesto)
                    ->where('id_centro_labor',$get_id->id_centro_labor)->count();
            if($valida==0){
                $org = Organigrama::where('id_puesto',$get_id->id_puesto)
                    ->where('id_centro_labor',$get_id->id_centro_labor)->first();
                if(isset($org->id)){
                    Organigrama::findOrFail($org->id)->update([
                        'id_usuario' => $id_usuario,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario
                    ]);
                }else{
                    Organigrama::create([
                        'id_puesto' => $get_id->id_puesto,
                        'id_centro_labor' => $get_id->id_centro_labor,
                        'id_usuario' => $id_usuario,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario
                    ]);
                }
            }
        }
    }

    public function parte_superior_pl($id_usuario){
        $dato['get_id'] = HistoricoColaborador::from('historico_colaborador AS hc')
                        ->select('hc.id_historico_colaborador',
                        DB::raw("CASE WHEN hc.estado=1 THEN 'Activo'
                        WHEN hc.estado=3 AND hc.flag_cesado=1 THEN 'Cesado'
                        WHEN hc.estado=3 AND hc.flag_cesado=0 THEN 'Terminado'
                        WHEN hc.estado=4 THEN 'Renovación'
                        WHEN hc.estado=5 THEN 'Reingreso' END AS nom_estado"),
                        'sl.nom_situacion_laboral',
                        DB::raw("DATE_FORMAT(fec_inicio,'%d/%m/%Y') AS fec_inicio"),
                        'em.nom_empresa','re.nom_regimen')
                        ->join('situacion_laboral AS sl','sl.id_situacion_laboral','=','hc.id_situacion_laboral')
                        ->leftjoin('empresas AS em','em.id_empresa','=','hc.id_empresa')
                        ->leftjoin('regimen AS re','re.id_regimen','=','hc.id_regimen')
                        ->where('hc.id_usuario',$id_usuario)
                        ->whereIn('hc.estado',[1,3,4])
                        ->orderBy('hc.id_historico_colaborador','DESC')->first();
        return view('rrhh.Perfil.Datos_Planilla.parte_superior',$dato);
    }

    public function parte_inferior_pl($id_usuario){
        $dato['list_planilla'] = HistoricoColaborador::get_list_dato_planilla([
            'id_usuario'=>$id_usuario
        ]);
        return view('rrhh.Perfil.Datos_Planilla.parte_inferior',$dato);
    }

    public function edit_pl($id){
        $dato['get_id'] = HistoricoColaborador::from('historico_colaborador AS hc')
                        ->select('hc.*','us.id_motivo_baja','us.observaciones_baja')
                        ->join('users AS us','us.id_usuario','=','hc.id_usuario')
                        ->where('id_historico_colaborador',$id)->first();
        $dato['list_situacion_laboral'] = SituacionLaboral::where('ficha',1)->where('estado',1)->get();
        $dato['list_tipo_contrato'] = TipoContrato::where('estado',1)->get();
        $dato['list_empresa'] = Empresas::where('estado', 1)->where('activo',1)->get();
        $dato['list_regimen'] = Regimen::where('estado', 1)->get();
        $dato['list_motivo_cese'] = MotivoBajaRrhh::where('estado',1)->get();
        return view('rrhh.Perfil.Datos_Planilla.modal_editar',$dato);
    }

    public function update_pl(Request $request, $id)
    {
        $request->validate([
            'sueldoe' => 'required|gt:0'
        ], [
            'sueldoe.required' => 'Debe ingresar sueldo.',
            'sueldoe.gt' => 'Debe ingresar sueldo mayor a 0.'
        ]);

        $get_id = HistoricoColaborador::findOrFail($id);
        $errors = [];
        if ($get_id->id_situacion_laboral=="2") {
            if($request->id_tipo_contratoe=="0"){
                $errors['id_tipo_contratoe'] = ['Debe seleccionar tipo contrato.'];
            }
            if($request->id_empresae=="0"){
                $errors['id_empresae'] = ['Debe seleccionar empresa.'];
            }
            if($request->id_regimene=="0"){
                $errors['id_regimene'] = ['Debe seleccionar régimen.'];
            }
            if($request->id_tipo_contratoe!="1"){
                if($request->fec_vencimientoe==""){
                    $errors['fec_vencimientoe'] = ['Debe ingresar fecha vencimiento.'];
                }
            }
        }
        if($request->motivo_fin!="0"){
            if($request->fec_fin==""){
                $errors['fec_fin'] = ['Debe ingresar fecha fin.'];
            }
            if($request->fec_fin<$get_id->fec_inicio){
                $errors['fec_fin_menor'] = ['Fecha fin no debe ser menor que la fecha de inicio.'];
            }
        }
        if($request->motivo_fin=="1"){
            if($request->id_situacion_laboralr=="0"){
                $errors['id_situacion_laboralr'] = ['Debe seleccionar situación laboral (renovación).'];
            }
            if($request->fec_inicior==""){
                $errors['fec_inicior'] = ['Debe ingresar fecha inicio (renovación).'];
            }
            if($request->sueldor==""){
                $errors['sueldor'] = ['Debe ingresar sueldo (renovación).'];
            }
            if($request->sueldor=="0"){
                $errors['sueldor'] = ['Debe ingresar sueldo mayor a 0 (renovación).'];
            }
            if($request->fec_inicior<$request->fec_fin){
                $errors['fec_inicio_r_menor'] = ['Fecha inicio no debe ser menor a la fecha fin (renovación).'];
            }
            if($request->id_situacion_laboralr=="2"){
                if($request->id_tipo_contrator=="0"){
                    $errors['id_tipo_contrator'] = ['Debe seleccionar tipo contrato.'];
                }
                if($request->id_empresar=="0"){
                    $errors['id_empresar'] = ['Debe seleccionar empresa.'];
                }
                if($request->id_regimenr=="0"){
                    $errors['id_regimenr'] = ['Debe seleccionar régimen.'];
                }
                if($request->id_tipo_contrator!="1"){
                    if($request->fec_vencimientor==""){
                        $errors['fec_vencimientor'] = ['Debe ingresar fecha vencimiento.'];
                    }
                }
            }
        }
        if($request->motivo_fin=="2"){
            if($request->id_motivo_cesec=="0"){
                $errors['id_motivo_cesec'] = ['Debe seleccionar motivo de cese.'];
            }
            if($request->observacionc==""){
                $errors['observacionc'] = ['Debe ingresar observación.'];
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        HistoricoColaborador::findOrFail($id)->update([
            'id_tipo_contrato' => $request->id_tipo_contratoe,
            'id_empresa' => $request->id_empresae,
            'id_regimen' => $request->id_regimene,
            'sueldo' => $request->sueldoe,
            'bono' => $request->bonoe,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //BORRAR ESTO SERÍA LO IDEAL (Para eliminar esas columnas de usuario, que solo jale del histórico)
        Usuario::findOrFail($get_id->id_usuario)->update([
            'id_tipo_contrato' => $request->id_tipo_contratoe,
            'id_empresapl' => $request->id_empresae,
            'id_regimen' => $request->id_regimene,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($request->motivo_fin=="1"){
            $valida_1 = HistoricoColaborador::where('id_usuario',$get_id->id_usuario)
                        ->where('id_situacion_laboral',$request->id_situacion_laboralr)
                        ->where('fec_inicio',$request->fec_inicior)->whereIn('estado',[1,3])->count();
            $valida_2 = HistoricoColaborador::where('id_usuario',$get_id->id_usuario)
                        ->where(function ($query) {
                            $query->whereNull('fec_fin')->orWhere('fec_fin', '0000-00-00');
                        })->where('estado',1)->count();

            if($valida_1>0){
                echo "error";
            }elseif($valida_2>0){
                echo "incompleto";
            }else{
                HistoricoColaborador::create([
                    'id_usuario' => $get_id->id_usuario,
                    'id_situacion_laboral' => $request->id_situacion_laboralr,
                    'fec_inicio' => $request->fec_inicior,
                    'fec_vencimiento' => $request->fec_vencimientor,
                    'id_tipo_contrato' => $request->id_tipo_contrator,
                    'id_empresa' => $request->id_empresar,
                    'id_regimen' => $request->id_regimenr,
                    'estado_intermedio' => 4,
                    'sueldo' => $request->sueldor,
                    'bono' => $request->bonor,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                //BORRAR ESTO SERÍA LO IDEAL (Para eliminar esas columnas de usuario, que solo jale del histórico)
                Usuario::findOrFail($get_id->id_usuario)->update([
                    'id_situacion_laboral' => $request->id_situacion_laboralr,
                    'ini_funciones' => $request->fec_inicior,
                    'id_tipo_contrato' => $request->id_tipo_contrator,
                    'id_empresapl' => $request->id_empresar,
                    'id_regimen' => $request->id_regimenr,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                $valida = Organigrama::where('id_usuario',$get_id->id_usuario)->count();
                if($valida==0){
                    $get_id = Usuario::findOrFail($get_id->id_usuario);
                    $org = Organigrama::where('id_puesto',$get_id->id_puesto)
                        ->where('id_puesto',$get_id->id_puesto)
                        ->where('id_centro_labor',$get_id->id_centro_labor)->first();
                    if(isset($org->id)){
                        Organigrama::findOrFail($org->id)->update([
                            'id_usuario' => $get_id->id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }else{
                        Organigrama::create([
                            'id_puesto' => $get_id->id_puesto,
                            'id_centro_labor' => $get_id->id_centro_labor,
                            'id_usuario' => $get_id->id_usuario,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }
                }
            }
        }elseif($request->motivo_fin=="2"){
            
            $archivo = "";
            if($_FILES["archivo_cesec"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $path = $_FILES["archivo_cesec"]["name"];
                    $source_file = $_FILES['archivo_cesec']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Archivo_Cese_".$id."_".date('YmdHis');
                    $nombre = $nombre_soli.".".strtolower($ext);

                    ftp_pasv($con_id,true);
                    $subio = ftp_put($con_id,"PERFIL/PLANILLA/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        $archivo = "https://lanumerounocloud.com/intranet/PERFIL/PLANILLA/".$nombre;
                    }else{
                        echo "Archivo no subido correctamente";
                    }
                }else{
                    echo "No se conecto";
                }
            }

            HistoricoColaborador::findOrFail($id)->update([
                'motivo_fin' => $request->motivo_fin,
                'fec_fin' => $request->fec_fin,
                'id_motivo_cese' => $request->id_motivo_cesec,
                'archivo_cese' => $archivo,
                'observacion' => $request->observacionc,
                'flag_cesado' => 1,
                'estado' => 3,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            //BORRAR ESTO SERÍA LO IDEAL (Para eliminar esas columnas de usuario, que solo jale del histórico)
            Usuario::findOrFail($get_id->id_usuario)->update([
                'fin_funciones' => $request->fec_fin,
                'estado' => 3,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            //BORRAR USUARIO DE ORGANIGRAMA (No saldrá en lista colaborador)
            Organigrama::where('id_usuario', $get_id->id_usuario)->update([
                'id_usuario' => 0,
                'fecha' => now(),
                'usuario' => session('usuario')->id_usuario
            ]);

            $get_id = Usuario::from('users AS us')->select('pu.id_nivel', DB::raw("LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',
                    us.usuario_apater,' ',us.usuario_amater)) AS nom_usuario"),DB::raw("CASE WHEN us.id_genero=1 THEN 'el Sr.'
                    WHEN us.id_genero=2 THEN 'la Sra.' ELSE '' END AS genero"),DB::raw('LOWER(pu.nom_puesto) AS nom_puesto'))
                    ->join('puesto AS pu','pu.id_puesto','=','us.id_puesto')
                    ->where('us.id_usuario',$get_id->id_usuario)->first();

            
            if($get_id->id_nivel!=10){
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
                    $mail->addAddress('oficina@lanumero1.com.pe');
                    $mail->addAddress('tiendas@lanumero1.com.pe');
                    $mail->addAddress('cd@lanumero1.com.pe');
                    $mail->addAddress('amauta@lanumero1.com.pe');
                    $mail->addAddress('seguridadgeneral@lanumero1.com.pe');
                    $mail->addAddress('oficina@lanumero1.com.pe');
                    $mail->addAddress('seguridad.central@lanumero1.com.pe');

                    $mail->isHTML(true);

                    $mail->Subject =  "Término de Relaciones Laborales - ".ucwords($get_id->nom_usuario);

                    $mail->Body = 'Estimados colaboradores.<br><br>
                                    Esperamos que este mensaje les encuentre bien.<br><br>
                                    Nos dirigimos a ustedes para informarles que '.$get_id->genero.' '.ucwords($get_id->nom_usuario).',
                                    quien ocupaba el cargo de '. ucwords($get_id->nom_puesto).',
                                    ha concluido su relación laboral con nuestra empresa. Con el fin de proteger nuestra información corporativa,
                                    les pedimos que a partir de este momento eviten cualquier comunicación de carácter laboral con el mencionado ex colaborador.<br><br>
                                    Queremos expresar nuestro sincero agradecimiento por el tiempo y el talento que dedicó al
                                    cumplimiento de sus funciones durante su permanencia en nuestro equipo.<br><br>
                                    Reciban un cordial saludo.<br>';

                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        }
    }

    public function edit_finalizado_pl($id){
        $dato['get_id'] = HistoricoColaborador::findOrFail($id);
        return view('rrhh.Perfil.Datos_Planilla.modal_editar_finalizado',$dato);
    }

    public function update_finalizado_pl(Request $request, $id)
    {
        $request->validate([
            'fec_finf' => 'required'
        ], [
            'fec_finf.required' => 'Debe ingresar fecha fin.'
        ]);

        HistoricoColaborador::findOrFail($id)->update([
            'fec_fin' => $request->fec_finf,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        $get_id = HistoricoColaborador::findOrFail($id);
        $ultimo = HistoricoColaborador::where('id_usuario',$get_id->id_usuario)
                ->whereIn('estado',[1,3,4])
                ->orderBy('id_historico_colaborador','DESC')->first();

        if(isset($ultimo->id_historico_colaborador)){
            if($id==$ultimo->id_historico_colaborador){
                Usuario::findOrFail($get_id->id_usuario)->update([
                    'fin_funciones' => $request->fec_finf,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }
    }

    public function destroy_pl($id)
    {
        $get_id = HistoricoColaborador::findOrFail($id);
        HistoricoColaborador::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
        if($get_id->estado=="1"){
            Organigrama::where('id_usuario', $get_id->id_usuario)->update([
                'id_usuario' => 0,
                'fecha' => now(),
                'usuario' => session('usuario')->id_usuario
            ]);
        }
        $ultimo = HistoricoColaborador::where('id_usuario',$get_id->id_usuario)
                ->whereIn('estado',[1,3,4])->orderBy('id_historico_colaborador','DESC')->first();
        if(isset($ultimo->id_historico_colaborador)){
            Usuario::findOrFail($get_id->id_usuario)->update([
                'id_situacion_laboral' => $ultimo->id_situacion_laboral,
                'ini_funciones' => $ultimo->fec_inicio,
                'id_tipo_contrato' => $ultimo->id_tipo_contrato,
                'id_empresapl' => $ultimo->id_empresa,
                'id_regimen' => $ultimo->id_regimen,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
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

    public function Insert_Directorio_Telefonico(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['directorio'] = $request->input("id_respuesta_directorio_telefonico");
            $dato['num_cele'] = strtoupper($request->input("num_cele"));
            $dato['num_fijoe'] = strtoupper($request->input("num_fijoe"));
            $dato['emailp'] = strtoupper($request->input("emailp"));
            $dato['num_anexoe'] = strtoupper($request->input("num_anexoe"));

            // Limpiar los números de teléfono de caracteres no deseados
            $num_cele = str_replace("_", "", $dato['num_cele']);
            $num_fijoe = str_replace("_", "", $dato['num_fijoe']);
            $num_anexoe = str_replace("_", "", $dato['num_anexoe']);

            // Usar Eloquent para actualizar los datos del usuario
            Usuario::where('id_usuario', $dato['id_usuario'])
                ->update([
                    'directorio' => $dato['directorio'],
                    'num_cele' => $num_cele,
                    'num_fijoe' => $num_fijoe,
                    'emailp' => $dato['emailp'],
                    'num_anexoe' => $num_anexoe,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);

            $id_usuario = $request->input("id_usuariodp");
            $this->Model_Perfil = new Model_Perfil();
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);

            return view('rrhh.Perfil.directorio_telefonico', $dato);
    }

    public function Lista_GDatosP(Request $request){
        $this->Model_Perfil = new Model_Perfil();
        $dato['postulante'] = $request->input("postulante");

            if($dato['postulante']==1){
                $id_usuario= $request->input("id_usuariodp");

                $dato['list_tipo_documento'] = TipoDocumento::get();
                $dato['list_nacionalidad_perfil'] = $this->Model_Perfil->get_list_nacionalidad_perfil();
                $dato['list_genero'] = $this->Model_Perfil->get_list_genero();
                $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
                $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
                $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
                $dato['list_estado_civil'] = EstadoCivil::where('estado', 1)
                                        ->get();
                //$dato['get_id'] = $this->Model_Postulante->get_id_postulante($id_usuario);
                session('usuario')->foto = $dato['get_id'][0]['foto'];

                $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario(session('usuario')->id_usuario);

                return view('Admin/Colaborador/Perfil/datospersonales_postulante', $dato);
            }else{
                $id_usuario= $request->input("id_usuariodp");

                $dato['list_tipo_documento'] = TipoDocumento::get();
                $dato['list_nacionalidad_perfil'] = $this->Model_Perfil->get_list_nacionalidad_perfil();
                $dato['list_genero'] = $this->Model_Perfil->get_list_genero();
                $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
                $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
                $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
                $dato['list_estado_civil'] = EstadoCivil::where('estado', 1)
                                        ->get();
                $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
                //session('usuario')->foto = $dato['get_id'][0]['foto'];

                $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario(session('usuario')->id_usuario);

                return view('rrhh.Perfil.datospersonales', $dato);
            }
    }

    public function Update_GDatosP(Request $request){
            $dato['postulante'] = $request->input("ulante");
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['foto']= $request->input("foto");

            $dato['usuario_apater']= strtoupper($request->input("usuario_apater"));
            $dato['usuario_amater']= strtoupper($request->input("usuario_amater"));
            $dato['usuario_nombres']= strtoupper($request->input("usuario_nombres"));
            $dato['id_nacionalidad']= $request->input("id_nacionalidad");
            $dato['id_tipo_documento']= $request->input("id_tipo_documento");
            $dato['num_doc']= $request->input("num_doc");
            $dato['id_genero']= $request->input("id_genero");
            $dato['dia_nac']= $request->input("dia_nac");
            $dato['mes_nac']= $request->input("mes_nac");
            $dato['anio_nac']= $request->input("anio_nac");
            $dato['id_estado_civil']= $request->input("id_estado_civil");
            $dato['usuario_email']= $request->input("usuario_email");
            $dato['num_celp']= $request->input("num_celp");
            $dato['num_fijop']= $request->input("num_fijop");
            $dato['fec_nac']=$request->input("anio_nac")."-".$request->input("mes_nac")."-".$request->input("dia_nac");
            $dato['fec_emision_doc']= $request->input("fec_emision");
            $dato['fec_vencimiento_doc']= $request->input("fec_venci");
            $dato['gusto_personales']= $request->input("gusto_personales");

            $dato['foto_nombre']= $request->input("foto_nombre");
            $this->Model_Perfil = new Model_Perfil();

            $url = Config::where('id_config', 8)
                ->get()
                ->toArray();

            $dato['url_archivo'] = $url[0]['url_config'];

            if($dato['postulante']==1){
                //$dato['total'] = $this->Model_Postulante->get_id_postulante($dato['id_usuario']);

                $dato['foto']=$dato['total'][0]['foto'];
                if($_FILES['foto']['name']!=""){
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if((!$con_id) || (!$lr)){
                        echo "No se conecto";
                    }else{
                        echo "Se conecto";
                        if($_FILES['foto']['name']!=""){
                            $path = $_FILES['foto']['name'];
                            $temp = explode(".",$_FILES['foto']['name']);
                            $source_file = $_FILES['foto']['tmp_name'];

                            $fecha=date('Y-m-dHis');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="postulante_".$dato['id_usuario']."_".$fecha."_".rand(10,199);
                            $nombre = $nombre_soli.".".$ext;



                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"PERFIL/DOCUMENTACION/FOTO_PERFIL/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                $dato['ruta'] = "https://lanumerounocloud.com/intranet/POSTULANTE/".$nombre;
                                $dato['foto'] = $nombre;
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }
                }

                //$this->Model_Postulante->update_gdatosp($dato);


            }else{
                $dato['total'] = $this->Model_Perfil->get_id_usuario($dato['id_usuario']);

                $dato['foto']=$dato['total'][0]['foto'];
                $dato['foto_nombre']=$dato['total'][0]['foto_nombre'];
                if($_FILES['foto']['name']!=""){
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if((!$con_id) || (!$lr)){
                        echo "No se conecto";
                    }else{
                        echo "Se conecto";
                        if($_FILES['foto']['name']!=""){
                            $path = $_FILES['foto']['name'];
                            $temp = explode(".",$_FILES['foto']['name']);
                            $source_file = $_FILES['foto']['tmp_name'];

                            $fecha=date('Y-m-dHis');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="usuario_".$dato['id_usuario']."_".$fecha."_".rand(10,199);
                            $nombre = $nombre_soli.".".$ext;

                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"PERFIL/DOCUMENTACION/FOTO_PERFIL/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                echo "Archivo subido correctamente";
                                $dato['ruta'] = "https://lanumerounocloud.com/intranet/PERFIL/DOCUMENTACION/FOTO_PERFIL/".$nombre;
                                $dato['foto_nombre'] = $nombre;
                                $dato['foto']=$dato['ruta'];
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }
                }

                Usuario::where('id_usuario', $dato['id_usuario'])->update([
                    'usuario_apater' => addslashes($dato['usuario_apater']),
                    'usuario_amater' => addslashes($dato['usuario_amater']),
                    'usuario_nombres' => addslashes($dato['usuario_nombres']),
                    'id_nacionalidad' => $dato['id_nacionalidad'],
                    'id_tipo_documento' => $dato['id_tipo_documento'],
                    'num_doc' => $dato['num_doc'],
                    'fec_emision_doc' => $dato['fec_emision_doc'],
                    'fec_vencimiento_doc' => $dato['fec_vencimiento_doc'],
                    'id_genero' => $dato['id_genero'],
                    'dia_nac' => $dato['dia_nac'],
                    'mes_nac' => $dato['mes_nac'],
                    'anio_nac' => $dato['anio_nac'],
                    'id_estado_civil' => $dato['id_estado_civil'],
                    'usuario_email' => $dato['usuario_email'],
                    'num_celp' => $dato['num_celp'],
                    'num_fijop' => $dato['num_fijop'],
                    'fec_nac' => $dato['fec_nac'],
                    'foto' => $dato['foto'],
                    'foto_nombre' => $dato['foto_nombre'],
                    'gusto_personales' => $dato['gusto_personales'],
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);

                $id_usuario= $request->input("id_usuariodp");

                $dato['list_tipo_documento'] = TipoDocumento::get();
                $dato['list_nacionalidad_perfil'] = $this->Model_Perfil->get_list_nacionalidad_perfil();
                $dato['list_genero'] = $this->Model_Perfil->get_list_genero();
                $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
                $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
                $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
                $dato['list_estado_civil'] = EstadoCivil::where('estado', 1)
                                        ->get();
                $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
                //$_SESSION['foto']=$dato['get_id'][0]['foto'];
                $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);

                return view('rrhh.Perfil.datospersonales', $dato);
            }
    }

    /* Gustos y Preferencias*/
    public function Update_GustosP(Request $request){
            $dato['postulante'] = $request->input("postulante");

            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['plato_postre']= strtoupper($request->input("plato_postre"));
            $dato['galletas_golosinas']= strtoupper($request->input("galletas_golosinas"));
            $dato['ocio_pasatiempos']= strtoupper($request->input("ocio_pasatiempos"));
            $dato['artistas_banda']= strtoupper($request->input("artistas_banda"));
            $dato['genero_musical']= strtoupper($request->input("genero_musical"));
            $dato['pelicula_serie']= strtoupper($request->input("pelicula_serie"));
            $dato['colores_favorito']= strtoupper($request->input("colores_favorito"));
            $dato['redes_sociales']= strtoupper($request->input("redes_sociales"));
            $dato['deporte_favorito']= strtoupper($request->input("deporte_favorito"));
            $dato['tiene_mascota']= $request->input("tiene_mascota");
            $dato['mascota']= strtoupper($request->input("mascota"));

            if($dato['postulante']==1){
                //$dato['total'] = $this->Model_Postulante->get_id_postulante($dato['id_usuario']);

                //$this->Model_Postulante->update_gustos_preferencias($dato);

                $id_usuario= $request->input("id_usuariodp");

                $dato['list_tipo_documento'] = TipoDocumento::get();
                $dato['list_nacionalidad_perfil'] = $this->Model_Perfil->get_list_nacionalidad_perfil();
                $dato['list_genero'] = $this->Model_Perfil->get_list_genero();
                //$dato['get_id'] = $this->Model_Postulante->get_id_postulante($id_usuario);
                $_SESSION['foto']=$dato['get_id'][0]['foto'];

                $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($_SESSION['usuario'][0]['id_usuario']);

                return view('rrhh.Perfil.datospersonales_postulante', $dato);
            }else{
                $dato['total'] = GustoPreferenciaUsers::where('id_usuario', $dato['id_usuario'])
                            ->where('estado', 1)
                            ->get();

                if($dato['total']){
                    GustoPreferenciaUsers::where('id_usuario', $dato['id_usuario'])->update([
                        'plato_postre' => addslashes($dato['plato_postre']),
                        'galletas_golosinas' => addslashes($dato['galletas_golosinas']),
                        'ocio_pasatiempos' => addslashes($dato['ocio_pasatiempos']),
                        'artistas_banda' => addslashes($dato['artistas_banda']),
                        'genero_musical' => addslashes($dato['genero_musical']),
                        'pelicula_serie' => addslashes($dato['pelicula_serie']),
                        'colores_favorito' => addslashes($dato['colores_favorito']),
                        'redes_sociales' => addslashes($dato['redes_sociales']),
                        'deporte_favorito' => addslashes($dato['deporte_favorito']),
                        'tiene_mascota' => $dato['tiene_mascota'],
                        'mascota' => addslashes($dato['mascota']),
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario,
                    ]);
                }else{
                    GustoPreferenciaUsers::create([
                        'id_usuario' => $dato['id_usuario'],
                        'plato_postre' => $dato['plato_postre'],
                        'galletas_golosinas' => $dato['galletas_golosinas'],
                        'ocio_pasatiempos' => $dato['ocio_pasatiempos'],
                        'artistas_banda' => $dato['artistas_banda'],
                        'genero_musical' => $dato['genero_musical'],
                        'pelicula_serie' => $dato['pelicula_serie'],
                        'colores_favorito' => $dato['colores_favorito'],
                        'redes_sociales' => $dato['redes_sociales'],
                        'deporte_favorito' => $dato['deporte_favorito'],
                        'tiene_mascota' => $dato['tiene_mascota'],
                        'mascota' => $dato['mascota'],
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'estado' => 1,
                    ]);
                }

                $id_usuario= $request->input("id_usuariodp");

                $dato['get_id_gp'] = GustoPreferenciaUsers::where('id_usuario', $id_usuario)
                            ->where('estado', 1)
                            ->get();

                return view('rrhh.Perfil.gustosypreferencias', $dato);
            }
    }

    public function Habilitar_Edicion_Perfil(Request $request){
            $dato['id_usuario']= $request->input("id_usuario");
            $dato['estado_edicion']= $request->input("estado_edicion");
            // Verificar el valor de estado_edicion y establecer perf_revisado
            $perf_revisado = ($dato['estado_edicion'] == 0) ? 1 : 0;

            // Realizar la actualización usando Eloquent
            Usuario::where('id_usuario', $dato['id_usuario'])
                ->update([
                    'edicion_perfil' => $dato['estado_edicion'],
                    'perf_revisado' => $perf_revisado,
                    'fec_edi_perfil' => now(),
                    'user_edi_perfil' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
    }

    public function Confirmar_Revision_Perfil(Request $request){
            $dato['id_usuario']= $request->input("id_usuario");

            $id_usuario = session('usuario')->id_usuario;

            Usuario::where('id_usuario', $dato['id_usuario'])
                ->update([
                    'perf_revisado' => 1,
                    'fec_perf_revisado' => now(),
                    'user_perf_revisado' => $id_usuario,
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
    }

    public function Update_DomilcilioP(Request $request){
        $this->Model_Perfil = new Model_Perfil();
            $dato['postulante'] = $request->input("ulante");

            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_departamento']= $request->input("id_departamento");
            $dato['id_provincia']= $request->input("id_provincia");
            $dato['id_distrito']= $request->input("id_distrito");
            $dato['id_tipo_via']= $request->input("id_tipo_via");
            $dato['nom_via']= strtoupper($request->input("nom_via"));
            $dato['num_via']= strtoupper($request->input("num_via"));
            $dato['id_zona']= $request->input("id_zona");
            $dato['nom_zona']= strtoupper($request->input("nom_zona"));
            $dato['kilometro']= strtoupper($request->input("kilometro"));
            $dato['manzana']= strtoupper($request->input("manzana"));
            $dato['lote']= strtoupper($request->input("lote"));
            $dato['interior']= strtoupper($request->input("interior"));
            $dato['departamento']= strtoupper($request->input("departamento"));
            $dato['piso']= strtoupper($request->input("piso"));

            $dato['referencia']= $request->input("referenciaa");
            $dato['id_tipo_vivienda']= $request->input("id_tipo_vivienda");
            $dato['lat']= $request->input("coordsltd");
            $dato['lng']= $request->input("coordslgt");

            $id_usuario= $request->input("id_usuariodp");

            if($dato['postulante']==1){
                /*
                $dato['get_id_d'] = $this->Model_Postulante->get_id_domicilio_usersp($dato['id_usuario']);
                if(count($dato['get_id_d'])>0)
                {
                    $this->Model_Postulante->update_domiciliop($dato);
                }
                else{
                    $this->Model_Postulante->insert_domiciliop($dato);
                }

                $dato['list_dtipo_via'] = $this->Model_Corporacion->get_id_dtipo_via();
                $dato['list_zona'] = $this->Model_Corporacion->get_list_zona();
                $dato['list_dtipo_vivienda'] = $this->Model_Corporacion->get_id_dtipo_vivienda();
                $dato['list_departamento'] = $this->Model_Corporacion->get_list_departamento();
                $dato['list_provincia'] = $this->Model_Corporacion->get_list_provincia();
                $dato['list_distrito'] = $this->Model_Corporacion->get_list_distrito();
                $dato['get_id_d'] = $this->Model_Postulante->get_id_domicilio_usersp($id_usuario);
                return view('Admin/Colaborador/Perfil/domiciliop', $dato);
                */
            }else{
                $dato['get_id_d'] = DomicilioUsers::get_id_domicilio_users($dato['id_usuario']);
                if(count($dato['get_id_d'])>0)
                {
                    $id_usuario = session('usuario')->id_usuario;
                    DomicilioUsers::where('id_usuario', $dato['id_usuario'])->update([
                            'id_usuario' => $dato['id_usuario'],
                            'id_departamento' => $dato['id_departamento'],
                            'id_provincia' => $dato['id_provincia'],
                            'id_distrito' => $dato['id_distrito'],
                            'id_tipo_via' => $dato['id_tipo_via'],
                            'nom_via' => $dato['nom_via'],
                            'num_via' => $dato['num_via'],
                            'id_zona' => $dato['id_zona'],
                            'nom_zona' => $dato['nom_zona'],
                            'referencia' => $dato['referencia'],
                            'kilometro' => $dato['kilometro'],
                            'manzana' => $dato['manzana'],
                            'lote' => $dato['lote'],
                            'interior' => $dato['interior'],
                            'departamento' => $dato['departamento'],
                            'piso' => $dato['piso'],
                            'id_tipo_vivienda' => $dato['id_tipo_vivienda'],
                            'lat' => $dato['lat'],
                            'lng' => $dato['lng'],
                            'fec_act' => now(),
                            'user_act' => $id_usuario,
                        ]);
                }
                else{
                    DomicilioUsers::create([
                        'id_usuario' => $dato['id_usuario'],
                        'id_departamento' => $dato['id_departamento'],
                        'id_provincia' => $dato['id_provincia'],
                        'id_distrito' => $dato['id_distrito'],
                        'id_tipo_via' => $dato['id_tipo_via'],
                        'nom_via' => $dato['nom_via'],
                        'num_via' => $dato['num_via'],
                        'id_zona' => $dato['id_zona'],
                        'nom_zona' => $dato['nom_zona'],
                        'referencia' => $dato['referencia'],
                        'id_tipo_vivienda' => $dato['id_tipo_vivienda'],
                        'kilometro' => $dato['kilometro'],
                        'manzana' => $dato['manzana'],
                        'lote' => $dato['lote'],
                        'interior' => $dato['interior'],
                        'departamento' => $dato['departamento'],
                        'piso' => $dato['piso'],
                        'lat' => $dato['lat'],
                        'lng' => $dato['lng'],
                        'fec_reg' => now(),
                        'user_reg' => $id_usuario,
                        'estado' => 1
                    ]);
                }

                $dato['list_dtipo_via'] = TipoVia::get();
                $dato['list_zona'] = Zona::where('estado', 1)
                                ->get();

                $dato['list_dtipo_vivienda'] = TipoVivienda::get();
                $dato['list_departamento'] = DB::table('departamento')
                                            ->where('estado', 1)
                                            ->get();
                $dato['list_provincia'] = DB::table('provincia')
                                            ->where('estado', 1)
                                            ->get();
                $dato['list_distrito'] = DB::table('distrito')
                                            ->where('estado', 1)
                                            ->get();
                $dato['get_id_d'] = $this->Model_Perfil->get_id_domicilio_users($id_usuario);
                return view('rrhh.Perfil.domicilio', $dato);
            }
    }

    public function Update_DomilcilioP_Titulo(Request $request){
        $this->Model_Perfil = new Model_Perfil();
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['get_id_d'] = $this->Model_Perfil->get_id_domicilio_users($dato['id_usuario']);
            return view('rrhh.Perfil.domicilio_titulos', $dato);
    }

    /*********************************************************************************** */
    public function Insert_ReferenciaF(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['nom_familiar'] = strtoupper($request->input("nom_familiar"));
            $dato['id_parentesco'] = $request->input("id_parentesco");
            $dato['dia_nacf'] = $request->input("dia_nacf");
            $dato['mes_nacf'] = $request->input("mes_nacf");
            $dato['anio_nacf'] = $request->input("anio_nacf");
            $dato['celular1'] = $request->input("celular1");
            $dato['celular2'] = $request->input("celular2");
            $dato['fijo'] = $request->input("fijo");
            $dato['fec_nac'] = $request->input("anio_nacf")."-".$request->input("mes_nacf")."-".$request->input("dia_nacf");

            $id_usuario = session('usuario')->id_usuario; // Obtener el ID del usuario desde la sesión

            ReferenciaFamiliar::create([
                'id_usuario' => $dato['id_usuario'],
                'nom_familiar' => $dato['nom_familiar'],
                'id_parentesco' => $dato['id_parentesco'],
                'dia_nac' => $dato['dia_nacf'],
                'mes_nac' => $dato['mes_nacf'],
                'anio_nac' => $dato['anio_nacf'],
                'celular1' => $dato['celular1'],
                'celular2' => $dato['celular2'],
                'fijo' => $dato['fijo'],
                'fec_nac' => $dato['fec_nac'],
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1
            ]);

            $dato['list_referenciafu'] = ReferenciaFamiliar::get_list_referenciafu($dato['id_usuario']);

            return view('rrhh.Perfil.Referencia_Familiar.ldatos', $dato);
    }

    public function Detalle_Referencia_Familiar(Request $request){
            $id_referencia_familiar= $request->input("id_referencia_familiar");
            $this->Model_Perfil = new Model_Perfil();

            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            $dato['list_parentesco'] = Parentesco::where('estado', 1)
                                        ->get();
            $dato['get_id'] = ReferenciaFamiliar::get_list_referenciaf($id_referencia_familiar);
            return view('rrhh.Perfil.Referencia_Familiar.editar', $dato);
    }

    public function Update_ReferenciaF(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['id_referencia_familiar'] = $request->input("id_referencia_familiar");
            $dato['nom_familiar'] = strtoupper($request->input("nom_familiar"));
            $dato['id_parentesco'] = $request->input("id_parentesco");
            $dato['dia_nacf'] = $request->input("dia_nacf");
            $dato['mes_nacf'] = $request->input("mes_nacf");
            $dato['anio_nacf'] = $request->input("anio_nacf");
            $dato['celular1'] = $request->input("celular1");
            $dato['celular2'] = $request->input("celular2");
            $dato['fijo'] = $request->input("fijo");
            $dato['fec_nac'] = $request->input("anio_nacf")."-".$request->input("mes_nacf")."-".$request->input("dia_nacf");

            $id_usuario = session('usuario')->id_usuario;

            ReferenciaFamiliar::where('id_referencia_familiar', $dato['id_referencia_familiar'])
                ->update([
                    'id_usuario' => $dato['id_usuario'],
                    'nom_familiar' => $dato['nom_familiar'],
                    'id_parentesco' => $dato['id_parentesco'],
                    'dia_nac' => $dato['dia_nacf'],
                    'mes_nac' => $dato['mes_nacf'],
                    'anio_nac' => $dato['anio_nacf'],
                    'celular1' => $dato['celular1'],
                    'celular2' => $dato['celular2'],
                    'fijo' => $dato['fijo'],
                    'fec_nac' => $dato['fec_nac'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);

            $data['list_referenciafu'] = ReferenciaFamiliar::get_list_referenciafu($dato['id_usuario']);

            return view('rrhh.Perfil.Referencia_Familiar.ldatos', $data);
    }

    public function MDatos_ReferenciaF(){
        $this->Model_Perfil = new Model_Perfil();
        $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
        $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
        $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
        $dato['list_parentesco'] = Parentesco::where('estado', 1)
                                    ->get();
            return view('rrhh.Perfil.Referencia_Familiar.index', $dato);
    }

    public function Delete_Referencia_Familiar(Request $request, $id_referencia_familiar=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();

            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['id_usuario'] = $get_id[0]['id_usuario'];

            $dato['id_referencia_familiar']= $request->input("id_referencia_familiar");
            $dato['id_usuario']= $request->input("id_usuario");

            $id_usuario = session('usuario')->id_usuario;

            ReferenciaFamiliar::where('id_referencia_familiar', $dato['id_referencia_familiar'])
                ->update([
                    'estado' => 2,
                    'fec_eli' => now(),
                    'user_eli' => $id_usuario,
                ]);

            $dato['list_referenciafu'] = ReferenciaFamiliar::get_list_referenciafu($dato['id_usuario']);
            return view('rrhh.Perfil.Referencia_Familiar.ldatos', $dato);
    }

    /*********************************************************************************** */
    public function Lista_Hijos(Request $request){
            $id_usuario= $request->input("id_usuarioh");
            $dato['list_hijosu'] = Hijos::get_list_hijosu($id_usuario);
            $dato['url'] = Config::where('descrip_config','Datos_Hijos')
                ->where('estado', 1)
                ->get();
            return view('rrhh.Perfil.Hijos.ldatos', $dato);
    }

    public function Insert_Hijos_Usuario(Request $request){
            $dato['id_usuarioh'] = $request->input("id_usuarioh");
            $dato['nom_hijo'] = strtoupper($request->input("nom_hijo"));
            $dato['id_genero'] = $request->input("id_generoh");
            $dato['dia_nac'] = $request->input("dia_nachj");
            $dato['mes_nac'] = $request->input("mes_nachj");
            $dato['anio_nac'] = $request->input("anio_nachj");
            $dato['num_doc'] = $request->input("num_dochj");
            $dato['id_biologico'] = $request->input("id_biologico");
            $dato['fijo'] = $request->input("fijo");
            $dato['fec_nac'] = $request->input("anio_nachj")."-".$request->input("mes_nachj")."-".$request->input("dia_nachj");
            $dato['id_respuestah'] = $request->input("id_respuestah");
            $dato['documento'] = $request->input("documento");

            $dato['archivo']="";

            if($_FILES["documento"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['documento']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['documento']['name']);
                        $source_file = $_FILES['documento']['tmp_name'];

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
                            $nombre="dochijo_".$dato['id_usuarioh']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/DATOS_HIJOS/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);

                    }
                    ftp_close($con_id);
                }
            }
            $id_usuario = session('usuario')->id_usuario;

            Usuario::where('id_usuario', $dato['id_usuarioh'])
                ->update([
                    'hijos' => $dato['id_respuestah'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
            if ($dato['id_respuestah'] == 1) {
                Hijos::create([
                    'id_usuario' => $dato['id_usuarioh'],
                    'nom_hijo' => $dato['nom_hijo'],
                    'id_genero' => $dato['id_genero'],
                    'dia_nac' => $dato['dia_nac'],
                    'mes_nac' => $dato['mes_nac'],
                    'anio_nac' => $dato['anio_nac'],
                    'id_biologico' => $dato['id_biologico'],
                    'num_doc' => $dato['num_doc'],
                    'documento' => $dato['archivo'],
                    'fec_nac' => $dato['fec_nac'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1,
                    'id_tipo_documento' => 0,
                    'id_vinculo' => 0,
                    'id_situacion' => 0,
                    'id_motivo_baja' => 0,
                    'id_tipo_via' => 0,
                    'id_zona' => 0,
                    'carta_medica' => 0,
                    'n_certificado_medico' => 0,
                    'nom_via' => 0,
                    'num_via' => 0,
                    'interior' => 0,
                    'nom_zona' => 0,
                    'referencia' => 0,
                    'documento_nombre' => 0,
                ]);
            } else {
                // Si id_respuestah no es igual a 1, se actualiza el estado de hijos
                Hijos::where('id_usuario', $dato['id_usuarioh'])
                    ->update([
                        'estado' => 2,
                        'fec_act' => now(),
                        'user_act' => $id_usuario,
                    ]);
            }

    }

    public function Detalle_Hijos_Usuario(Request $request){
        $this->Model_Perfil = new Model_Perfil();

            $id_hijos= $request->input("id_hijos");
            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            $dato['list_genero'] = $this->Model_Perfil->get_list_genero();
            $dato['get_id'] = Hijos::get_list_hijosd($id_hijos);
            $dato['url_dochijo'] = Config::where('descrip_config','Datos_Hijos')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Hijos.editar', $dato);
    }

    public function Update_Hijos(Request $request){
            $dato['id_usuarioh'] = $request->input("id_usuarioh");
            $dato['id_hijos'] = $request->input("id_hijos");
            $dato['nom_hijo'] = strtoupper($request->input("nom_hijo"));
            $dato['id_genero'] = $request->input("id_generoh");
            $dato['dia_nac'] = $request->input("dia_nachj");
            $dato['mes_nac'] = $request->input("mes_nachj");
            $dato['anio_nac'] = $request->input("anio_nachj");
            $dato['num_doc'] = $request->input("num_dochj");
            $dato['id_biologico'] = $request->input("id_biologico");
            $dato['fec_nac'] = $request->input("anio_nachj")."-".$request->input("mes_nachj")."-".$request->input("dia_nachj");
            $dato['id_respuestah'] = $request->input("id_respuestah");
            $dato['documento'] = $request->input("documento");
            $dato['documento_nombre'] = $request->input("documento_nombre");
            $dato['total'] = Hijos::get_list_hijosu($dato['id_usuarioh']);

            $dato['get_id'] = Hijos::get_list_hijosd($dato['id_hijos']);
            $dato['archivo']=$dato['get_id'][0]['documento'];

            if($_FILES["documento"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                }else{
                    $path = $_FILES['documento']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['documento']['name']);
                        $source_file = $_FILES['documento']['tmp_name'];

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
                            $nombre="dochijo_".$dato['id_hijos']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/DATOS_HIJOS/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['archivo'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    ftp_close($con_id);
                }
            }
            $id_usuario = session('usuario')->id_usuario;

            Usuario::where('id_usuario', $dato['id_usuarioh'])
                ->update([
                    'hijos' => $dato['id_respuestah'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);

        if ($request->id_respuestah == 1) {
            Hijos::where('id_hijos', $request->id_hijos)
                ->update([
                    'id_usuario' => $request->id_usuarioh,
                    'nom_hijo' => $request->nom_hijo,
                    'id_genero' => $request->id_generoh,
                    'dia_nac' => $request->dia_nachj,
                    'mes_nac' => $request->mes_nachj,
                    'anio_nac' => $request->anio_nachj,
                    'id_biologico' => $request->id_biologico,
                    'num_doc' => $request->num_dochj,
                    'documento' => $request->documento,
                    'fec_nac' => $dato['fec_nac'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
        } else {
            Hijos::where('id_usuario', $request->id_usuarioh)
                ->update([
                    'estado' => 2,
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
        }
    }

    public function MDatos_Hijos(Request $request){
        $this->Model_Perfil = new Model_Perfil();

            $id_usuario = $request->input("id_usuarioh");
            $dato['list_genero'] = $this->Model_Perfil->get_list_genero();
            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();

            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            return view('rrhh.Perfil.Hijos.index', $dato);
    }

    public function Delete_Hijos_Usuario(Request $request, $id_hijos=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();
        $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
        $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
        $dato['id_usuario'] = $get_id[0]['id_usuario'];
        $dato['id_hijos']= $request->input("id_hijos");
        $dato['id_usuario']= $request->input("id_usuario");

        $id_usuario = session('usuario')->id_usuario;

        Hijos::where('id_hijos', $dato['id_hijos'])
            ->update([
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => $id_usuario,
            ]);
    }

    /******************************* */
    public function Insert_ContactoE(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['nom_contacto'] = strtoupper($request->input("nom_contacto"));
            $dato['id_parentesco'] = $request->input("id_parentescoce");
            $dato['celular1'] = $request->input("celular1ce");
            $dato['celular2'] = $request->input("celular2ce");
            $dato['fijo'] = $request->input("fijoce");

            ContactoEmergencia::create([
                'id_usuario' => $dato['id_usuario'],
                'nom_contacto' => $dato['nom_contacto'],
                'id_parentesco' => $dato['id_parentesco'],
                'celular1' => $dato['celular1'],
                'celular2' => $dato['celular2'],
                'fijo' => $dato['fijo'],
                'fec_reg' => now(), // Fecha de registro
                'user_reg' => session('usuario')->id_usuario, // Usuario que registra
                'estado' => 1, // Estado activo
            ]);

            $dato['list_contactoeu'] = ContactoEmergencia::get_list_contactoeu($dato['id_usuario']);
            return view('rrhh.Perfil.Contacto_Emergencia.ldatos', $dato);
    }

    public function Update_ContactoE(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['id_contacto_emergencia'] = $request->input("id_contacto_emergencia");
            $dato['nom_contacto'] = strtoupper($request->input("nom_contacto"));
            $dato['id_parentesco'] = $request->input("id_parentescoce");
            $dato['celular1'] = $request->input("celular1ce");
            $dato['celular2'] = $request->input("celular2ce");
            $dato['fijo'] = $request->input("fijoce");
            $id_usuario = session('usuario')->id_usuario;

            ContactoEmergencia::where('id_contacto_emergencia', $dato['id_contacto_emergencia'])
            ->update([
                'id_usuario' => $dato['id_usuario'],
                'nom_contacto' => $dato['nom_contacto'],
                'id_parentesco' => $dato['id_parentesco'],
                'celular1' => $dato['celular1'],
                'celular2' => $dato['celular2'],
                'fijo' => $dato['fijo'],
                'fec_act' => now(), // Fecha de actualización
                'user_act' => $id_usuario, // Usuario que actualiza
            ]);
            $dato['list_contactoeu'] = ContactoEmergencia::get_list_contactoeu($dato['id_usuario']);
            return view('rrhh.Perfil.Contacto_Emergencia.ldatos', $dato);
    }

    public function MDatos_ContactoE(){
        $dato['list_parentesco'] = Parentesco::where('estado', 1)
                                    ->get();
            return view('rrhh.Perfil.Contacto_Emergencia.index', $dato);
    }

    public function Detalle_ContactoE(Request $request){
            $id_contacto_emergencia= $request->input("id_contacto_emergencia");
            $dato['list_parentesco'] = Parentesco::where('estado', 1)
                                        ->get();

            $dato['get_id'] = ContactoEmergencia::get_list_contactoe($id_contacto_emergencia);
            return view('rrhh.Perfil.Contacto_Emergencia.editar', $dato);
    }

    public function Delete_ContactoE(Request $request, $id_contacto_emergencia=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();

            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['id_usuario'] = $get_id[0]['id_usuario'];

            $dato['id_contacto_emergencia']= $request->input("id_contacto_emergencia");

            $dato['id_usuario']= $request->input("id_usuario");

            ContactoEmergencia::where('id_contacto_emergencia', $dato['id_contacto_emergencia'])
            ->update([
                'estado' => 2, // Marcado como eliminado
                'fec_eli' => now(), // Fecha de eliminación
                'user_eli' => $id_usuario, // Usuario que realizó la eliminación
            ]);

            $dato['list_contactoeu'] = ContactoEmergencia::get_list_contactoeu($dato['id_usuario']);

            return view('rrhh.Perfil.Contacto_Emergencia.ldatos', $dato);
    }


    /*********************************************************************************** */
    public function Lista_EstudiosG(Request $request){
            $id_usuario = $request->input("id_usuariodp");
            $dato['list_estudiosgu'] = EstudiosGenerales::get_list_estudiosgu($id_usuario);
            $dato['url_estudiog'] = Config::where('descrip_config','Estudios_Generales')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Estudios_Generales.ldatos', $dato);
    }

    public function Insert_EstudiosG(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_grado_instruccion'] = $request->input("id_grado_instruccion");
            $dato['carrera'] = strtoupper($request->input("carrera"));
            $dato['centro'] = strtoupper($request->input("centro"));

            $dato['archivo']="";

            if($_FILES["documentoe"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['documentoe']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['documentoe']['name']);
                        $source_file = $_FILES['documentoe']['tmp_name'];

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
                            $nombre="docestudio_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/ESTUDIOS_GENERALES/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['archivo'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    ftp_close($con_id);
                }
            }
            $id_usuario = session('usuario')->id_usuario;

            EstudiosGenerales::create([
                'id_usuario' => $dato['id_usuario'],
                'id_grado_instruccion' => $dato['id_grado_instruccion'],
                'carrera' => $dato['carrera'],
                'centro' => $dato['centro'],
                'documentoe' => $dato['archivo'],
                'documentoe_nombre' => 0,
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1
            ]);
    }

    public function Detalle_EstudiosG(Request $request){
            $id_estudios_generales= $request->input("id_estudios_generales");
            $dato['list_grado_instruccion'] = GradoInstruccion::where('estado', 1)
                                        ->get();
            $dato['get_id'] = EstudiosGenerales::get_list_estudiosge($id_estudios_generales);
            $dato['url_estudiog'] = Config::where('descrip_config','Estudios_Generales')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Estudios_Generales.editar', $dato);
    }

    public function MDatos_EstudiosG(){
            $dato['list_grado_instruccion'] = GradoInstruccion::where('estado', 1)
                                        ->get();
            return view('rrhh.Perfil.Estudios_Generales.index', $dato);
    }

    public function Update_EstudiosG(Request $request){
            $dato['id_estudios_generales'] = $request->input("id_estudios_generales");
           // $dato['id_usuario'] = $_SESSION['usuario'][0]['id_usuario'];
           $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_grado_instruccion'] = $request->input("id_grado_instruccion");
            $dato['carrera'] = strtoupper($request->input("carrera"));
            $dato['centro'] = strtoupper($request->input("centro"));
            $dato['documentoe'] = strtoupper($request->input("documentoe"));
            $dato['documentoe_nombre'] = strtoupper($request->input("documentoe_nombre"));

            $dato['total'] = EstudiosGenerales::get_list_estudiosgu($dato['id_usuario']);

            $dato['archivo']="";
            if(count($dato['total'])>0){
                $dato['archivo']=$dato['total'][0]['documentoe'];
            }

            if($_FILES["documentoe"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['documentoe']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['documentoe']['name']);
                        $source_file = $_FILES['documentoe']['tmp_name'];

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
                            $nombre="docestudio_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/ESTUDIOS_GENERALES/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['archivo'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    ftp_close($con_id);
                }
            }
            $id_usuario = session('usuario')->id_usuario;

            EstudiosGenerales::where('id_estudios_generales', $dato['id_estudios_generales'])
                ->update([
                    'id_usuario' => $dato['id_usuario'],
                    'id_grado_instruccion' => $dato['id_grado_instruccion'],
                    'carrera' => $dato['carrera'],
                    'centro' => $dato['centro'],
                    'documentoe' => $dato['archivo'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);
    }

    public function Delete_EstudiosG(Request $request, $id_estudios_generales=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();

            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['id_usuario'] = $get_id[0]['id_usuario'];

            $dato['id_estudios_generales']= $request->input("id_estudios_generales");

            $dato['id_usuario']= $request->input("id_usuario");

            $id_usuario = session('usuario')->id_usuario;

            EstudiosGenerales::where('id_estudios_generales', $dato['id_estudios_generales'])
                ->update([
                    'estado' => 2,
                    'fec_eli' => now(),
                    'user_eli' => $id_usuario
                ]);
    }

    /********************************************************* */
    public function Update_Conoci_Office(Request $request){
        $this->Model_Perfil = new Model_Perfil();

            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_nivel_conocimiento']= $request->input("id_nivel_conocimiento");
            $dato['nl_excel']= $request->input("nl_excel");
            $dato['nl_word']= $request->input("nl_word");
            $dato['nl_ppoint']= $request->input("nl_ppoint");

            $dato['get_id_c'] = ConociOffice::get_id_conoci_office($dato['id_usuario']);

            $id_usuario = session('usuario')->id_usuario;

            if(count($dato['get_id_c'])>0){
                ConociOffice::where('id_usuario', $dato['id_usuario'])
                    ->update([
                        'id_nivel_conocimiento' => $dato['id_nivel_conocimiento'],
                        'nl_excel' => $dato['nl_excel'],
                        'nl_word' => $dato['nl_word'],
                        'nl_ppoint' => $dato['nl_ppoint'],
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            }else{
                ConociOffice::create([
                    'id_usuario' => $dato['id_usuario'],
                    'id_nivel_conocimiento' => $dato['id_nivel_conocimiento'],
                    'nl_excel' => $dato['nl_excel'],
                    'nl_word' => $dato['nl_word'],
                    'nl_ppoint' => $dato['nl_ppoint'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1
                ]);
            }

            $dato['list_nivel_instruccion'] = $this->Model_Perfil->get_list_nivel_instruccion();
            $dato['get_id_c'] = ConociOffice::get_id_conoci_office($dato['id_usuario']);
            return view('rrhh.Perfil.conoci_office', $dato);
    }

    /******************************************************** */

    public function Insert_Conoci_Idiomas(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['nom_conoci_idiomas'] = strtoupper($request->input("nom_conoci_idiomas"));
            $dato['lect_conoci_idiomas'] = $request->input("lect_conoci_idiomas");
            $dato['escrit_conoci_idiomas'] = $request->input("escrit_conoci_idiomas");
            $dato['conver_conoci_idiomas'] = $request->input("conver_conoci_idiomas");

            $id_usuario = session('usuario')->id_usuario;

            ConociIdiomas::create([
                'id_usuario' => $dato['id_usuario'],
                'nom_conoci_idiomas' => $dato['nom_conoci_idiomas'],
                'lect_conoci_idiomas' => $dato['lect_conoci_idiomas'],
                'escrit_conoci_idiomas' => $dato['escrit_conoci_idiomas'],
                'conver_conoci_idiomas' => $dato['conver_conoci_idiomas'],
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'estado' => 1
            ]);

            $dato['listar_idiomas'] = ConociIdiomas::get_list_idiomasu($dato['id_usuario']);
            return view('rrhh.Perfil.Idioma.ldatos', $dato);
    }

    public function MDatos_Idiomas(){
        $this->Model_Perfil = new Model_Perfil();
        $dato['list_idiomas'] = Idioma::where('estado', 1)
                            ->get();
            $dato['list_nivel_instruccion'] = $this->Model_Perfil->get_list_nivel_instruccion();
            return view('rrhh.Perfil.Idioma.index', $dato);
    }

    public function Update_Conoci_Idiomas(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_conoci_idiomas'] = $request->input("id_conoci_idiomas");
            $dato['nom_conoci_idiomas'] = $request->input("nom_conoci_idiomas");
            $dato['lect_conoci_idiomas'] = $request->input("lect_conoci_idiomas");
            $dato['escrit_conoci_idiomas'] = $request->input("escrit_conoci_idiomas");
            $dato['conver_conoci_idiomas'] = $request->input("conver_conoci_idiomas");

            $id_usuario = session('usuario')->id_usuario;

            ConociIdiomas::where('id_conoci_idiomas', $dato['id_conoci_idiomas'])
                ->update([
                    'id_usuario' => $dato['id_usuario'],
                    'nom_conoci_idiomas' => $dato['nom_conoci_idiomas'],
                    'lect_conoci_idiomas' => $dato['lect_conoci_idiomas'],
                    'escrit_conoci_idiomas' => $dato['escrit_conoci_idiomas'],
                    'conver_conoci_idiomas' => $dato['conver_conoci_idiomas'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);

            $dato['listar_idiomas'] = ConociIdiomas::get_list_idiomasu($dato['id_usuario']);
            return view('rrhh.Perfil.Idioma.ldatos', $dato);
    }

    public function Detalle_Conoci_Idiomas(Request $request){
        $this->Model_Perfil = new Model_Perfil();
            $id_conoci_idiomas = $request->input("id_conoci_idiomas");
            $dato['list_idiomas'] = Idioma::where('estado', 1)
                                ->get();
            $dato['list_nivel_instruccion'] = $this->Model_Perfil->get_list_nivel_instruccion();
            $dato['get_id'] = ConociIdiomas::get_list_idiomase($id_conoci_idiomas);
            return view('rrhh.Perfil.Idioma.editar', $dato);
    }

    public function Delete_Conoci_Idiomas(Request $request, $id_hijos=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['id_usuario'] = $get_id[0]['id_usuario'];

            $dato['id_usuario']= $request->input("id_usuario");


            $dato['id_conoci_idiomas']= $request->input("id_conoci_idiomas");

            $id_usuario = session('usuario')->id_usuario;

            ConociIdiomas::where('id_conoci_idiomas', $dato['id_conoci_idiomas'])
                ->update([
                    'estado' => 2,
                    'fec_eli' => now(),
                    'user_eli' => $id_usuario
                ]);
            $dato['listar_idiomas'] = ConociIdiomas::get_list_idiomasu($dato['id_usuario']);

            return view('rrhh.Perfil.Idioma.ldatos', $dato);
    }
    /************************************************************** */
    public function Lista_CursosC(Request $request){
            $id_usuario = $request->input("id_usuariodp");
            $dato['listar_cursosc'] = CursoComplementario::get_list_cursoscu($id_usuario);
            $dato['url_cursosc'] = Config::where('descrip_config','Cursos_Complementarios')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Curso_Complementario.ldatos',$dato);
    }

    public function Insert_CursosC(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['nom_curso_complementario'] = strtoupper($request->input("nom_curso_complementario"));
            $dato['anio'] = $request->input("aniocc");
            $dato['actualidad'] = $request->input("aniocc");
            $dato['certificado'] = $request->input("certificado");

            $dato['archivo']="";

            if($_FILES["certificado"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['certificado']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['certificado']['name']);
                        $source_file = $_FILES['certificado']['tmp_name'];

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
                            $nombre="cursocomp_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/CURSOS_COMPLEMENTARIOS/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['archivo'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    ftp_close($con_id);
                }
            }

            $id_usuario = session('usuario')->id_usuario;

            CursoComplementario::create([
                'id_usuario' => $dato['id_usuario'],
                'nom_curso_complementario' => $dato['nom_curso_complementario'],
                'anio' => $dato['anio'],
                'certificado' => $dato['archivo'],
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => $id_usuario,
                'actualidad' => 0,
                'certificado_nombre' => 0,
            ]);
    }

    public function Update_CursosC(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['id_curso_complementario'] = $request->input("id_curso_complementario");
            $dato['nom_curso_complementario'] = strtoupper($request->input("nom_curso_complementario"));
            $dato['anio'] = $request->input("aniocc");

            $dato['archivo']="";
            $dato['get_id'] = CursoComplementario::get_list_cursosce($dato['id_curso_complementario']);
            if(count($dato['get_id'])>0){
                $dato['archivo']=$dato['get_id'][0]['certificado'];
            }
            if($_FILES["certificado"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['certificado']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['certificado']['name']);
                        $source_file = $_FILES['certificado']['tmp_name'];

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
                            $nombre="cursocomp_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/CURSOS_COMPLEMENTARIOS/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['archivo'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    ftp_close($con_id);
                }
            }
            $id_usuario = session('usuario')->id_usuario;

            CursoComplementario::where('id_curso_complementario', $dato['id_curso_complementario'])
                ->update([
                    'id_usuario' => $dato['id_usuario'],
                    'nom_curso_complementario' => $dato['nom_curso_complementario'],
                    'anio' => $dato['anio'],
                    'certificado' => $dato['archivo'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
    }

    public function Detalle_CursosC(Request $request){
        $this->Model_Perfil = new Model_Perfil();
            $id_curso_complementario= $request->input("id_curso_complementario");
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            $dato['get_id'] = CursoComplementario::get_list_cursosce($id_curso_complementario);
            $dato['url_cursosc'] = Config::where('descrip_config','Cursos_Complementarios')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Curso_Complementario.editar', $dato);
    }

    public function MDatos_CursosC(Request $request){
        $this->Model_Perfil = new Model_Perfil();
        $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
        return view('rrhh.Perfil.Curso_Complementario.index', $dato);
    }

    public function Delete_CursosC($id){
        CursoComplementario::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function no_aplica_cc(Request $request, $id){
        Usuario::findOrFail($id)->update([
            'cursos_complementarios' => $request->no_aplica,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }
    /********************************************/
    public function Lista_ExperenciaL(Request $request){
            $id_usuario = $request->input("id_usuariodp");
            $dato['list_experiencial'] = ExperienciaLaboral::get_list_experiencial($id_usuario);
            $dato['url_exp'] = Config::where('descrip_config','Experiencia_Laboral')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Experiencia_Laboral.ldatos', $dato);

    }

    public function Insert_ExperenciaL(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['empresa'] = strtoupper($request->input("empresaex"));
            $dato['cargo'] = strtoupper($request->input("cargoex"));
            $dato['dia_ini'] = $request->input("dia_iniel");
            $dato['mes_ini'] = $request->input("mes_iniel");
            $dato['anio_ini'] = $request->input("anio_iniel");
            $dato['fec_ini']=$request->input("anio_iniel")."-".$request->input("mes_iniel")."-".$request->input("dia_iniel");
            $dato['actualidad'] = $request->input("checkactualidad");
            $dato['dia_fin'] = $request->input("dia_finel");
            $dato['mes_fin'] = $request->input("mes_finel");
            $dato['anio_fin'] = $request->input("anio_finel");
            $dato['fec_fin']=$request->input("anio_finel")."-".$request->input("mes_finel")."-".$request->input("dia_finel");
            $dato['motivo_salida'] = $request->input("motivo_salida");
            $dato['remuneracion'] = $request->input("remuneracion");
            $dato['nom_referencia_labores'] = strtoupper($request->input("nom_referencia_labores"));
            $dato['num_contacto'] = $request->input("num_contacto");

            $dato['archivo']="";
            if($_FILES["certificadolb"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['certificadolb']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['certificadolb']['name']);
                        $source_file = $_FILES['certificadolb']['tmp_name'];

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
                            $nombre="certificadolb_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/EXPERIENCIA_LABORAL/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);

                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['archivo'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    ftp_close($con_id);
                }
            }
            $id_usuario = session('usuario')->id_usuario;

        ExperienciaLaboral::create([
            'id_usuario' => $dato['id_usuario'],
            'empresa' => $dato['empresa'],
            'cargo' => $dato['cargo'],
            'dia_ini' => $dato['dia_ini'],
            'mes_ini' => $dato['mes_ini'],
            'anio_ini' => $dato['anio_ini'],
            'fec_ini' => $dato['fec_ini'],
            'actualidad' => 0,
            'dia_fin' => $dato['dia_fin'],
            'mes_fin' => $dato['mes_fin'],
            'anio_fin' => $dato['anio_fin'],
            'fec_fin' => $dato['fec_fin'],
            'motivo_salida' => $dato['motivo_salida'],
            'remuneracion' => $dato['remuneracion'],
            'nom_referencia_labores' => $dato['nom_referencia_labores'],
            'num_contacto' => $dato['num_contacto'],
            'certificado' => $dato['archivo'],
            'fec_reg' => now(),
            'user_reg' => $id_usuario,
            'estado' => 1,
            'certificado_nombre' => 0,
        ]);
    }

    public function Update_ExperenciaL(Request $request){
            $dato['id_experiencia_laboral'] = $request->input("id_experiencia_laboral");
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['empresa'] = strtoupper($request->input("empresaex"));
            $dato['cargo'] = strtoupper($request->input("cargoex"));
            $dato['dia_ini'] = $request->input("dia_iniel");
            $dato['mes_ini'] = $request->input("mes_iniel");
            $dato['anio_ini'] = $request->input("anio_iniel");
            $dato['fec_ini']=$request->input("anio_iniel")."-".$request->input("mes_iniel")."-".$request->input("dia_iniel");
            $dato['actualidad'] = $request->input("checkactualidad");
            $dato['dia_fin'] = $request->input("dia_finel");
            $dato['mes_fin'] = $request->input("mes_finel");
            $dato['anio_fin'] = $request->input("anio_finel");
            $dato['fec_fin']=$request->input("anio_finel")."-".$request->input("mes_finel")."-".$request->input("dia_finel");
            $dato['motivo_salida'] = $request->input("motivo_salida");
            $dato['remuneracion'] = $request->input("remuneracion");
            $dato['nom_referencia_labores'] = strtoupper($request->input("nom_referencia_labores"));
            $dato['num_contacto'] = $request->input("num_contacto");
            $dato['certificado_nombre'] = $request->input("certificado_nombre");

            $dato['total'] = ExperienciaLaboral::get_list_experiencial($dato['id_usuario']);

            $dato['archivo']="";
            if(count($dato['total'])>0){
                $dato['archivo']=$dato['total'][0]['certificado'];
            }

            $id_usuario = session('usuario')->id_usuario;

            ExperienciaLaboral::where('id_experiencia_laboral', $dato['id_experiencia_laboral'])
                ->update([
                    'id_usuario' => $dato['id_usuario'],
                    'empresa' => $dato['empresa'],
                    'cargo' => $dato['cargo'],
                    'dia_ini' => $dato['dia_ini'],
                    'mes_ini' => $dato['mes_ini'],
                    'anio_ini' => $dato['anio_ini'],
                    'fec_ini' => $dato['fec_ini'],
                    'dia_fin' => $dato['dia_fin'],
                    'mes_fin' => $dato['mes_fin'],
                    'actualidad' => 0,
                    'anio_fin' => $dato['anio_fin'],
                    'fec_fin' => $dato['fec_fin'],
                    'motivo_salida' => $dato['motivo_salida'],
                    'remuneracion' => $dato['remuneracion'],
                    'nom_referencia_labores' => $dato['nom_referencia_labores'],
                    'num_contacto' => $dato['num_contacto'],
                    'certificado' => $dato['archivo'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);
    }

    public function MDatos_ExperenciaL(){
        $this->Model_Perfil = new Model_Perfil();

        $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
        $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
        $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
        return view('rrhh.Perfil.Experiencia_Laboral.index', $dato);
    }

    public function Detalle_ExperenciaL(Request $request){
        $this->Model_Perfil = new Model_Perfil();
            $dato['id_experiencia_laboral']= $request->input("id_experiencia_laboral");
            $id_experiencia_laboral= $request->input("id_experiencia_laboral");
            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            $dato['get_id'] = ExperienciaLaboral::get_list_experienciale($id_experiencia_laboral);
            $dato['url_exp'] = Config::where('descrip_config','Experiencia_Laboral')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Experiencia_Laboral.editar', $dato);
    }

    public function Delete_ExperenciaL(Request $request, $id_experiencia_laboral=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['id_usuario'] = $get_id[0]['id_usuario'];
            $dato['id_experiencia_laboral']= $request->input("id_experiencia_laboral");
            $dato['id_usuario']= $request->input("id_usuario");

            $id_usuario = session('usuario')->id_usuario;

            ExperienciaLaboral::where('id_experiencia_laboral', $dato['id_experiencia_laboral'])
                ->update([
                    'estado' => 2,
                    'fec_eli' => now(),
                    'user_eli' => $id_usuario
                ]);
    }

    /************************************************************************/
    public function Insert_Enfermedades(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_respuestae'] = $request->input("id_respuestae");
            $dato['nom_enfermedad'] = strtoupper($request->input("nom_enfermedad"));
            $dato['dia_diagnostico'] = $request->input("dia_diagnostico");
            $dato['mes_diagnostico'] = $request->input("mes_diagnostico");
            $dato['anio_diagnostico'] = $request->input("anio_diagnostico");
            $dato['fec_diagnostico']=$request->input("anio_diagnostico")."-".$request->input("mes_diagnostico")."-".$request->input("dia_diagnostico");

            $id_usuario = session('usuario')->id_usuario;

            // Actualización de la tabla `users`
            Usuario::where('id_usuario', $dato['id_usuario'])
                ->update([
                    'enfermedades' => $dato['id_respuestae'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);

            // Verificación y gestión en la tabla `enfermedad_usuario`
            if ($dato['id_respuestae'] == 1) {
                // Inserción en `enfermedad_usuario`
                EnfermedadUsuario::create([
                    'id_usuario' => $dato['id_usuario'],
                    'id_respuestae' => $dato['id_respuestae'],
                    'nom_enfermedad' => $dato['nom_enfermedad'],
                    'dia_diagnostico' => $dato['dia_diagnostico'],
                    'mes_diagnostico' => $dato['mes_diagnostico'],
                    'anio_diagnostico' => $dato['anio_diagnostico'],
                    'fec_diagnostico' => $dato['fec_diagnostico'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1
                ]);
            } else {
                // Actualización en `enfermedad_usuario`
                EnfermedadUsuario::where('id_usuario', $dato['id_usuario'])
                    ->update([
                        'estado' => 2,
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            }

            $id_usuario= $request->input("id_usuariodp");


            $dato['list_enfermedadu'] = EnfermedadUsuario::get_list_enfermedadu($id_usuario);
            return view('rrhh.Perfil.Enfermedades.ldatos', $dato);
    }

    public function Update_Enfermedades(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_enfermedad_usuario'] = $request->input("id_enfermedad_usuario");
            $dato['id_respuestae'] = $request->input("id_respuestae");
            $dato['nom_enfermedad'] = strtoupper($request->input("nom_enfermedad"));
            $dato['dia_diagnostico'] = $request->input("dia_diagnostico");
            $dato['mes_diagnostico'] = $request->input("mes_diagnostico");
            $dato['anio_diagnostico'] = $request->input("anio_diagnostico");
            $dato['fec_diagnostico']=$request->input("anio_diagnostico")."-".$request->input("mes_diagnostico")."-".$request->input("dia_diagnostico");

            $id_usuario = $_SESSION['usuario'][0]['id_usuario'];

            // Actualización del usuario
            Usuario::where('id_usuario', $dato['id_usuario'])
                ->update([
                    'enfermedades' => $dato['id_respuestae'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);

            // Manejo de `enfermedad_usuario`
            if ($dato['id_respuestae'] == 1) {
                // Actualización en `enfermedad_usuario`
                EnfermedadUsuario::where('id_enfermedad_usuario', $dato['id_enfermedad_usuario'])
                    ->update([
                        'id_usuario' => $dato['id_usuario'],
                        'id_respuestae' => $dato['id_respuestae'],
                        'nom_enfermedad' => $dato['nom_enfermedad'],
                        'dia_diagnostico' => $dato['dia_diagnostico'],
                        'mes_diagnostico' => $dato['mes_diagnostico'],
                        'anio_diagnostico' => $dato['anio_diagnostico'],
                        'fec_diagnostico' => $dato['fec_diagnostico'],
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            } else {
                // Actualización de estado en `enfermedad_usuario`
                EnfermedadUsuario::where('id_usuario', $dato['id_usuario'])
                    ->update([
                        'estado' => 2,
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            }

            $dato['list_enfermedadu'] = EnfermedadUsuario::get_list_enfermedadu($dato['id_usuario']);

            return view('rrhh.Perfil.Enfermedades.ldatos', $dato);
    }

    public function Detalle_Enfermedades(Request $request){
        $this->Model_Perfil = new Model_Perfil();
            $id_usuario = session('usuario')->id_usuario;
            $id_enfermedad_usuario= $request->input("id_enfermedad_usuario");

            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();

            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);

            $dato['get_id'] = EnfermedadUsuario::get_list_enfermedade($id_enfermedad_usuario);
            return view('rrhh.Perfil.Enfermedades.editar', $dato);
    }

    public function MDatos_Enfermedades(Request $request){
        $this->Model_Perfil = new Model_Perfil();

            $id_usuario = $request->input("id_usuariodp");

            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();

            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            return view('rrhh.Perfil.Enfermedades.index', $dato);
    }

    public function Delete_Enfermedades(Request $request, $id_enfermedad_usuario=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();

            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['id_usuario'] = $get_id[0]['id_usuario'];
            $dato['id_usuario']= $request->input("id_usuario");

            $dato['id_enfermedad_usuario']= $request->input("id_enfermedad_usuario");
            // Obtener el ID del usuario desde la sesión de Laravel
            $id_usuario = session('usuario')->id_usuario;

            // Actualización de `enfermedad_usuario`
            EnfermedadUsuario::where('id_enfermedad_usuario', $dato['id_enfermedad_usuario'])
                ->update([
                    'estado' => 2,
                    'fec_eli' => now(),
                    'user_eli' => $id_usuario
                ]);
            $dato['list_enfermedadu'] = EnfermedadUsuario::get_list_enfermedadu($dato['id_usuario']);

            return view('rrhh.Perfil.Enfermedades.ldatos', $dato);
    }
    /****************************************************************/
    public function Update_Gestacion(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_respuesta']= $request->input("id_respuesta");
            $dato['dia_ges']= $request->input("dia_ges");
            $dato['mes_ges']= $request->input("mes_ges");
            $dato['anio_ges']= $request->input("anio_ges");
            $dato['fec_ges']= $request->input("anio_ges")."-".$request->input("mes_ges")."-".$request->input("dia_ges");
            $dato['tot_id_gestacion'] = GestacionUsuario::where('id_usuario', $dato['id_usuario'])
                                    ->where('estado', 1)
                                    ->get();

            if(count($dato['tot_id_gestacion'])>0){
                $id_usuario = session('usuario')->id_usuario;

                if ($dato['id_respuesta'] == 1) {
                    GestacionUsuario::where('id_usuario', $dato['id_usuario'])->update([
                        'id_usuario' => $dato['id_usuario'],
                        'id_respuesta' => $dato['id_respuesta'],
                        'dia_ges' => $dato['dia_ges'],
                        'mes_ges' => $dato['mes_ges'],
                        'anio_ges' => $dato['anio_ges'],
                        'fec_ges' => $dato['fec_ges'],
                        'fec_act' => now(),
                        'user_act' => $id_usuario,
                    ]);
                } else {
                    GestacionUsuario::where('id_usuario', $dato['id_usuario'])->update([
                        'id_usuario' => $dato['id_usuario'],
                        'id_respuesta' => $dato['id_respuesta'],
                        'dia_ges' => null,
                        'mes_ges' => null,
                        'anio_ges' => null,
                        'fec_ges' => null,
                        'fec_act' => now(),
                        'user_act' => $id_usuario,
                    ]);
                }
            }else{
                $id_usuario = session('usuario')->id_usuario;

                if ($dato['id_respuesta'] == 1) {
                    GestacionUsuario::create([
                        'id_usuario' => $dato['id_usuario'],
                        'id_respuesta' => $dato['id_respuesta'],
                        'dia_ges' => $dato['dia_ges'],
                        'mes_ges' => $dato['mes_ges'],
                        'anio_ges' => $dato['anio_ges'],
                        'fec_ges' => $dato['fec_ges'],
                        'fec_reg' => now(),
                        'user_reg' => $id_usuario,
                        'estado' => 1,
                    ]);
                } else {
                    GestacionUsuario::create([
                        'id_usuario' => $dato['id_usuario'],
                        'id_respuesta' => $dato['id_respuesta'],
                        'dia_ges' => '',
                        'mes_ges' => '',
                        'anio_ges' => '',
                        'fec_ges' => '',
                        'fec_reg' => now(),
                        'user_reg' => $id_usuario,
                        'estado' => 1,
                    ]);
                }
            }
            $id_usuario= $request->input("id_usuariodp");

            $this->Model_Perfil = new Model_Perfil();

            $dato['list_dia'] = $this->Model_Perfil->get_list_dia();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();

            $dato['get_id_gestacion'] = GestacionUsuario::where('id_usuario', $id_usuario)
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Gestacion', $dato);
    }

    /******************************************************************************************/
    public function Insert_Alergia(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_respuestaau'] = $request->input("id_respuestaau");
            $dato['nom_alergia'] = strtoupper($request->input("nom_alergia"));

            $id_usuario = session('usuario')->id_usuario;

            Usuario::where('id_usuario', $id_usuario)->update([
                'alergia' => $dato['id_respuestaau'],
                'fec_act' => now(),
                'user_act' => $id_usuario,
            ]);

            if ($dato['id_respuestaau'] == 1) {
                AlergiaUsuario::create([
                    'id_usuario' => $dato['id_usuario'],
                    'nom_alergia' => $dato['nom_alergia'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1,
                ]);
            } else {
                AlergiaUsuario::where('id_usuario', $dato['id_usuario'])->update([
                    'estado' => 2,
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
            }

            $id_usuario= $request->input("id_usuariodp");
            $this->Model_Perfil = new Model_Perfil();

            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['list_alergia'] = AlergiaUsuario::get_list_alergia($id_usuario);
            return view('rrhh.Perfil.Alergias.ldatos', $dato);
    }

    public function Update_Alergia(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_respuestaau'] = $request->input("id_respuestaau");
            $dato['id_alergia_usuario'] = $request->input("id_alergia_usuario");
            $dato['nom_alergia'] = strtoupper($request->input("nom_alergia"));

            $id_usuario = session('usuario')->id_usuario;

            // Update the user record
            Usuario::where('id_usuario', $dato['id_usuario'])->update([
                'alergia' => $dato['id_respuestaau'],
                'fec_act' => now(),
                'user_act' => $id_usuario,
            ]);

            if ($dato['id_respuestaau'] == 1) {
                // Update alergia_usuario
                AlergiaUsuario::where('id_alergia_usuario', $dato['id_alergia_usuario'])->update([
                    'id_usuario' => $dato['id_usuario'],
                    'nom_alergia' => $dato['nom_alergia'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
            } else {
                // Update estado in alergia_usuario
                AlergiaUsuario::where('id_usuario', $dato['id_usuario'])->update([
                    'estado' => 2,
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
            }

            $id_usuario= $request->input("id_usuariodp");
            $this->Model_Perfil = new Model_Perfil();

            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['list_alergia'] = AlergiaUsuario::get_list_alergia($id_usuario);
            return view('rrhh.Perfil.Alergias.ldatos', $dato);
    }

    public function Detalle_Alergia(Request $request){
            $id_usuario = session('usuario')->id_usuario;
            $id_alergia_usuario = $request->input("id_alergia_usuario");
            $this->Model_Perfil = new Model_Perfil();
            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['get_id'] = EnfermedadUsuario::get_list_enfermedade($id_alergia_usuario);
            return view('rrhh.Perfil.Alergias.editar', $dato);
    }

    public function MDatos_Alergias(Request $request){
            $id_usuario = $request->input("id_usuariodp");
            $this->Model_Perfil = new Model_Perfil();
            $dato['list_usuario'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            return view('rrhh.Perfil.Alergias.index', $dato);
    }

    public function Delete_Alergia(Request $request,$id_alergia_usuario=null ,$id_usuario=null){
        $this->Model_Perfil = new Model_Perfil();
            $dato['get_id'] = $this->Model_Perfil->get_id_usuario($id_usuario);
            $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
            $dato['id_usuario'] = $get_id[0]['id_usuario'];
            $dato['id_usuario']= $request->input("id_usuario");


            $dato['id_alergia_usuario']= $request->input("id_alergia_usuario");

            $id_usuario = session('usuario')->id_usuario;

            // Update estado for deletion in alergia_usuario
            AlergiaUsuario::where('id_alergia_usuario', $dato['id_alergia_usuario'])->update([
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => $id_usuario,
            ]);

            $dato['list_alergia'] = AlergiaUsuario::get_list_alergia($dato['id_usuario']);

            return view('rrhh.Perfil.Alergias.ldatos', $dato);
    }

    public function Update_Otros(Request $request){
            $dato['id_usuario'] = $request->input("id_usuarioo");
            $dato['id_grupo_sanguineo']= $request->input("id_grupo_sanguineo");
            $dato['certificadootr'] = $request->input("certificadootr");
            $dato['certificadootr_vacu'] = $request->input("certificadootr_vacu");

            $dato['total'] = OtrosUsuario::where('id_usuario', $dato['id_usuario'])
                        ->where('estado', 1)
                        ->get();

            $dato['archivo']="";
            if(count($dato['total'])>0){
                $dato['archivo']=$dato['total'][0]['cert_covid'];
            }
            if($_FILES["certificadootr_vacu"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    //echo "No se conecto";
                }else{
                    //echo "Se conecto";
                    $path = $_FILES['certificadootr_vacu']['name'];
                    if($path!=""){
                        $temp = explode(".",$_FILES['certificadootr_vacu']['name']);
                        $source_file = $_FILES['certificadootr_vacu']['tmp_name'];

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
                            $nombre="certotro_".$dato['id_usuario']."_".$codigoUnico."_".rand(10,199).".".$ext;
                            $nombre_archivo = "PERFIL/DOCUMENTACION/OTROS/".$nombre;
                            $duplicado=0;

                        }while ($duplicado>0);

                        ftp_pasv($con_id, true);


                        if (@ftp_put($con_id, $nombre_archivo, $source_file, FTP_BINARY)) {
                            $dato['archivo'] = $nombre;
                        }else{
                            $error = error_get_last();
                        }
                    }
                    ftp_close($con_id);
                }
            }

            if(count($dato['total'])>0){
                $id_usuario = session('usuario')->id_usuario;
                if($dato['archivo'] == ""){
                    $archivo = 0;
                }else{
                    $archivo = $dato['archivo'];
                }
                OtrosUsuario::where('id_usuario', $dato['id_usuario'])->update([
                    'id_grupo_sanguineo' => $dato['id_grupo_sanguineo'],
                    'cert_vacu_covid' => $archivo,
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
            }else{
                $id_usuario = session('usuario')->id_usuario;

                OtrosUsuario::create([
                    'id_usuario' => $dato['id_usuario'],
                    'id_grupo_sanguineo' => $dato['id_grupo_sanguineo'],
                    'cert_vacu_covid' => $dato['archivo'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1,
                ]);
            }
    }

    public function Lista_Otros(Request $request){
            $id_usuario = $request->input("id_usuarioo");
            $dato['list_grupo_sanguineo'] = GrupoSanguineo::where('estado', 1)
                                ->get();
            $dato['get_id_otros'] = OtrosUsuario::where('id_usuario', $id_usuario)
                                ->where('estado', 1)
                                ->get();
            $dato['url_otro'] = Config::where('descrip_config','Documentacion_Otro')
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.Perfil.Otros', $dato);
    }

    public function Update_Referencia_Convocatoria(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_referencia_laboral']= $request->input("id_referencia_laboral");
            $dato['otros']= $request->input("otrosel");

            $dato['tot_id_referenciac'] = ReferenciaConvocatoria::where('id_usuario', $dato['id_usuario'])
                                    ->get();

            if(count($dato['tot_id_referenciac'])>0){
                $id_usuario = session('usuario')->id_usuario;

                // Update the record
                ReferenciaConvocatoria::where('id_usuario', $dato['id_usuario'])
                    ->update([
                        'id_referencia_laboral' => $dato['id_referencia_laboral'],
                        'otros' => $dato['otros'],
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            }else{
                $id_usuario = session('usuario')->id_usuario;
                // Insert a new record
                ReferenciaConvocatoria::create([
                    'id_usuario' => $dato['id_usuario'],
                    'id_referencia_laboral' => $dato['id_referencia_laboral'],
                    'otros' => $dato['otros'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1
                ]);
            }
            $id_usuario = $request->input("id_usuariodp");

            $dato['list_referencia_laboral'] = ReferenciaLaboral::where('estado', 1)
                                        ->get();
            $dato['get_id_referenciac'] = ReferenciaConvocatoria::where('id_usuario', $id_usuario)
                                        ->get();
            return view('rrhh.Perfil.Referencia_Convocatoria', $dato);
    }

    /*************************** */
    public function Update_Adjuntar_Documentacion(Request $request){
           $dato['id_usuario'] = $request->input("id_usuariodp");

           $dato['filecv_doc'] = $request->input("filecv_doc");
           $dato['filedni_doc'] = $request->input("filedni_doc");
           $dato['filerecibo_doc'] = $request->input("filerecibo_doc");
           $dato['img1'] = $_FILES['filecv_doc']['name'];
           $dato['img2'] = $_FILES['filedni_doc']['name'];
           $dato['img3'] = $_FILES['filerecibo_doc']['name'];

            $dato['total'] = DocumentacionUsuario::where('id_usuario', $dato['id_usuario'])
                        ->where('estado',1)
                        ->get();
            $dato['cv_doc']="";
            $dato['dni_doc']="";
            $dato['recibo_doc']="";
            if(count($dato['total'])>0){
                $dato['cv_doc']=$dato['total'][0]['cv_doc'];
                $dato['dni_doc']=$dato['total'][0]['dni_doc'];
                $dato['recibo_doc']=$dato['total'][0]['recibo_doc'];
            }
            if($_FILES['filecv_doc']['name']!="" || $_FILES['filedni_doc']['name']!="" || $_FILES['filerecibo_doc']['name']!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    echo "No se conecto";
                }else{
                    echo "Se conecto";
                    if($_FILES['filecv_doc']['name']!=""){
                        $path = $_FILES['filecv_doc']['name'];
                        $temp = explode(".",$_FILES['filecv_doc']['name']);
                        $source_file = $_FILES['filecv_doc']['tmp_name'];

                        $fecha=date('Y-m-d_His');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="CV_".$dato['id_usuario']."_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".$ext;
                        $dato['cv_doc'] = $nombre;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"PERFIL/DOCUMENTACION/DOCUMENTACION/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                    if($_FILES['filedni_doc']['name']!=""){
                        $path = $_FILES['filedni_doc']['name'];
                        $temp = explode(".",$_FILES['filedni_doc']['name']);
                        $source_file = $_FILES['filedni_doc']['tmp_name'];

                        $fecha=date('Y-m-d_His');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="DNI_".$dato['id_usuario']."_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".$ext;
                        $dato['dni_doc'] = $nombre;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"PERFIL/DOCUMENTACION/DOCUMENTACION/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                    if($_FILES['filerecibo_doc']['name']!=""){
                        $path = $_FILES['filerecibo_doc']['name'];
                        $temp = explode(".",$_FILES['filerecibo_doc']['name']);
                        $source_file = $_FILES['filerecibo_doc']['tmp_name'];

                        $fecha=date('Y-m-d_His');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="RECIBO_".$dato['id_usuario']."_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".$ext;
                        $dato['recibo_doc'] = $nombre;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"PERFIL/DOCUMENTACION/DOCUMENTACION/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            }

            $id_usuario = session('usuario')->id_usuario;
            if(count($dato['total'])>0){
                DocumentacionUsuario::where('id_usuario', $dato['id_usuario'])
                    ->update([
                        'cv_doc' => $dato['cv_doc'],
                        'dni_doc' => $dato['dni_doc'],
                        'recibo_doc' => $dato['recibo_doc'],
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            }else{
                DocumentacionUsuario::where('id_usuario', $dato['id_usuario'])
                    ->update([
                        'carta_renuncia' => $dato['carta_renuncia'],
                        'eval_sicologico' => $dato['eval_sicologico'],
                        'convenio_laboral' => $dato['convenio_laboral'],
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            }
    }

    public function Lista_Adjuntar_Documentacion(Request $request){
            $id_usuario= $request->input("id_usuariodp");
            $dato['url'] = Config::where('descrip_config','Documentacion_Perfil')
                                ->where('estado', 1)
                                ->get();
            $dato['get_id_documentacion'] = DocumentacionUsuario::where('id_usuario', $id_usuario)
                                    ->where('estado',1)
                                    ->get();
            return view('rrhh.Perfil.Documentacion', $dato);
    }

    /********************************** */
    public function Update_Talla_Indica(Request $request){
        $this->Model_Perfil = new Model_Perfil();

            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['polo']= $request->input("polo");
            $dato['camisa']= $request->input("camisa");
            $dato['pantalon']= $request->input("pantalon");
            $dato['zapato']= $request->input("zapato");

            $dato['get_id_t'] = RopaUsuario::where('id_usuario', $dato['id_usuario'])
                            ->get();

            if(count($dato['get_id_t'])>0){
                $id_usuario = session('usuario')->id_usuario;

                RopaUsuario::where('id_usuario', $dato['id_usuario'])
                    ->update([
                        'polo' => $dato['polo'],
                        'camisa' => $dato['camisa'],
                        'pantalon' => $dato['pantalon'],
                        'zapato' => $dato['zapato'],
                        'fec_act' => now(),
                        'user_act' => $id_usuario
                    ]);
            }else{
                $id_usuario = session('usuario')->id_usuario;

                RopaUsuario::insert([
                    'id_usuario' => $dato['id_usuario'],
                    'polo' => $dato['polo'],
                    'camisa' => $dato['camisa'],
                    'pantalon' => $dato['pantalon'],
                    'zapato' => $dato['zapato'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1
                ]);
            }

            $id_usuario= $request->input("id_usuariodp");

            $dato['list_accesorio_polo'] = $this->Model_Perfil->get_list_accesorio_polo();
            $dato['list_accesorio_camisa'] = $this->Model_Perfil->get_list_accesorio_camisa();
            $dato['list_accesorio_pantalon'] = $this->Model_Perfil->get_list_accesorio_pantalon();
            $dato['list_accesorio_zapato'] = $this->Model_Perfil->get_list_accesorio_zapato();


            $dato['get_id_t'] = RopaUsuario::where('id_usuario', $dato['id_usuario'])
                            ->get();
            return view('rrhh.Perfil.Talla_Indica', $dato);
    }
   /*** */
    public function Update_Sistema_Pensionario(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");
            $dato['id_respuestasp']= $request->input("id_respuestasp");
            $dato['id_sistema_pensionario']= $request->input("id_sistema_pensionario");
            $dato['id_afp']= $request->input("id_afp");
            $dato['total'] = SistPensUsuario::where('id_usuario', $dato['id_usuario'])
                        ->where('estado',1)
                        ->get();

            $id_usuario = session('usuario')->id_usuario;
            if(count($dato['total'])>0){
                SistPensUsuario::where('id_usuario', $dato['id_usuario'])
                ->update([
                        'id_respuestasp' => $dato['id_respuestasp'],
                        'id_sistema_pensionario' => $dato['id_sistema_pensionario'],
                        'id_afp' => $dato['id_afp'],
                        'user_act' => $id_usuario,
                        'fec_act' => now(),
                ]);
            }else{
                SistPensUsuario::create([
                    'id_usuario' => $dato['id_usuario'],
                    'id_respuestasp' => $dato['id_respuestasp'],
                    'id_sistema_pensionario' => $dato['id_sistema_pensionario'],
                    'id_afp' => $dato['id_afp'],
                    'user_reg' => $id_usuario,
                    'fec_reg' => now(),
                    'estado' => 1,
                ]);
            }

            $id_usuario= $request->input("id_usuariodp");


            $dato['list_sistema_pensionario'] = DB::table('sistema_pensionario')
                                        ->where('estado', 1)
                                        ->get();

            $dato['list_afp'] = ComisionAFP::where('estado', 1)
                        ->get();
            $dato['get_id_sist_pensu'] = SistPensUsuario::where('id_usuario', $id_usuario)
                                ->where('estado',1)
                                ->get();
            return view('rrhh.Perfil.Sistemas_Pensiones', $dato);
    }
    /** */

    public function Update_Numero_Cuenta(Request $request){
            $dato['id_usuario'] = $request->input("id_usuariodp");

            $dato['id_banco']= $request->input("id_banco");
            $dato['cuenta_bancaria']= $request->input("cuenta_bancaria");
            $dato['list_banco'] = Banco::where('estado', 1)
                                ->get();


            if($dato['cuenta_bancaria']==1){
                    for ($x = 1; $x <= count($dato['list_banco']); $x++) {
                        if($request->input("num_cuenta_bancaria_$x") != null && $request->input("num_codigo_interbancario_$x") != null){
                           $dato['num_cuenta_bancaria']= $request->input("num_cuenta_bancaria_$x");
                           $dato['num_codigo_interbancario']= $request->input("num_codigo_interbancario_$x");
                       }
                   }
            }else{
                $dato['num_cuenta_bancaria']= "";
                $dato['num_codigo_interbancario']= "";
            }

            $dato['tot_id_cuentab'] = CuentaBancaria::where('id_usuario', $dato['id_usuario'])
                                ->get();

            $id_usuario = session('usuario')->id_usuario;
            if(count($dato['tot_id_cuentab'])>0){
                CuentaBancaria::where('id_usuario', $dato['id_usuario'])->update([
                    'id_banco' => $dato['id_banco'],
                    'cuenta_bancaria' => $dato['cuenta_bancaria'],
                    'num_cuenta_bancaria' => $dato['num_cuenta_bancaria'],
                    'num_codigo_interbancario' => $dato['num_codigo_interbancario'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario
                ]);
            }else{
                CuentaBancaria::insert([
                    'id_usuario' => $dato['id_usuario'],
                    'id_banco' => $dato['id_banco'],
                    'cuenta_bancaria' => $dato['cuenta_bancaria'],
                    'num_cuenta_bancaria' => $dato['num_cuenta_bancaria'],
                    'num_codigo_interbancario' => $dato['num_codigo_interbancario'],
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'estado' => 1
                ]);
            }

            $id_usuario= $request->input("id_usuariodp");

            $dato['get_id_cuentab'] = CuentaBancaria::where('id_usuario', $id_usuario)
                                ->get();
            return view('rrhh.Perfil.Cuenta_Bancaria', $dato);
    }

    public function Terminos(Request $request){
            Usuario::where('id_usuario', $request->id_usuariot)->update([
                'terminos'=>1,
                'fec_act'=>now(),
                'user_act'=>session('usuario')->id_usuario,
            ]);
    }
    public function GuardarCambiosCI($numero){
            $colaborador = Usuario::where('num_doc', $numero)
                        ->whereIn('estado', [1,4])
                        ->get();
            $id_usuario = $colaborador[0]['id_usuario'];
            $this->Model_Perfil = new Model_Perfil();

            $dato['list_usuario'] =  Usuario::get_list_usuario($id_usuario);
            $dato['list_referenciafu'] = $this->Model_Perfil->get_list_referenciafu($id_usuario);
            $dato['list_usuario'][0]['hijos'];
            $dato['list_contactoeu'] = $this->Model_Perfil->get_list_contactoeu($id_usuario);
            $dato['list_estudiosgu'] = $this->Model_Perfil->get_list_estudiosgu($id_usuario);
            $dato['get_id_c'] = $this->Model_Perfil->get_id_conoci_office($id_usuario);
            $dato['get_id_t'] = $this->Model_Perfil->get_id_ropa_usuario($id_usuario);
            $dato['listar_idiomas'] = $this->Model_Perfil->get_list_idiomasu($id_usuario);
            $dato['listar_cursosc'] = $this->Model_Perfil->get_list_cursoscu($id_usuario);
            $dato['list_experiencial'] = $this->Model_Perfil->get_list_experiencial($id_usuario);
            $dato['list_usuario'][0]['enfermedades'];//enfermedades
            $dato['get_id_gestacion'] = $this->Model_Perfil->get_id_gestacion($id_usuario);
            $dato['list_usuario'][0]['alergia'];
            $dato['get_id_referenciac'] = $this->Model_Perfil->get_id_referenciac($id_usuario);
            $dato['get_id_documentacion'] = $this->Model_Perfil->get_id_documentacion($id_usuario);

            $dato['get_id_sist_pensu'] = $this->Model_Perfil->get_id_sist_pensu($id_usuario);
            $dato['get_id_cuentab'] = $this->Model_Perfil->get_id_cuentab($id_usuario);
            $dato['get_domicilio'] = $this->Model_Perfil->get_id_domicilio_users($id_usuario);
            $dato['get_hijos'] = $this->Model_Perfil->get_list_hijosucount($id_usuario);
            $dato['get_enfermedades'] = $this->Model_Perfil->get_list_enfermedadu($id_usuario);
            $dato['get_gustos_pref'] = $this->Model_Perfil->get_id_gustosp($id_usuario);


            $mensaje="";
            if($dato['list_usuario'][0]['usuario_nombres']=="" || $dato['list_usuario'][0]['usuario_apater']=="" || $dato['list_usuario'][0]['usuario_amater']==""
            || $dato['list_usuario'][0]['id_nacionalidad']==0 || $dato['list_usuario'][0]['id_genero']==0 || $dato['list_usuario'][0]['id_tipo_documento']==0
            || $dato['list_usuario'][0]['num_doc']=="" || $dato['list_usuario'][0]['dia_nac']=="" || $dato['list_usuario'][0]['mes_nac']=="" || $dato['list_usuario'][0]['anio_nac']==""
            || $dato['list_usuario'][0]['id_estado_civil']=="" || $dato['list_usuario'][0]['usuario_email']=="" || $dato['list_usuario'][0]['num_celp']==""){
                $mensaje=$mensaje."Datos Personales<br>";
            }if(count($dato['get_gustos_pref'])<1){
                $mensaje=$mensaje."Gustos y Preferencias<br>";
            }if(count($dato['get_domicilio'])<1){
                $mensaje=$mensaje."Domicilio<br>";
            }if(count($dato['list_referenciafu'])<1){
                $mensaje=$mensaje."Referencias Familiares<br>";
            }if($dato['list_usuario'][0]['hijos']==0 || ($dato['list_usuario'][0]['hijos']==1 && $dato['get_hijos'][0]['totalhijos']<1)){
                $mensaje=$mensaje."Datos de Hijos/as<br>";
            }if(count($dato['list_contactoeu'])<1){
                $mensaje=$mensaje."Contacto de Emergencia<br>";
            }if(count($dato['list_estudiosgu'])<1){
                $mensaje=$mensaje."Estudios Generales<br>";
            }if(count($dato['get_id_c'])<1){
                $mensaje=$mensaje."Conocimientos de Office<br>";
            }if(count($dato['listar_idiomas'])<1){
                $mensaje=$mensaje."Conocimientos de Idiomas<br>";
            }if(count($dato['list_experiencial'])<1){
                $mensaje=$mensaje."Experiencia Laboral<br>";
            }if($dato['list_usuario'][0]['enfermedades']==0 || ($dato['list_usuario'][0]['enfermedades']==1 && count($dato['get_enfermedades'])<1)){
                $mensaje=$mensaje."Enfermedades<br>";
            }if(count($dato['get_id_gestacion'])<1){
                $mensaje=$mensaje."Gestación<br>";
            }if($dato['list_usuario'][0]['alergia']==0){
                $mensaje=$mensaje."Alergias<br>";
            }if(count($dato['get_id_referenciac'])<1){
                $mensaje=$mensaje."Referencia de Convocatoria<br>";
            }if(count($dato['get_id_documentacion'])<1){
                $mensaje=$mensaje."Adjuntar Documentación<br>";
            }if(count($dato['get_id_t'])<1){
                $mensaje=$mensaje."Uniforme<br>";
            }if(count($dato['get_id_sist_pensu'])<1){
                $mensaje=$mensaje."Sistema Pensionario<br>";
            }if(count($dato['get_id_cuentab'])<1){
                $mensaje=$mensaje."Número de Cuentas<br>";
            }if($dato['list_usuario'][0]['terminos']==0){
                $mensaje=$mensaje."Aceptar la política de privacidad de datos";
            }

            if($mensaje!=""){
                echo "1<p>".$mensaje."</p>";
            }
    }

    public function Update_Datos_Completos($numero){
        $colaborador = Usuario::where('num_doc', $numero)
                    ->whereIn('estado', [1,4])
                    ->get();
            $id_usuario = $colaborador[0]['id_usuario'];
            Usuario::where('id_usuario', $id_usuario)->update([
                'datos_completos' => 1,
            ]);
    }
}

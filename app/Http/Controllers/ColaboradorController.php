<?php

namespace App\Http\Controllers;

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

class ColaboradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.colaborador.index', compact('list_notificacion'));
    }

    public function index_co()
    {
        $list_gerencia = Gerencia::where('estado',1)->orderBy('nom_gerencia','ASC')->get();
        return view('rrhh.colaborador.colaborador.index', compact('list_gerencia'));
    }

    public function list_co(Request $request)
    {
        $list_colaborador = Organigrama::get_list_colaborador(['id_gerencia'=>$request->id_gerencia]);
        return view('rrhh.colaborador.colaborador.lista', compact('list_colaborador'));
    }

    public function mail_co(Request $request)
    {
        $get_id = Usuario::findOrFail($request->id_usuario);

        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena = strlen($cadena);
        $password = "";
        $longitudPass = 6;
    
        for($i=1 ; $i<=$longitudPass ; $i++){
            $pos = rand(0,$longitudCadena-1);
            $password .= substr($cadena,$pos,1);
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
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress($get_id->usuario_email);

            $mail->isHTML(true);

            $mail->Subject = "Actualización de contraseña";
        
            $mail->Body =  "<h1> Hola, ".$get_id->usuario_nombres." ".$get_id->usuario_apater."</h1>
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
            
            echo 'Nombre y Apellidos '.$get_id->usuario_nombres.' '.$get_id->usuario_apater.' '.
            $get_id->usuario_amater.'<br>Correo: '.$get_id->usuario_email;
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function edit_co($id)
    {
        $get_id = Usuario::findOrFail($id);
        return view('rrhh.colaborador.colaborador.modal_editar',compact('get_id'));
    }

    public function update_co(Request $request,$id)
    {
        $request->validate([
            'usuario_codigoe' => 'required'
        ],[
            'usuario_codigoe.required' => 'Debe ingresar usuario.'
        ]);

        $valida = Usuario::where('usuario_codigo',$request->usuario_codigoe)->where('id_usuario', '!=', $id)->exists();

        if($valida){
            echo "error";
        }else{
            if($request->usuario_passworde){
                Usuario::findOrFail($id)->update([
                    'usuario_codigo' => $request->usuario_codigoe,
                    'usuario_password' => password_hash($request->usuario_passworde, PASSWORD_DEFAULT),
                    'password_desencriptado' => $request->usuario_passworde,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }else{
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
        $list_gerencia = Gerencia::where('estado',1)->orderBy('nom_gerencia','ASC')->get();
        return view('rrhh.colaborador.cesado.index', compact('list_gerencia'));
    }

    public function list_ce(Request $request)
    {
        $list_cesado = Usuario::get_list_cesado(['id_gerencia'=>$request->id_gerencia]);
        return view('rrhh.colaborador.cesado.lista', compact('list_cesado'));
    }

    public function edit_ce($id)
    {
        $get_id = Usuario::findOrFail($id);
        return view('rrhh.colaborador.cesado.modal_editar',compact('get_id'));
    }
}

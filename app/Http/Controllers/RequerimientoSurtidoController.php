<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model_Perfil;
use App\Models\RequerimientoSurtido;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class RequerimientoSurtidoController extends Controller
{
    protected $input;
    protected $Model_Perfil;
    protected $Model_RequerimientoSurtido;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Perfil = new Model_Perfil();
        $this->Model_RequerimientoSurtido = new RequerimientoSurtido();
    }
    
    public function index(){
            $dato['list_semanas'] = DB::connection('sqlsrv')
                                ->table('pedido_lnuno')
                                ->select('semana')
                                ->groupBy('semana')
                                ->orderBy('semana', 'ASC')
                                ->get();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(7);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('comercial.Requerimiento.index', $dato);
    }
    
    public function Buscar_Semana(){
            $semana = $this->input->post("semana");
            $anio = $this->input->post("anio");

            $semana = $semana ?? date('W');
            $anio = $anio ?? date('Y');

            $dato['list_requerimiento'] = DB::connection('sqlsrv')
                    ->table('pedido_lnuno')
                    ->whereIn('estado', [1, 3])
                    ->where('semana', $semana)
                    ->where('anio', $anio)
                    ->get();

            return view('comercial.Requerimiento.lista', $dato);
    }
    
    public function Modal_Requerimiento(){
        $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
        return view('comercial.Requerimiento.modal_registrar', $dato);
    }
    
    public function Insert_Requerimiento(){
            $data['anio'] = $this->input->post("anio");
            $dato['anio'] = $this->input->post("anio");
            $dato['semana'] = $this->input->post("semana");
            $path = $_FILES["drequerimiento"]["tmp_name"];

            $documento = IOFactory::load($path);

            $id_usuario = substr(session('usuario')->usuario_nombres, 0, 1) . session('usuario')->usuario_apater;

            //$documento = IOFactory::load($path);
            $hojaDeProductos = $documento->getSheet(0);

            $numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
            $letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
            //Convertir la letra al número de columna correspondiente
            $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
            // Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
            $id_usuario = substr(session('usuario')->usuario_nombres, 0, 1) . session('usuario')->usuario_apater;

            DB::connection('sqlsrv')->table('dpedido_lnunot')->where('user_reg', $id_usuario)->delete();
            $total = 0;
            $error = 0;
            $duplicados = 0;
            for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                # Las columnas están en este orden:
                # Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
                $dato['empresa'] = $hojaDeProductos->getCell('A' . $indiceFila)->getValue();
                $dato['costo'] = $hojaDeProductos->getCell('B' . $indiceFila)->getValue();
                $dato['pc'] = $hojaDeProductos->getCell('C' . $indiceFila)->getValue();
                $dato['pv'] = $hojaDeProductos->getCell('D' . $indiceFila)->getValue();
                $dato['pp'] = $hojaDeProductos->getCell('E' . $indiceFila)->getValue();
                $dato['pc_b4'] = $hojaDeProductos->getCell('F' . $indiceFila)->getValue();
                $dato['pv_b4'] = $hojaDeProductos->getCell('G' . $indiceFila)->getValue();
                $dato['pp_b4'] = $hojaDeProductos->getCell('H' . $indiceFila)->getValue();
                $dato['tipo_usuario'] = $hojaDeProductos->getCell('I' . $indiceFila)->getValue();
                $dato['tipo_prenda'] = $hojaDeProductos->getCell('J' . $indiceFila)->getValue();
                $dato['codigo_barra'] = $hojaDeProductos->getCell('K' . $indiceFila)->getValue();
                $dato['autogenerado'] = $hojaDeProductos->getCell('L' . $indiceFila)->getValue();
                $dato['estilo'] = $hojaDeProductos->getCell('M' . $indiceFila)->getValue();
                $dato['decripcion'] = $hojaDeProductos->getCell('N' . $indiceFila)->getValue();
                $dato['color'] = $hojaDeProductos->getCell('O' . $indiceFila)->getValue();
                $dato['talla'] = $hojaDeProductos->getCell('P' . $indiceFila)->getValue();
                $dato['stock'] = $hojaDeProductos->getCell('Q' . $indiceFila)->getValue();

                $dato['B01'] = $hojaDeProductos->getCell('T' . $indiceFila)->getValue();
                $dato['B02'] = $hojaDeProductos->getCell('U' . $indiceFila)->getValue();
                $dato['B03'] = $hojaDeProductos->getCell('V' . $indiceFila)->getValue();
                $dato['B04'] = $hojaDeProductos->getCell('W' . $indiceFila)->getValue();
                $dato['B05'] = $hojaDeProductos->getCell('X' . $indiceFila)->getValue();
                $dato['B06'] = $hojaDeProductos->getCell('Y' . $indiceFila)->getValue();
                $dato['B07'] = $hojaDeProductos->getCell('Z' . $indiceFila)->getValue();
                $dato['B08'] = $hojaDeProductos->getCell('AA' . $indiceFila)->getValue();
                $dato['B09'] = $hojaDeProductos->getCell('AB' . $indiceFila)->getValue();
                $dato['B10'] = $hojaDeProductos->getCell('AC' . $indiceFila)->getValue();
                $dato['B11'] = $hojaDeProductos->getCell('AD' . $indiceFila)->getValue();
                $dato['B12'] = $hojaDeProductos->getCell('AE' . $indiceFila)->getValue();
                $dato['B13'] = $hojaDeProductos->getCell('AF' . $indiceFila)->getValue();
                $dato['B14'] = $hojaDeProductos->getCell('AG' . $indiceFila)->getValue();
                $dato['B15'] = $hojaDeProductos->getCell('AH' . $indiceFila)->getValue();
                $dato['B16'] = $hojaDeProductos->getCell('AI' . $indiceFila)->getValue();
                $dato['B17'] = $hojaDeProductos->getCell('AJ' . $indiceFila)->getValue();
                $dato['B18'] = $hojaDeProductos->getCell('AK' . $indiceFila)->getValue();
                $dato['B19'] = $hojaDeProductos->getCell('AL' . $indiceFila)->getValue();
                $dato['B20'] = $hojaDeProductos->getCell('AM' . $indiceFila)->getValue();
            
                # Continúa con BEC y RN
                $dato['BEC'] = $hojaDeProductos->getCell('AN' . $indiceFila)->getValue();
                $dato['RN'] = strtoupper($hojaDeProductos->getCell('AO' . $indiceFila)->getValue());

                if (
                    substr($dato['tipo_usuario'], 0, 1) != "=" && $dato['tipo_usuario'] != "" &&
                    substr($dato['tipo_prenda'], 0, 1) != "=" && $dato['tipo_prenda'] != "" &&
                    substr($dato['codigo_barra'], 0, 1) != "=" && $dato['codigo_barra'] != "" &&
                    substr($dato['autogenerado'], 0, 1) != "=" && $dato['autogenerado'] != "" &&
                    substr($dato['estilo'], 0, 1) != "=" && $dato['estilo'] != "" &&
                    substr($dato['decripcion'], 0, 1) != "=" && $dato['decripcion'] != "" &&
                    substr($dato['color'], 0, 1) != "=" && $dato['color'] != "" &&
                    substr($dato['talla'], 0, 1) != "=" && $dato['talla'] != "" &&
                    substr($dato['stock'], 0, 1) != "=" && substr($dato['B01'], 0, 1) != "=" && substr($dato['B02'], 0, 1) != "=" &&
                    substr($dato['B03'], 0, 1) != "=" && substr($dato['B04'], 0, 1) != "=" &&
                    substr($dato['B05'], 0, 1) != "=" && substr($dato['B06'], 0, 1) != "=" &&
                    substr($dato['B07'], 0, 1) != "=" && substr($dato['B08'], 0, 1) != "=" &&
                    substr($dato['B09'], 0, 1) != "=" && substr($dato['B10'], 0, 1) != "=" &&
                    substr($dato['B11'], 0, 1) != "=" && substr($dato['B13'], 0, 1) != "=" &&
                    substr($dato['B14'], 0, 1) != "=" && substr($dato['B15'], 0, 1) != "=" &&
                    substr($dato['B16'], 0, 1) != "=" && substr($dato['B17'], 0, 1) != "=" &&
                    substr($dato['B12'], 0, 1) != "=" && substr($dato['BEC'], 0, 1) != "=" &&
                    substr($dato['B19'], 0, 1) != "=" && substr($dato['B20'], 0, 1) != "=" &&
                    substr($dato['B18'], 0, 1) != "=" && substr($dato['RN'], 0, 1) != ""   &&
                    strlen($dato['RN']) < 2
                ) {


                    $total = $total + intval(strval($dato['B01'])) + intval(strval($dato['B02'])) +
                        intval(strval($dato['B03'])) + intval(strval($dato['B04'])) +
                        intval(strval($dato['B05'])) + intval(strval($dato['B06'])) +
                        intval(strval($dato['B07'])) + intval(strval($dato['B08'])) +
                        intval(strval($dato['B09'])) + intval(strval($dato['B10'])) +
                        intval(strval($dato['B11'])) + intval(strval($dato['B13'])) + intval(strval($dato['B12'])) +
                        intval(strval($dato['B14'])) + intval(strval($dato['B15'])) + intval(strval($dato['BEC'])) +
                        intval(strval($dato['B16'])) + intval(strval($dato['B17'])) + intval(strval($dato['B18'])) +
                        intval(strval($dato['B19'])) + intval(strval($dato['B20']));
                    $list_duplicados = DB::connection('sqlsrv')
                                ->table('dpedido_lnuno')
                                ->where('codigo_barra', $dato['codigo_barra'])
                                ->where('semana', $dato['semana'])
                                ->where('anio', $dato['anio'])
                                ->get();
                    $dato['caracter'] = "";

                    if ((trim($dato['RN']) !== 'N' && trim($dato['RN']) !== 'R' && trim($dato['RN']) !== 'T') || count($list_duplicados) > 0) {
                        $duplicados = $duplicados + 1;
                        if (trim($dato['RN']) !== 'N' && trim($dato['RN']) !== 'R' && trim($dato['RN']) !== 'T') {
                            $dato['caracter'] = "Caracter no permitido:" . $dato['RN'];
                            $this->Model_RequerimientoSurtido->insert_cuenta($dato, $id_usuario);
                        } else {
                            $dato['caracter'] = "Duplicado";
                            $this->Model_RequerimientoSurtido->insert_cuenta($dato, $list_duplicados[0]['user_reg']);
                        }
                    } else {
                        $this->Model_RequerimientoSurtido->insert_cuenta($dato);
                    }
                } else {

                    $error = $error + 1;
                    if (
                        substr($dato['tipo_usuario'], 0, 1) == "=" || $dato['tipo_usuario'] == "" ||
                        substr($dato['tipo_prenda'], 0, 1) == "=" || $dato['tipo_prenda'] == "" ||
                        substr($dato['codigo_barra'], 0, 1) == "=" || $dato['codigo_barra'] == "" ||
                        substr($dato['autogenerado'], 0, 1) == "=" || $dato['autogenerado'] == "" ||
                        substr($dato['estilo'], 0, 1) == "=" || $dato['estilo'] == "" ||
                        substr($dato['decripcion'], 0, 1) == "=" || $dato['decripcion'] == "" ||
                        substr($dato['color'], 0, 1) == "=" || $dato['color'] == "" ||
                        substr($dato['talla'], 0, 1) == "=" || $dato['talla'] == "" ||
                        substr($dato['stock'], 0, 1) == "=" || substr($dato['B01'], 0, 1) == "=" || substr($dato['B02'], 0, 1) == "=" ||
                        substr($dato['B03'], 0, 1) == "=" || substr($dato['B04'], 0, 1) == "=" ||
                        substr($dato['B05'], 0, 1) == "=" || substr($dato['B06'], 0, 1) == "=" ||
                        substr($dato['B07'], 0, 1) == "=" || substr($dato['B08'], 0, 1) == "=" ||
                        substr($dato['B09'], 0, 1) == "=" || substr($dato['B10'], 0, 1) == "=" ||
                        substr($dato['B11'], 0, 1) == "=" || substr($dato['B13'], 0, 1) == "=" ||
                        substr($dato['B14'], 0, 1) == "=" || substr($dato['B15'], 0, 1) == "=" ||
                        substr($dato['B16'], 0, 1) == "=" || substr($dato['B17'], 0, 1) == "=" ||
                        substr($dato['B12'], 0, 1) == "=" || substr($dato['BEC'], 0, 1) == "=" ||
                        substr($dato['B19'], 0, 1) == "=" || substr($dato['B20'], 0, 1) == "=" ||
                        substr($dato['B18'], 0, 1) == "=" || substr($dato['RN'], 0, 1) == ""
                    ) {
                        $columna = "";
                        if (substr($dato['tipo_usuario'], 0, 1) == "=" || $dato['tipo_usuario'] == "") {
                            $columna = $columna . "I,";
                        }
                        if (substr($dato['tipo_prenda'], 0, 1) == "=" || $dato['tipo_prenda'] == "") {
                            $columna = $columna . "J,";
                        }
                        if (substr($dato['codigo_barra'], 0, 1) == "=" || $dato['codigo_barra'] == "") {
                            $columna = $columna . "K,";
                        }
                        if (substr($dato['autogenerado'], 0, 1) == "=" || $dato['autogenerado'] == "") {
                            $columna = $columna . "L,";
                        }
                        if (substr($dato['estilo'], 0, 1) == "=" || $dato['estilo'] == "") {
                            $columna = $columna . "M,";
                        }
                        if (substr($dato['decripcion'], 0, 1) == "=" || $dato['decripcion'] == "") {
                            $columna = $columna . "N,";
                        }
                        if (substr($dato['color'], 0, 1) == "=" || $dato['color'] == "") {
                            $columna = $columna . "O,";
                        }
                        if (substr($dato['talla'], 0, 1) == "=" || $dato['talla'] == "") {
                            $columna = $columna . "P,";
                        }
                        if (substr($dato['stock'], 0, 1) == "=") {
                            $columna = $columna . "Q,";
                        }
                        if (substr($dato['B01'], 0, 1) == "=") {
                            $columna = $columna . "T,";
                        }
                        if (substr($dato['B02'], 0, 1) == "=") {
                            $columna = $columna . "U,";
                        }
                        if (substr($dato['B03'], 0, 1) == "=") {
                            $columna = $columna . "V,";
                        }
                        if (substr($dato['B04'], 0, 1) == "=") {
                            $columna = $columna . "W,";
                        }
                        if (substr($dato['B05'], 0, 1) == "=") {
                            $columna = $columna . "X,";
                        }
                        if (substr($dato['B06'], 0, 1) == "=") {
                            $columna = $columna . "Y,";
                        }
                        if (substr($dato['B07'], 0, 1) == "=") {
                            $columna = $columna . "Z,";
                        }
                        if (substr($dato['B08'], 0, 1) == "=") {
                            $columna = $columna . "AA,";
                        }
                        if (substr($dato['B09'], 0, 1) == "=") {
                            $columna = $columna . "AB,";
                        }
                        if (substr($dato['B10'], 0, 1) == "=") {
                            $columna = $columna . "AC,";
                        }
                        if (substr($dato['B11'], 0, 1) == "=") {
                            $columna = $columna . "AD,";
                        }
                        if (substr($dato['B12'], 0, 1) == "=") {
                            $columna = $columna . "AE,";
                        }
                        if (substr($dato['B13'], 0, 1) == "=") {
                            $columna = $columna . "AF,";
                        }
                        if (substr($dato['B14'], 0, 1) == "=") {
                            $columna = $columna . "AG,";
                        }
                        if (substr($dato['B15'], 0, 1) == "=") {
                            $columna = $columna . "AH,";
                        }
                        if (substr($dato['B16'], 0, 1) == "=") {
                            $columna = $columna . "AI,";
                        }
                        if (substr($dato['B17'], 0, 1) == "=") {
                            $columna = $columna . "AJ,";
                        }
                        if (substr($dato['B18'], 0, 1) == "=") {
                            $columna = $columna . "AK,";
                        }
                        if (substr($dato['B19'], 0, 1) == "=") {
                            $columna = $columna . "AL,";
                        }
                        if (substr($dato['B20'], 0, 1) == "=") {
                            $columna = $columna . "AM,";
                        }
                        if (substr($dato['RN'], 0, 1) == "=" || $dato['RN'] == "") {
                            $columna = $columna . "AO,";
                        }
                        $dato['caracter'] = "Caracter no permitido, Fila " . $indiceFila . " Columna " . $columna;
                        $this->Model_RequerimientoSurtido->insert_cuenta($dato);
                    }
                }
            }
            if ($duplicados > 0 || $error > 0) {
                echo "4<a class='btn mb-2 mr-2' style='background-color: #28a745 !important;' href='" . url("RequerimientoSurtido/Excel_Duplicado/{$id_usuario}/{$dato['semana']}") . "'>
                    <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,172v-172h172v172z' fill='none'></path><g fill='#ffffff'><path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path></g></g></svg>
                </a>";
            } else {
                $list_duplicadose = $this->Model_RequerimientoSurtido->get_list_duplicadose($dato);
                if (count($list_duplicadose) > 0) {
                    echo "3<a class='btn mb-2 mr-2' style='background-color: #28a745 !important;' href='" . url("RequerimientoSurtido/Excel_DuplicadoU/{$id_usuario}/{$dato['semana']}") . "'>
                    <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,172v-172h172v172z' fill='none'></path><g fill='#ffffff'><path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path></g></g></svg>
                </a>";
                } else {
                    $list_archivo = $this->Model_RequerimientoSurtido->ultimo_archivo($dato);
                    $dato['archivo'] = (count($list_archivo) + 1);
                    $data['archivo'] = (count($list_archivo) + 1);
                    $this->Model_RequerimientoSurtido->insert_pedido($dato);
                    $list_pedido = $this->Model_RequerimientoSurtido->get_list_pedido($dato);

                    foreach ($list_pedido as $list) {
                        $data['id_pedido_lnuno'] = $list['id_pedido_lnuno'];
                        $data['tipo_usuario'] = $list['tipo_usuario'];
                        $data['semana'] = $list['semana'];
                        $this->Model_RequerimientoSurtido->insert_ccuenta($data);
                    }

                    DB::connection('sqlsrv')->table('dpedido_lnunot')->where('user_reg', $id_usuario)->delete();
                    if ($error > 0) {
                        echo "1ERRORES: $error<br>TOTAL: $total";
                    } else {
                        echo "2TOTAL: $total";
                    };
                }
            }
    }
    
    public function Excel_Duplicado($usuario, $semana) // RRHH
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Mercaderia');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->setCellValue("A1", 'SKU');
        $sheet->setCellValue("B1", "STYLO");
        $sheet->setCellValue("C1", "USUARIO");
        $sheet->setCellValue("D1", "R/N");
        $sheet->setCellValue("E1", "Caracter no permitido");
        $data = $this->Model_RequerimientoSurtido->get_list_duplicado($usuario, $semana);

        $fila = 1;
        foreach ($data as $d) {
            $fila = $fila + 1;
            //echo $fila." ".$d['sfa_descrip']."<br>";
            $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", $d['codigo_barra']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $d['estilo']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", $d['user_duplicado']);
            if ($d['RN'] != "N" && $d['RN'] != "R") {
                $spreadsheet->getActiveSheet()->setCellValue("D{$fila}", "Inválido");
            }

            if ($d['caracter'] != "") {
                $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", $d['caracter']);
            }

            //border
            $sheet->getStyle("A{$fila}:E{$fila}")->applyFromArray($styleThinBlackBorderOutline);
        }

        $sheet->getStyle('A1:E1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //$sheet->getStyle('A2:F100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //Custom width for Individual Columns
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(14);
        $sheet->getColumnDimension('E')->setWidth(40);

        //final part
        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Duplicados';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

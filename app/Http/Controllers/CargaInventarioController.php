<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AreaErrorPicking;
use App\Models\Base;
use App\Models\Capacitacion;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\ErroresPicking;
use App\Models\ErrorPicking;
use App\Models\Gerencia;
use App\Models\Inventario;
use App\Models\Mes;
use App\Models\NivelJerarquico;
use App\Models\Procesos;
use App\Models\ProcesosHistorial;
use App\Models\Puesto;
use App\Models\SeguimientoCoordinador;
use App\Models\SupervisionTienda;
use App\Models\TipoPortal;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TallaErrorPicking;
use App\Models\TipoErrorPicking;
use App\Models\User;
use App\Models\Usuario;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CargaInventarioController extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.carga_inventario.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list_ci()
    {
        $list_inventario = Inventario::get_list_inventario();
        // dd($list_inventario);
        return view('logistica.carga_inventario.lista', compact('list_inventario'));
    }


    public function edit_ci($id)
    {
        $get_id = Inventario::findOrFail($id);
        // dd($get_id);

        $list_base = Base::get_list_todas_bases_agrupadas_bi();
        $list_usuario = Usuario::get_list_usuario_inventario();

        return view('logistica.carga_inventario.modal_editar', compact(
            'list_base',
            'list_usuario',
            'get_id'
        ));
    }



    public function create_ci()
    {

        $list_base = Base::get_list_todas_bases_agrupadas_bi();
        $list_usuario = Usuario::get_list_usuario_inventario();

        return view('logistica.carga_inventario.modal_registrar', compact(
            'list_base',
            'list_usuario'
        ));
    }



    public function update_ci(Request $request)
    {
        $request->validate([
            'fechae' => 'required',
            'basee' => 'required',
            'responsablee' => 'required',

        ], [
            'fecha.required' => 'Debe ingresar fecha.',
            'base.required' => 'Debe ingresar nase.',
            'responsable.required' => 'Debe seleccionar responsable',

        ]);

        $dato['id_inventario'] = $request->id_inventario;
        $dato['fecha'] = $request->fechae;
        $dato['base'] = $request->basee;
        $dato['id_responsable'] = $request->responsablee;

        $path = $_FILES["archivoe"]["tmp_name"];


        // Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
        Inventario::elimina_carga_inventario_temporal();
        $dato['mod'] = 2;
        $existe = count(Inventario::valida_carga_inventario($dato));

        if ($existe > 0) {
            echo "1Existe un registro con los mismos datos";
        } else {
            $total = 0;
            $error = 0;
            $duplicados = 0;
            if ($path != "") {
                $documento = IOFactory::load($path);
                $hojaDeProductos = $documento->getSheet(0);

                $numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
                $letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
                //Convertir la letra al número de columna correspondiente
                $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
                for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                    # Las columnas están en este orden:
                    # Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
                    $dato['categoria'] = $hojaDeProductos->getCell('A' . $indiceFila)->getValue();
                    $dato['familia'] = $hojaDeProductos->getCell('B' . $indiceFila)->getValue();
                    $dato['ubicacion'] = $hojaDeProductos->getCell('C' . $indiceFila)->getValue();
                    $dato['barra'] = $hojaDeProductos->getCell('D' . $indiceFila)->getValue();
                    $dato['estilo'] = $hojaDeProductos->getCell('E' . $indiceFila)->getValue();
                    $dato['generico'] = $hojaDeProductos->getCell('F' . $indiceFila)->getValue();
                    $dato['color'] = $hojaDeProductos->getCell('G' . $indiceFila)->getValue();
                    $dato['talla'] = $hojaDeProductos->getCell('H' . $indiceFila)->getValue();
                    $dato['linea'] = $hojaDeProductos->getCell('I' . $indiceFila)->getValue();
                    $dato['tipo_prenda'] = $hojaDeProductos->getCell('J' . $indiceFila)->getValue();
                    $dato['usuario'] = $hojaDeProductos->getCell('K' . $indiceFila)->getValue();
                    $dato['marca'] = $hojaDeProductos->getCell('L' . $indiceFila)->getValue();
                    $dato['tela'] = $hojaDeProductos->getCell('M' . $indiceFila)->getValue();
                    $dato['descripcion'] = $hojaDeProductos->getCell('N' . $indiceFila)->getValue();
                    $dato['unidad'] = $hojaDeProductos->getCell('O' . $indiceFila)->getValue();
                    $dato['fcreacion'] = $hojaDeProductos->getCell('P' . $indiceFila)->getValue();
                    $dato['conteo'] = $hojaDeProductos->getCell('Q' . $indiceFila)->getValue();
                    $dato['stock'] = $hojaDeProductos->getCell('R' . $indiceFila)->getValue();
                    $dato['diferencia'] = $hojaDeProductos->getCell('S' . $indiceFila)->getValue();
                    $dato['valor'] = $hojaDeProductos->getCell('T' . $indiceFila)->getValue();
                    $dato['poriginal'] = $hojaDeProductos->getCell('U' . $indiceFila)->getValue();
                    $dato['pventa'] = $hojaDeProductos->getCell('V' . $indiceFila)->getValue();
                    $dato['costo'] = $hojaDeProductos->getCell('W' . $indiceFila)->getValue();
                    $dato['validacion'] = $hojaDeProductos->getCell('X' . $indiceFila)->getValue();


                    if (substr($dato['categoria'], 0, 1) != "=") {

                        $dato['caracter'] = "";
                        $total = $total + 1;
                        Inventario::insert_carga_inventario_temporal($dato);
                    } else {

                        $error = $error + 1;
                        //echo $error;
                        if (
                            substr($dato['categoria'], 0, 1) == "=" && $dato['categoria'] == "" &&
                            substr($dato['familia'], 0, 1) == "=" && $dato['familia'] == "" &&
                            substr($dato['ubicacion'], 0, 1) == "=" && $dato['ubicacion'] == "" &&
                            substr($dato['barra'], 0, 1) == "=" && $dato['barra'] == "" &&
                            substr($dato['estilo'], 0, 1) == "=" && $dato['estilo'] == "" &&
                            substr($dato['generico'], 0, 1) == "=" && $dato['generico'] == "" &&
                            substr($dato['color'], 0, 1) == "=" && $dato['color'] == "" &&
                            substr($dato['talla'], 0, 1) == "=" && $dato['talla'] == "" &&
                            substr($dato['linea'], 0, 1) == "=" && $dato['linea'] == "" &&
                            substr($dato['tipo_prenda'], 0, 1) == "=" && $dato['tipo_prenda'] == "" &&
                            substr($dato['usuario'], 0, 1) == "=" && $dato['usuario'] == "" &&
                            substr($dato['marca'], 0, 1) == "=" && $dato['marca'] == "" &&
                            substr($dato['tela'], 0, 1) == "=" && $dato['tela'] == "" &&
                            substr($dato['descripcion'], 0, 1) == "=" && $dato['descripcion'] == "" &&
                            substr($dato['unidad'], 0, 1) == "=" && $dato['unidad'] == "" &&
                            substr($dato['fcreacion'], 0, 1) == "=" && $dato['fcreacion'] == "" &&
                            substr($dato['conteo'], 0, 1) == "=" && $dato['conteo'] == "" &&
                            substr($dato['stock'], 0, 1) == "=" && $dato['stock'] == "" &&
                            substr($dato['diferencia'], 0, 1) == "=" && $dato['diferencia'] == "" &&
                            substr($dato['valor'], 0, 1) == "=" && $dato['valor'] == "" &&
                            substr($dato['poriginal'], 0, 1) == "=" && $dato['poriginal'] == "" &&
                            substr($dato['pventa'], 0, 1) == "=" && $dato['pventa'] == "" &&
                            substr($dato['costo'], 0, 1) == "=" && $dato['costo'] == "" &&
                            substr($dato['validacion'], 0, 1) == "=" && $dato['validacion'] == ""
                        ) {
                            $columna = "";
                            if (substr($dato['categoria'], 0, 1) == "=" || $dato['categoria'] == "") {
                                $columna = $columna . "A,";
                            }
                            if (substr($dato['familia'], 0, 1) == "=" || $dato['familia'] == "") {
                                $columna = $columna . "B,";
                            }
                            if (substr($dato['ubicacion'], 0, 1) == "=" || $dato['ubicacion'] == "") {
                                $columna = $columna . "C,";
                            }
                            if (substr($dato['barra'], 0, 1) == "=" || $dato['barra'] == "") {
                                $columna = $columna . "D,";
                            }
                            if (substr($dato['estilo'], 0, 1) == "=" || $dato['estilo'] == "") {
                                $columna = $columna . "E,";
                            }
                            if (substr($dato['generico'], 0, 1) == "=" || $dato['generico'] == "") {
                                $columna = $columna . "F,";
                            }
                            if (substr($dato['color'], 0, 1) == "=" || $dato['color'] == "") {
                                $columna = $columna . "G,";
                            }
                            if (substr($dato['talla'], 0, 1) == "=" || $dato['talla'] == "") {
                                $columna = $columna . "H,";
                            }
                            if (substr($dato['linea'], 0, 1) == "=" || $dato['linea'] == "") {
                                $columna = $columna . "I,";
                            }
                            if (substr($dato['tipo_prenda'], 0, 1) == "=" || $dato['tipo_prenda'] == "") {
                                $columna = $columna . "J,";
                            }
                            if (substr($dato['usuario'], 0, 1) == "=" || $dato['usuario'] == "") {
                                $columna = $columna . "K,";
                            }
                            if (substr($dato['marca'], 0, 1) == "=" || $dato['marca'] == "") {
                                $columna = $columna . "L,";
                            }
                            if (substr($dato['tela'], 0, 1) == "=" || $dato['tela'] == "") {
                                $columna = $columna . "M,";
                            }
                            if (substr($dato['descripcion'], 0, 1) == "=" || $dato['descripcion'] == "") {
                                $columna = $columna . "N,";
                            }
                            if (substr($dato['unidad'], 0, 1) == "=" || $dato['unidad'] == "") {
                                $columna = $columna . "O,";
                            }
                            if (substr($dato['fcreacion'], 0, 1) == "=" || $dato['fcreacion'] == "") {
                                $columna = $columna . "P,";
                            }
                            if (substr($dato['conteo'], 0, 1) == "=" || $dato['conteo'] == "") {
                                $columna = $columna . "Q,";
                            }
                            if (substr($dato['stock'], 0, 1) == "=" || $dato['stock'] == "") {
                                $columna = $columna . "R,";
                            }
                            if (substr($dato['diferencia'], 0, 1) == "=" || $dato['diferencia'] == "") {
                                $columna = $columna . "S,";
                            }
                            if (substr($dato['valor'], 0, 1) == "=" || $dato['valor'] == "") {
                                $columna = $columna . "T,";
                            }
                            if (substr($dato['poriginal'], 0, 1) == "=" || $dato['poriginal'] == "") {
                                $columna = $columna . "U,";
                            }
                            if (substr($dato['pventa'], 0, 1) == "=" || $dato['pventa'] == "") {
                                $columna = $columna . "V,";
                            }
                            if (substr($dato['costo'], 0, 1) == "=" || $dato['costo'] == "") {
                                $columna = $columna . "W,";
                            }
                            if (substr($dato['validacion'], 0, 1) == "=" || $dato['validacion'] == "") {
                                $columna = $columna . "X,";
                            }
                            $dato['caracter'] = "Caracter no permitido, Fila " . $indiceFila . " Columna " . $columna;
                            //echo $dato['caracter'];
                            Inventario::insert_carga_inventario_temporal($dato);
                        }
                    }
                }
            }

            if ($error > 0) {
                echo "2<a class='btn mb-2 mr-2' style='background-color: #28a745 !important;' href='" .  "'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,172v-172h172v172z' fill='none'></path><g fill='#ffffff'><path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path></g></g></svg>
                    </a><br>ERRORES: $error<br>TOTAL: $total";
            } else {
                $dato['get_id'] = Inventario::busca_carga_inventario($dato['id_inventario']);
                $dato['cod_inventario'] = $dato['get_id'][0]['cod_inventario'];
                Inventario::update_carga_inventario($dato);
                Inventario::elimina_carga_inventario_temporal($dato);
                echo "3TOTAL: $total";
            }
        }
    }

    public function store_ci(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
            'base' => 'required',
            'responsable' => 'required',

        ], [
            'fecha.required' => 'Debe ingresar fecha.',
            'base.required' => 'Debe ingresar nase.',
            'responsable.required' => 'Debe seleccionar responsable',

        ]);

        $dato['fecha'] = $request->fecha;
        $dato['base'] = $request->base;
        $dato['id_responsable'] = $request->responsable;
        // dd($dato['id_responsable']);
        $path = $_FILES["archivo"]["tmp_name"];
        $documento = IOFactory::load($path);
        $hojaDeProductos = $documento->getSheet(0);

        $numeroMayorDeFila = $hojaDeProductos->getHighestRow(); // Numérico
        $letraMayorDeColumna = $hojaDeProductos->getHighestColumn(); // Letra
        //Convertir la letra al número de columna correspondiente
        $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
        // Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
        Inventario::elimina_carga_inventario_temporal();
        $dato['mod'] = 1;
        $existe = count(Inventario::valida_carga_inventario($dato));

        if ($existe > 0) {
            echo "1Existe un registro con los mismos datos";
        } else {
            $total = 0;
            $error = 0;
            $duplicados = 0;
            for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                # Código de barras, Descripción, Precio de Compra, Precio de Venta, Existencia
                $dato['categoria'] = $hojaDeProductos->getCell('A' . $indiceFila)->getValue();
                $dato['familia'] = $hojaDeProductos->getCell('B' . $indiceFila)->getValue();
                $dato['ubicacion'] = $hojaDeProductos->getCell('C' . $indiceFila)->getValue();
                $dato['barra'] = $hojaDeProductos->getCell('D' . $indiceFila)->getValue();

                $dato['estilo'] = $hojaDeProductos->getCell('E' . $indiceFila)->getValue();
                $dato['generico'] = $hojaDeProductos->getCell('F' . $indiceFila)->getValue();
                $dato['color'] = $hojaDeProductos->getCell('G' . $indiceFila)->getValue();
                $dato['talla'] = $hojaDeProductos->getCell('H' . $indiceFila)->getValue();
                $dato['linea'] = $hojaDeProductos->getCell('I' . $indiceFila)->getValue();
                $dato['tipo_prenda'] = $hojaDeProductos->getCell('J' . $indiceFila)->getValue();
                $dato['usuario'] = $hojaDeProductos->getCell('K' . $indiceFila)->getValue();
                $dato['marca'] = $hojaDeProductos->getCell('L' . $indiceFila)->getValue();
                $dato['tela'] = $hojaDeProductos->getCell('M' . $indiceFila)->getValue();
                $dato['descripcion'] = $hojaDeProductos->getCell('N' . $indiceFila)->getValue();
                $dato['unidad'] = $hojaDeProductos->getCell('O' . $indiceFila)->getValue();
                $dato['fcreacion'] = $hojaDeProductos->getCell('P' . $indiceFila)->getValue();
                $dato['conteo'] = $hojaDeProductos->getCell('Q' . $indiceFila)->getValue();
                $dato['stock'] = $hojaDeProductos->getCell('R' . $indiceFila)->getValue();
                $dato['diferencia'] = $hojaDeProductos->getCell('S' . $indiceFila)->getValue();
                $dato['valor'] = $hojaDeProductos->getCell('T' . $indiceFila)->getValue();
                $dato['poriginal'] = $hojaDeProductos->getCell('U' . $indiceFila)->getValue();
                $dato['pventa'] = $hojaDeProductos->getCell('V' . $indiceFila)->getValue();
                $dato['costo'] = $hojaDeProductos->getCell('W' . $indiceFila)->getValue();
                $dato['validacion'] = $hojaDeProductos->getCell('X' . $indiceFila)->getValue();


                if (substr($dato['categoria'], 0, 1) != "=") {

                    $dato['caracter'] = "";
                    $total = $total + 1;
                    Inventario::insert_carga_inventario_temporal($dato);
                } else {

                    $error = $error + 1;
                    //echo $error;
                    if (
                        substr($dato['categoria'], 0, 1) == "=" && $dato['categoria'] == "" &&
                        substr($dato['familia'], 0, 1) == "=" && $dato['familia'] == "" &&
                        substr($dato['ubicacion'], 0, 1) == "=" && $dato['ubicacion'] == "" &&
                        substr($dato['barra'], 0, 1) == "=" && $dato['barra'] == "" &&
                        substr($dato['estilo'], 0, 1) == "=" && $dato['estilo'] == "" &&
                        substr($dato['generico'], 0, 1) == "=" && $dato['generico'] == "" &&
                        substr($dato['color'], 0, 1) == "=" && $dato['color'] == "" &&
                        substr($dato['talla'], 0, 1) == "=" && $dato['talla'] == "" &&
                        substr($dato['linea'], 0, 1) == "=" && $dato['linea'] == "" &&
                        substr($dato['tipo_prenda'], 0, 1) == "=" && $dato['tipo_prenda'] == "" &&
                        substr($dato['usuario'], 0, 1) == "=" && $dato['usuario'] == "" &&
                        substr($dato['marca'], 0, 1) == "=" && $dato['marca'] == "" &&
                        substr($dato['tela'], 0, 1) == "=" && $dato['tela'] == "" &&
                        substr($dato['descripcion'], 0, 1) == "=" && $dato['descripcion'] == "" &&
                        substr($dato['unidad'], 0, 1) == "=" && $dato['unidad'] == "" &&
                        substr($dato['fcreacion'], 0, 1) == "=" && $dato['fcreacion'] == "" &&
                        substr($dato['conteo'], 0, 1) == "=" && $dato['conteo'] == "" &&
                        substr($dato['stock'], 0, 1) == "=" && $dato['stock'] == "" &&
                        substr($dato['diferencia'], 0, 1) == "=" && $dato['diferencia'] == "" &&
                        substr($dato['valor'], 0, 1) == "=" && $dato['valor'] == "" &&
                        substr($dato['poriginal'], 0, 1) == "=" && $dato['poriginal'] == "" &&
                        substr($dato['pventa'], 0, 1) == "=" && $dato['pventa'] == "" &&
                        substr($dato['costo'], 0, 1) == "=" && $dato['costo'] == "" &&
                        substr($dato['validacion'], 0, 1) == "=" && $dato['validacion'] == ""
                    ) {
                        $columna = "";
                        if (substr($dato['categoria'], 0, 1) == "=" || $dato['categoria'] == "") {
                            $columna = $columna . "A,";
                        }
                        if (substr($dato['familia'], 0, 1) == "=" || $dato['familia'] == "") {
                            $columna = $columna . "B,";
                        }
                        if (substr($dato['ubicacion'], 0, 1) == "=" || $dato['ubicacion'] == "") {
                            $columna = $columna . "C,";
                        }
                        if (substr($dato['barra'], 0, 1) == "=" || $dato['barra'] == "") {
                            $columna = $columna . "D,";
                        }
                        if (substr($dato['estilo'], 0, 1) == "=" || $dato['estilo'] == "") {
                            $columna = $columna . "E,";
                        }
                        if (substr($dato['generico'], 0, 1) == "=" || $dato['generico'] == "") {
                            $columna = $columna . "F,";
                        }
                        if (substr($dato['color'], 0, 1) == "=" || $dato['color'] == "") {
                            $columna = $columna . "G,";
                        }
                        if (substr($dato['talla'], 0, 1) == "=" || $dato['talla'] == "") {
                            $columna = $columna . "H,";
                        }
                        if (substr($dato['linea'], 0, 1) == "=" || $dato['linea'] == "") {
                            $columna = $columna . "I,";
                        }
                        if (substr($dato['tipo_prenda'], 0, 1) == "=" || $dato['tipo_prenda'] == "") {
                            $columna = $columna . "J,";
                        }
                        if (substr($dato['usuario'], 0, 1) == "=" || $dato['usuario'] == "") {
                            $columna = $columna . "K,";
                        }
                        if (substr($dato['marca'], 0, 1) == "=" || $dato['marca'] == "") {
                            $columna = $columna . "L,";
                        }
                        if (substr($dato['tela'], 0, 1) == "=" || $dato['tela'] == "") {
                            $columna = $columna . "M,";
                        }
                        if (substr($dato['descripcion'], 0, 1) == "=" || $dato['descripcion'] == "") {
                            $columna = $columna . "N,";
                        }
                        if (substr($dato['unidad'], 0, 1) == "=" || $dato['unidad'] == "") {
                            $columna = $columna . "O,";
                        }
                        if (substr($dato['fcreacion'], 0, 1) == "=" || $dato['fcreacion'] == "") {
                            $columna = $columna . "P,";
                        }
                        if (substr($dato['conteo'], 0, 1) == "=" || $dato['conteo'] == "") {
                            $columna = $columna . "Q,";
                        }
                        if (substr($dato['stock'], 0, 1) == "=" || $dato['stock'] == "") {
                            $columna = $columna . "R,";
                        }
                        if (substr($dato['diferencia'], 0, 1) == "=" || $dato['diferencia'] == "") {
                            $columna = $columna . "S,";
                        }
                        if (substr($dato['valor'], 0, 1) == "=" || $dato['valor'] == "") {
                            $columna = $columna . "T,";
                        }
                        if (substr($dato['poriginal'], 0, 1) == "=" || $dato['poriginal'] == "") {
                            $columna = $columna . "U,";
                        }
                        if (substr($dato['pventa'], 0, 1) == "=" || $dato['pventa'] == "") {
                            $columna = $columna . "V,";
                        }
                        if (substr($dato['costo'], 0, 1) == "=" || $dato['costo'] == "") {
                            $columna = $columna . "W,";
                        }
                        if (substr($dato['validacion'], 0, 1) == "=" || $dato['validacion'] == "") {
                            $columna = $columna . "X,";
                        }
                        $dato['caracter'] = "Caracter no permitido, Fila " . $indiceFila . " Columna " . $columna;
                        //echo $dato['caracter'];
                        Inventario::insert_carga_inventario_temporal($dato);
                    }
                }
            }
            if ($error > 0) {
                echo "2<a class='btn mb-2 mr-2' style='background-color: #28a745 !important;'>
                    <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,172v-172h172v172z' fill='none'></path><g fill='#ffffff'><path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path></g></g></svg>
                </a><br>ERRORES: $error<br>TOTAL: $total";
            } else {
                $anio = date('Y');
                $totalRows_t = count(Inventario::cont_carga_inverntario());
                $aniof = substr($anio, 2, 2);
                if ($totalRows_t < 9) {
                    $codigofinal = "I" . $aniof . "0000" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 8 && $totalRows_t < 99) {
                    $codigofinal = "I" . $aniof . "000" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 98 && $totalRows_t < 999) {
                    $codigofinal = "I" . $aniof . "00" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 998 && $totalRows_t < 9999) {
                    $codigofinal = "I" . $aniof . "0" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 9998) {
                    $codigofinal = "I" . $aniof . ($totalRows_t + 1);
                }
                $dato['cod_inventario'] = $codigofinal;
                Inventario::insert_carga_inventario($dato);
                Inventario::elimina_carga_inventario_temporal();
                echo "3TOTAL: $total";
            }
        }
        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Datos guardados exitosamente');
    }


    public function formato_carga_inventario()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Ejemplo Carga Inventario');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->setCellValue("A1", 'Categoría');
        $sheet->setCellValue("B1", "Familia");
        $sheet->setCellValue("C1", "Ubicación");
        $sheet->setCellValue("D1", "Barra");
        $sheet->setCellValue("E1", "Estilo");
        $sheet->setCellValue("F1", "Generico");
        $sheet->setCellValue("G1", "Color");
        $sheet->setCellValue("H1", "Talla");
        $sheet->setCellValue("I1", "Linea");
        $sheet->setCellValue("J1", "Tipo Prenda");
        $sheet->setCellValue("K1", "Usuario");
        $sheet->setCellValue("L1", "Marca");
        $sheet->setCellValue("M1", "Tela");
        $sheet->setCellValue("N1", "Descripción");
        $sheet->setCellValue("O1", "Unidad");
        $sheet->setCellValue("P1", "FCreación");
        $sheet->setCellValue("Q1", "Conteo");
        $sheet->setCellValue("R1", "Stock");
        $sheet->setCellValue("S1", "Diferencia");
        $sheet->setCellValue("T1", "Valor");
        $sheet->setCellValue("U1", "POriginal");
        $sheet->setCellValue("V1", "PVenta");
        $sheet->setCellValue("W1", "Costo");
        $sheet->setCellValue("X1", "Validación");


        $sheet->setCellValue("A2", 'Prenda');
        $sheet->setCellValue("B2", "VARIOS");
        $sheet->setCellValue("C2", "ALMACÉN");
        $sheet->setCellValue("D2", "157214149454");
        $sheet->setCellValue("E2", "JMC-420");
        $sheet->setCellValue("F2", "TRD285L117");
        $sheet->setCellValue("G2", "AZUL NOCHE");
        $sheet->setCellValue("H2", "38");
        $sheet->setCellValue("I2", "BAJA");
        $sheet->setCellValue("J2", "TORERO");
        $sheet->setCellValue("K2", "DAMA");
        $sheet->setCellValue("L2", "MAGNOLIA");
        $sheet->setCellValue("M2", "DENIM GAVIOTA PLUS");
        $sheet->setCellValue("N2", "TORERO MAGNOLIA DENIM ST GAVIOTA PLUS M/TMG22-0101 DAMA");
        $sheet->setCellValue("O2", "UNIDAD");
        $sheet->setCellValue("P2", "15/01/2022");
        $sheet->setCellValue("Q2", "6");
        $sheet->setCellValue("R2", "6");
        $sheet->setCellValue("S2", "0");
        $sheet->setCellValue("T2", "0.025");
        $sheet->setCellValue("U2", "75");
        $sheet->setCellValue("V2", "55");
        $sheet->setCellValue("W2", "33");
        $sheet->setCellValue("X2", "NO");
        $sheet->getStyle("A1:X2")->applyFromArray($styleThinBlackBorderOutline);
        //$data = $this->Model_Logistica->get_list_duplicado($usuario, $semana);

        $sheet->getStyle('A1:X1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:X1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //$sheet->getStyle("A1:X1")->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:W1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
        $spreadsheet->getActiveSheet()->getStyle("X1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8EA9DB');

        //Custom width for Individual Columns
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(25);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(15);
        $sheet->getColumnDimension('S')->setWidth(15);
        $sheet->getColumnDimension('T')->setWidth(15);
        $sheet->getColumnDimension('U')->setWidth(15);
        $sheet->getColumnDimension('V')->setWidth(15);
        $sheet->getColumnDimension('W')->setWidth(15);
        $sheet->getColumnDimension('X')->setWidth(15);

        //final part
        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Ejemplo Carga Inventario';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    public function destroy_ci($id)
    {
        Inventario::delete_carga_inventario($id);
    }
}

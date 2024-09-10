<?php

namespace App\Http\Controllers;

use App\Models\AperturaCierreTienda;
use App\Models\ControlCamara;
use App\Models\ControlCamaraArchivo;
use App\Models\ControlCamaraArchivoTemporal;
use App\Models\ControlCamaraRonda;
use App\Models\DetalleOcurrenciasCamaras;
use App\Models\Horas;
use App\Models\HorasLima;
use App\Models\Local;
use App\Models\Notificacion;
use App\Models\OcurrenciasCamaras;
use App\Models\Sedes;
use App\Models\Tiendas;
use App\Models\TiendasRonda;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\DB;

class ControlCamaraController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();            
        return view('seguridad.control_camara.index',compact('list_notificacion'));
    }

    public function index_reg()
    {
        $list_sede = Sedes::select('id_sede', 'nombre_sede')->where('estado', 1)->orderBy('nombre_sede', 'ASC')->get();
        $list_local = Local::select('id_local', 'descripcion')->where('estado', 1)->orderBy('descripcion', 'ASC')->get();
        return view('seguridad.control_camara.registro.index', compact(['list_sede', 'list_local']));
    }

    public function list_reg(Request $request)
    {
        $list_control_camara = ControlCamara::get_list_control_camara(['id_sede' => $request->id_sede, 'id_local' => $request->id_local]);
        return view('seguridad.control_camara.registro.lista', compact('list_control_camara'));
    }

    public function create_reg()
    {
        $list_archivo = ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->get();
        if (count($list_archivo) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                foreach ($list_archivo as $list) {
                    $file_to_delete = "CONTROL_CAMARA/" . basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        ControlCamaraArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }
        $list_sede = Sedes::select('id_sede', 'nombre_sede')->where('estado', 1)->get();
        return view('seguridad.control_camara.registro.modal_registrar', compact('list_sede'));
    }

    public function create_round(Request $request)
    {
        $list_archivo = ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->get();
        if (count($list_archivo) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                foreach ($list_archivo as $list) {
                    $file_to_delete = "CONTROL_CAMARA/" . basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        ControlCamaraArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }
        $list_sede = Sedes::select('id_sede', 'nombre_sede')->where('estado', 1)->get();
        return view('seguridad.control_camara.registro.modal_create_round', compact('list_sede'));
    }

    public function traer_hora_programada_reg(Request $request)
    {
        $list_tienda_base = Tiendas::select('tiendas.id_tienda')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', NULL)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();
        $cantidad = ControlCamara::select('id_sede', 'fecha', 'hora_programada')->where('id_sede', $request->id_sede)
            ->where('fecha', date('Y-m-d'))
            ->where('id_tienda', $list_tienda_base[0]['id_tienda'])
            ->where('estado', 1)->groupBy('id_sede', 'fecha', 'hora_programada')->get();

        $cantidad_hora = Horas::where('id_sede', $request->id_sede)->count();
        if (count($cantidad) >= $cantidad_hora) {
            echo "error";
        } else {
            $ultimo = Horas::select('hora')->where('id_sede', $request->id_sede)->where('orden', (count($cantidad) + 1))
                ->where('estado', 1)->first();
            echo $ultimo->hora;
        }
    }

    public function traer_hora_programada_lima_reg(Request $request)
    {
        $list_tienda_sede = Tiendas::select('tiendas.id_tienda')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', 1)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();

        $cantidad = ControlCamara::select('id_sede', 'fecha', 'hora_programada')->where('id_sede', $request->id_sede)
            ->where('fecha', date('Y-m-d'))
            ->where('id_tienda', $list_tienda_sede[0]['id_tienda'])
            ->where('estado', 1)->groupBy('id_sede', 'fecha', 'hora_programada')->get();

        $cantidad_hora = HorasLima::where('id_sede', $request->id_sede)->count();
        if (count($cantidad) >= $cantidad_hora) {
            echo "error";
        } else {
            $ultimo = HorasLima::select('hora')->where('id_sede', $request->id_sede)->where('orden', (count($cantidad) + 1))
                ->where('estado', 1)->first();
            echo $ultimo->hora;
        }
    }

    public function traer_tienda_reg(Request $request)
    {
        $list_archivo = ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->get();
        if (count($list_archivo) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                foreach ($list_archivo as $list) {
                    $file_to_delete = "CONTROL_CAMARA/" . basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        ControlCamaraArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }

        $list_tienda_base = Tiendas::select('tiendas.id_tienda', 'local.descripcion')
            ->join('local', 'local.id_local', '=', 'tiendas.id_local')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', NULL)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();
        $list_tienda_sede = Tiendas::select('tiendas.id_tienda', 'local.descripcion')
            ->join('local', 'local.id_local', '=', 'tiendas.id_local')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', 1)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();
        $list_ocurrencia = OcurrenciasCamaras::select('id_ocurrencias_camaras', 'descripcion')
            ->where('estado', 1)->get();
        //poner id_tienda correcto
        $get_sede = Tiendas::select('sedes.nombre_sede')
            ->join('sedes', 'sedes.id_sede', '=', 'tiendas.id_sede')
            ->where('id_tienda', $list_tienda_sede[0]['id_tienda'])->first();
        $list_ronda = TiendasRonda::select('tiendas_ronda.id', 'control_camara_ronda.descripcion')
            ->join('control_camara_ronda', 'control_camara_ronda.id', '=', 'tiendas_ronda.id_ronda')
            ->where('tiendas_ronda.id_tienda', $list_tienda_sede[0]['id_tienda'])->orderBy('tiendas_ronda.id', 'ASC')->get();
        return view('seguridad.control_camara.registro.tienda', compact('list_tienda_base', 'list_tienda_sede', 'list_ocurrencia', 'list_ronda', 'get_sede'));
    }

    public function traer_edificio_reg(Request $request)
    {
        $list_archivo = ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->get();
        if (count($list_archivo) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                foreach ($list_archivo as $list) {
                    $file_to_delete = "CONTROL_CAMARA/" . basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        ControlCamaraArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }

        $list_tienda_base = Tiendas::select('tiendas.id_tienda', 'local.descripcion')
            ->join('local', 'local.id_local', '=', 'tiendas.id_local')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', NULL)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();
        $list_tienda_sede = Tiendas::select('tiendas.id_tienda', 'local.descripcion')
            ->join('local', 'local.id_local', '=', 'tiendas.id_local')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', 1)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();
        $list_ocurrencia = OcurrenciasCamaras::select('id_ocurrencias_camaras', 'descripcion')
            ->where('estado', 1)->get();
        //poner id_tienda correcto
        $get_sede = Tiendas::select('sedes.nombre_sede')
            ->join('sedes', 'sedes.id_sede', '=', 'tiendas.id_sede')
            ->where('id_tienda', $list_tienda_sede[0]['id_tienda'])->first();
        $list_ronda = TiendasRonda::select('tiendas_ronda.id', 'control_camara_ronda.descripcion')
            ->join('control_camara_ronda', 'control_camara_ronda.id', '=', 'tiendas_ronda.id_ronda')
            ->where('tiendas_ronda.id_tienda', $list_tienda_sede[0]['id_tienda'])->orderBy('tiendas_ronda.id', 'ASC')->get();
        return view('seguridad.control_camara.registro.edificio', compact('list_tienda_base', 'list_tienda_sede', 'list_ocurrencia', 'list_ronda', 'get_sede'));
    }

    public function modal_imagen_reg($id_tienda)
    {
        return view('seguridad.control_camara.registro.modal_imagen', compact('id_tienda'));
    }

    public function insert_imagen_reg(Request $request, $id_tienda)
    {
        $request->validate([
            'archivo_base' => 'required',
        ], [
            'archivo_base.required' => 'Debe ingresar imagen.',
        ]);

        if ($_FILES["archivo_base"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $valida = ControlCamaraArchivoTemporal::select('archivo')
                    ->where('id_usuario', session('usuario')->id_usuario)
                    ->where('id_tienda', $id_tienda)->exists();
                if ($valida) {
                    $get_id = ControlCamaraArchivoTemporal::select('archivo')
                        ->where('id_usuario', session('usuario')->id_usuario)
                        ->where('id_tienda', $id_tienda)->first();
                    ftp_delete($con_id, 'CONTROL_CAMARA/' . basename($get_id->archivo));
                    ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
                        ->where('id_tienda', $id_tienda)->delete();
                }

                $path = $_FILES["archivo_base"]["name"];
                $source_file = $_FILES['archivo_base']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_" . $id_tienda . "_" . session('usuario')->id_usuario;
                $nombre = $nombre_soli . "." . strtolower($ext);
                $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/" . $nombre;

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CONTROL_CAMARA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    ControlCamaraArchivoTemporal::create([
                        'id_usuario' => session('usuario')->id_usuario,
                        'id_tienda' => $id_tienda,
                        'archivo' => $archivo
                    ]);
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }
    }

    public function modal_ronda_reg($id_tienda)
    {
        $get_sede = Tiendas::select('sedes.nombre_sede')
            ->join('sedes', 'sedes.id_sede', '=', 'tiendas.id_sede')
            ->where('id_tienda', $id_tienda)->first();
        $list_ronda = TiendasRonda::select('tiendas_ronda.id', 'control_camara_ronda.descripcion')
            ->join('control_camara_ronda', 'control_camara_ronda.id', '=', 'tiendas_ronda.id_ronda')
            ->where('tiendas_ronda.id_tienda', $id_tienda)->orderBy('tiendas_ronda.id', 'ASC')->get();
        return view('seguridad.control_camara.registro.modal_ronda', compact('id_tienda', 'get_sede', 'list_ronda'));
    }

    public function insert_ronda_reg(Request $request, $id_tienda)
    {
        $rules = [
            'archivo_rond' => 'required',
        ];
        $messages = [
            'archivo_rond.required' => 'Debe ingresar imagen.',
        ];

        $list_ronda = TiendasRonda::select('tiendas_ronda.id', 'tiendas_ronda.id_ronda', 'control_camara_ronda.descripcion')
            ->join('control_camara_ronda', 'control_camara_ronda.id', '=', 'tiendas_ronda.id_ronda')
            ->where('tiendas_ronda.id_tienda', $id_tienda)->orderBy('tiendas_ronda.id', 'ASC')->get();
        /*foreach($list_ronda as $list){
            $rules['archivo_ronda_'.$list->id] = 'required';
            $messages['archivo_ronda_'.$list->id.'.required'] = 'Debe ingresar imagen para '.$list->descripcion.'.';
        }*/

        $request->validate($rules, $messages);

        if ($_FILES["archivo_rond"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $valida = ControlCamaraArchivoTemporal::select('archivo')
                    ->where('id_usuario', session('usuario')->id_usuario)
                    ->where('id_tienda', $id_tienda)->exists();
                if ($valida) {
                    $get_id = ControlCamaraArchivoTemporal::select('archivo')
                        ->where('id_usuario', session('usuario')->id_usuario)
                        ->where('id_tienda', $id_tienda)->first();
                    ftp_delete($con_id, 'CONTROL_CAMARA/' . basename($get_id->archivo));
                    ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
                        ->where('id_tienda', $id_tienda)->delete();
                }

                $path = $_FILES["archivo_rond"]["name"];
                $source_file = $_FILES['archivo_rond']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_" . $id_tienda . "_" . session('usuario')->id_usuario;
                $nombre = $nombre_soli . "." . strtolower($ext);
                $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/" . $nombre;

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CONTROL_CAMARA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    ControlCamaraArchivoTemporal::create([
                        'id_usuario' => session('usuario')->id_usuario,
                        'id_tienda' => $id_tienda,
                        'archivo' => $archivo
                    ]);
                } else {
                    echo "Archivo no subido correctamente 0";
                }

                //CAPTURAS DE RONDAS
                foreach ($list_ronda as $list) {
                    if ($_FILES["archivo_ronda_" . $list->id]["name"] != "") {
                        $valida = ControlCamaraArchivoTemporal::select('archivo')
                            ->where('id_usuario', session('usuario')->id_usuario)
                            ->where('id_tienda', $id_tienda)
                            ->where('id_ronda', $list->id)->exists();
                        if ($valida) {
                            $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                ->where('id_usuario', session('usuario')->id_usuario)
                                ->where('id_tienda', $id_tienda)
                                ->where('id_ronda', $list->id)->first();
                            ftp_delete($con_id, 'CONTROL_CAMARA/' . basename($get_id->archivo));
                            ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
                                ->where('id_tienda', $id_tienda)
                                ->where('id_ronda', $list->id)->delete();
                        }

                        $path = $_FILES["archivo_ronda_" . $list->id]["name"];
                        $source_file = $_FILES['archivo_ronda_' . $list->id]['tmp_name'];

                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "temporal_" . $id_tienda . "_" . $list->id . "_" . session('usuario')->id_usuario;
                        $nombre = $nombre_soli . "." . strtolower($ext);
                        $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/" . $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "CONTROL_CAMARA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            ControlCamaraArchivoTemporal::create([
                                'id_usuario' => session('usuario')->id_usuario,
                                'id_tienda' => $id_tienda,
                                'id_ronda' => $list->id_ronda,
                                'archivo' => $archivo
                            ]);
                        } else {
                            echo "Archivo no subido correctamente " . $list->id;
                        }
                    }
                }
            } else {
                echo "No se conecto";
            }
        }
    }

    public function valida_captura_reg(Request $request)
    {
        $valida = ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
            ->where('id_tienda', $request->id_tienda)->exists();
        if ($valida) {
            $cantidad_tienda = Tiendas::where('id_sede', $request->id_sede)->where('estado', 1)->count();
            $cantidad_ronda = 0;
            $tienda = Tiendas::select('id_tienda')->where('id_sede', $request->id_sede)->where('ronda', 1)
                ->where('estado', 1)->first();
            if ($tienda->id_tienda) {
                $cantidad_ronda = TiendasRonda::where('id_tienda', $tienda->id_tienda)->count();
            }
            //$cantidad = $cantidad_tienda+$cantidad_ronda;
            $cantidad = $cantidad_tienda - 1;
            $valida = ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->count();

            if ($valida == $cantidad) {
                echo "habilitar";
            }
        }
    }

    public function store_reg(Request $request)
    {
        $list_tienda_base = Tiendas::select('tiendas.id_tienda')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', NULL)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();

        $cantidad = ControlCamara::select('id_sede', 'fecha', 'hora_programada')->where('id_sede', $request->id_sede)
            ->where('fecha', date('Y-m-d'))
            ->where('id_tienda', $list_tienda_base[0]['id_tienda'])
            ->where('estado', 1)->groupBy('id_sede', 'fecha', 'hora_programada')->get();

        $ultimo = Horas::select('hora')->where('id_sede', $request->id_sede)->where('orden', (count($cantidad) + 1))
            ->where('estado', 1)->first();


        $list_tienda_base = Tiendas::select('id_tienda', 'id_local')
            ->where('id_sede', $request->id_sede)->where('ronda', NULL)
            ->where('estado', 1)->orderBy('id_tienda', 'ASC')
            ->get();
        if (count($list_tienda_base) > 0) {
            foreach ($list_tienda_base as $list) {
                $fecha = date('Y-m-d');
                if (date('a', strtotime($ultimo->hora)) == 'am' || date('a', strtotime($ultimo->hora)) == 'AM') {
                    $fecha = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
                }
                $id_ocurrencia = $request->input('id_ocurrencia_' . $list->id_tienda);
                if (empty($id_ocurrencia) || in_array("0", $id_ocurrencia)) {
                    // Si no hay nada seleccionado o si "0" está en los valores seleccionados
                    $id_ocurrencia = [12]; // Asigna un array con el valor 12
                }

                $control_camara = ControlCamara::create([
                    'id_usuario' => session('usuario')->id_usuario,
                    'id_sede' => $request->id_sede,
                    'fecha' => $fecha,
                    'hora_programada' => $ultimo->hora,
                    'hora_registro' => now(),
                    'id_tienda' => $list->id_local,
                    'id_ocurrencia' => 12,
                    'completado' => 0,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                $id = $control_camara->id;
                foreach ($id_ocurrencia as $ocurrencia) {
                    DetalleOcurrenciasCamaras::create([
                        'id_control_camara' => $id,
                        'id_ocurrencia' => $ocurrencia,
                    ]);
                }

                $list_temporal = ControlCamaraArchivoTemporal::select('id', 'archivo')
                    ->where('id_usuario', session('usuario')->id_usuario)
                    ->where('id_tienda', $list->id_tienda)->get();

                if (count($list_temporal) > 0) {
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                    if ($con_id && $lr) {
                        foreach ($list_temporal as $temporal) {
                            $nombre_actual = ltrim($temporal->archivo, 'https://lanumerounocloud.com/intranet');
                            $nuevo_nombre = "CONTROL_CAMARA/Evidencia_" . $control_camara->id . "_" . date('YmdHis') . "." . pathinfo($temporal->archivo, PATHINFO_EXTENSION);
                            ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                            $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

                            $descripcion = $request->input('desc_' . ($list->id_tienda));
                            ControlCamaraArchivo::create([
                                'id_control_camara' => $control_camara->id,
                                'archivo' => $archivo,
                                'descripcion' => $descripcion,
                            ]);
                            ControlCamaraArchivoTemporal::where('id', $temporal->id)->delete();
                        }
                    } else {
                        echo "No se conecto";
                    }
                }
            }
        }

        //validar completado  '1'
        $list_tienda_sede = Tiendas::select('tiendas.id_tienda', 'local.descripcion')
            ->join('local', 'local.id_local', '=', 'tiendas.id_local')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', 1)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->count();


        $total = count($list_tienda_base) + $list_tienda_sede;

        $fecha = date('Y-m-d');
        if (date('a', strtotime($ultimo->hora)) == 'am' || date('a', strtotime($ultimo->hora)) == 'AM') {
            $fecha = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
        }
        $cantidad = ControlCamara::select('id_sede', 'fecha', 'hora_programada')
            ->where('id_sede', $request->id_sede)
            ->where('hora_programada', $ultimo->hora)
            ->where('fecha', $fecha)
            ->where('completado', 0)
            ->where('estado', 1)->groupBy('id_sede', 'fecha', 'hora_programada')->count();
        // print_r('total'.$total);
        // print_r('cantidad'.$cantidad);
        if ($total === $cantidad) {
            ControlCamara::where('hora_programada', $ultimo->hora)
                ->where('id_sede', $request->id_sede)
                ->where('fecha', date('Y-m-d'))->update([
                    'completado' => 1,
                ]);
        }
    }

    public function archivo_reg($id)
    {
        $get_id = ControlCamara::select(
            'local.descripcion',
            DB::raw('DATE_FORMAT(control_camara.hora_programada,"%H:%i") AS hora'),
            DB::raw('DATE_FORMAT(control_camara.fecha,"%d/%m/%Y") AS fecha')
        )
            ->join('local', 'local.id_local', '=', 'control_camara.id_tienda')
            ->where('control_camara.id', $id)
            ->first();
        $cantidad = ControlCamaraArchivo::where('id_control_camara', $id)->count();
        if ($cantidad > 1) {
            $list_archivo = ControlCamaraArchivo::leftJoin('control_camara_ronda', 'control_camara_archivo.id_ronda', '=', 'control_camara_ronda.id')
                ->select(
                    'control_camara_archivo.archivo',
                    'control_camara_archivo.id_ronda',
                    'control_camara_archivo.descripcion',
                    DB::raw('control_camara_ronda.descripcion AS titulo')
                )
                ->where('control_camara_archivo.id_control_camara', $id)->get();
        } else {
            $list_archivo = ControlCamaraArchivo::where('id_control_camara', $id)->first();
        }
        return view('seguridad.control_camara.registro.modal_archivo', compact('get_id', 'list_archivo', 'cantidad'));
    }

    public function excel_reg($id_sede, $id_local)
    {
        $list_control_camara = ControlCamara::get_list_control_camara(['id_sede' => $id_sede, 'id_local' => $id_local]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Control de Cámaras');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(30);

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()
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

        $sheet->getStyle("A1:I1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Sede');
        $sheet->setCellValue("B1", 'Fecha');
        $sheet->setCellValue("C1", 'Colaborador');
        $sheet->setCellValue("D1", 'Hora Programada');
        $sheet->setCellValue("E1", 'Hora de Registro');
        $sheet->setCellValue("F1", 'Diferencia (min)');
        $sheet->setCellValue("G1", 'Observación');
        $sheet->setCellValue("H1", 'Tienda');
        $sheet->setCellValue("I1", 'Ocurrencia');

        $contador = 1;

        foreach ($list_control_camara as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->nombre_sede);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("C{$contador}", $list->colaborador);
            $sheet->setCellValue("D{$contador}", $list->hora_programada);
            $sheet->setCellValue("E{$contador}", $list->hora_registro);
            $sheet->setCellValue("F{$contador}", $list->diferencia);
            $sheet->setCellValue("G{$contador}", $list->observacion);
            $sheet->setCellValue("H{$contador}", $list->tienda);
            $sheet->setCellValue("I{$contador}", $list->ocurrencia);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Control de Cámaras';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function index_img()
    {
        $list_sede = Sedes::select('id_sede', 'nombre_sede')->where('estado', 1)->orderBy('nombre_sede', 'ASC')->get();
        $list_local = Local::select('id_local', 'descripcion')->where('estado', 1)->orderBy('descripcion', 'ASC')->get();
        return view('seguridad.control_camara.imagen.index', compact(['list_sede', 'list_local']));
    }

    public function list_img(Request $request)
    {
        $list_archivo = ControlCamaraArchivo::get_list_control_camara_archivo(['id_sede' => $request->id_sede, 'id_local' => $request->id_local]);
        return view('seguridad.control_camara.imagen.lista', compact('list_archivo'));
    }

    public function show_img($id)
    {
        $get_id = ControlCamaraArchivo::get_list_control_camara_archivo(['id' => $id]);
        return view('seguridad.control_camara.imagen.modal_detalle', compact('get_id'));
    }

    public function registrar_ronda(Request $request)
    {
        $request->validate([
            'archivo_rond' => 'required|file',
        ], [
            'archivo_rond.required' => 'Debe ingresar imagen.',
            'archivo_rond.file' => 'Debe ingresar imagen.',
        ]);

        $cantidad = ControlCamara::select('id_sede', 'fecha', 'hora_programada')->where('id_sede', $request->id_sede)
            ->where('fecha', date('Y-m-d'))
            ->where('estado', 1)->groupBy('id_sede', 'fecha', 'hora_programada')->get();

        $ultimo = HorasLima::select('hora')->where('id_sede', $request->id_sede)->where('orden', (count($cantidad) + 1))
            ->where('estado', 1)->first();

        //Registro temporal
        $list_tienda_sede = Tiendas::select('tiendas.id_tienda', 'local.descripcion', 'tiendas.id_local')
            ->join('local', 'local.id_local', '=', 'tiendas.id_local')
            ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda', 1)
            ->where('tiendas.estado', 1)->orderBy('tiendas.id_tienda', 'ASC')
            ->get();
        $id_tienda = $list_tienda_sede[0]['id_tienda'];
        $list_ronda = TiendasRonda::select('tiendas_ronda.id', 'tiendas_ronda.id_ronda', 'control_camara_ronda.descripcion')
            ->join('control_camara_ronda', 'control_camara_ronda.id', '=', 'tiendas_ronda.id_ronda')
            ->where('tiendas_ronda.id_tienda', $id_tienda)->orderBy('tiendas_ronda.id', 'ASC')->get();

        if ($_FILES["archivo_rond"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $valida = ControlCamaraArchivoTemporal::select('archivo')
                    ->where('id_usuario', session('usuario')->id_usuario)
                    ->where('id_tienda', $id_tienda)->exists();
                if ($valida) {
                    $get_id = ControlCamaraArchivoTemporal::select('archivo')
                        ->where('id_usuario', session('usuario')->id_usuario)
                        ->where('id_tienda', $id_tienda)->first();
                    ftp_delete($con_id, 'CONTROL_CAMARA/' . basename($get_id->archivo));
                    ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
                        ->where('id_tienda', $id_tienda)->delete();
                }

                $path = $_FILES["archivo_rond"]["name"];
                $source_file = $_FILES['archivo_rond']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_" . $id_tienda . "_" . session('usuario')->id_usuario;
                $nombre = $nombre_soli . "." . strtolower($ext);
                $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/" . $nombre;

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CONTROL_CAMARA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    ControlCamaraArchivoTemporal::create([
                        'id_usuario' => session('usuario')->id_usuario,
                        'id_tienda' => $id_tienda,
                        'archivo' => $archivo
                    ]);
                } else {
                    echo "Archivo no subido correctamente 0";
                }

                //CAPTURAS DE RONDAS
                foreach ($list_ronda as $list) {
                    if ($_FILES["archivo_ronda_" . $list->id]["name"] != "") {
                        $valida = ControlCamaraArchivoTemporal::select('archivo')
                            ->where('id_usuario', session('usuario')->id_usuario)
                            ->where('id_tienda', $id_tienda)
                            ->where('id_ronda', $list->id)->exists();
                        if ($valida) {
                            $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                ->where('id_usuario', session('usuario')->id_usuario)
                                ->where('id_tienda', $id_tienda)
                                ->where('id_ronda', $list->id)->first();
                            ftp_delete($con_id, 'CONTROL_CAMARA/' . basename($get_id->archivo));
                            ControlCamaraArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
                                ->where('id_tienda', $id_tienda)
                                ->where('id_ronda', $list->id)->delete();
                        }

                        $path = $_FILES["archivo_ronda_" . $list->id]["name"];
                        $source_file = $_FILES['archivo_ronda_' . $list->id]['tmp_name'];

                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "temporal_" . $id_tienda . "_" . $list->id . "_" . session('usuario')->id_usuario;
                        $nombre = $nombre_soli . "." . strtolower($ext);
                        $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/" . $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "CONTROL_CAMARA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            ControlCamaraArchivoTemporal::create([
                                'id_usuario' => session('usuario')->id_usuario,
                                'id_tienda' => $id_tienda,
                                'id_ronda' => $list->id_ronda,
                                'archivo' => $archivo
                            ]);
                        } else {
                            echo "Archivo no subido correctamente " . $list->id;
                        }
                    }
                }
            } else {
                echo "No se conecto";
            }
        }

        if (count($list_tienda_sede) > 0) {
            foreach ($list_tienda_sede as $list) {
                $fecha = date('Y-m-d');
                if (date('a', strtotime($ultimo->hora)) == 'am' || date('a', strtotime($ultimo->hora)) == 'AM') {
                    $fecha = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
                }

                $id_ocurrencia = $request->input('id_ocurrencia_' . $list->id_tienda);
                if (empty($id_ocurrencia) || in_array("0", $id_ocurrencia)) {
                    // Si no hay nada seleccionado o si "0" está en los valores seleccionados
                    $id_ocurrencia = [12]; // Asigna un array con el valor 12
                }

                $control_camara = ControlCamara::create([
                    'id_usuario' => session('usuario')->id_usuario,
                    'id_sede' => $request->id_sede,
                    'fecha' => $fecha,
                    'hora_programada' => $ultimo->hora,
                    'hora_registro' => now(),
                    'id_tienda' => $list->id_local,
                    'id_ocurrencia' => 12,
                    'completado' => 0,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                $list_temporal = ControlCamaraArchivoTemporal::select('id', 'id_ronda', 'archivo')
                    ->where('id_usuario', session('usuario')->id_usuario)
                    ->where('id_tienda', $list->id_tienda)->get();

                if (count($list_temporal) > 0) {
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                    if ($con_id && $lr) {
                        foreach ($list_temporal as $key => $temporal) {
                            $nombre_actual = ltrim($temporal->archivo, 'https://lanumerounocloud.com/intranet');
                            if ($temporal->id_ronda > 0) {
                                $nuevo_nombre = "CONTROL_CAMARA/Evidencia_" . $control_camara->id . "_" . $temporal->id_ronda . "_" . date('YmdHis') . "." . pathinfo($temporal->archivo, PATHINFO_EXTENSION);
                            } else {
                                $nuevo_nombre = "CONTROL_CAMARA/Evidencia_" . $control_camara->id . "_" . date('YmdHis') . "." . pathinfo($temporal->archivo, PATHINFO_EXTENSION);
                            }
                            ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                            $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

                            $descripcion = $request->input('archivo_ronda_desc_' . ($key));

                            ControlCamaraArchivo::create([
                                'id_control_camara' => $control_camara->id,
                                'id_ronda' => $temporal->id_ronda,
                                'archivo' => $archivo,
                                'descripcion' => $descripcion,
                            ]);

                            ControlCamaraArchivoTemporal::where('id', $temporal->id)->delete();
                        }
                    } else {
                        echo "No se conecto";
                    }
                }
            }
        }

        //validar completado  '1'
        $list_tienda_base = Tiendas::select('id_tienda', 'id_local')
            ->where('id_sede', $request->id_sede)->where('ronda', NULL)
            ->where('estado', 1)->orderBy('id_tienda', 'ASC')
            ->count();

        $fecha = date('Y-m-d');
        if (date('a', strtotime($ultimo->hora)) == 'am' || date('a', strtotime($ultimo->hora)) == 'AM') {
            $fecha = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
        }
        $total = $list_tienda_base + count($list_tienda_sede);

        $cantidad = ControlCamara::select('id_sede', 'fecha', 'hora_programada')
            ->where('id_sede', $request->id_sede)
            ->where('hora_programada', $ultimo->hora)
            ->where('fecha', $fecha)
            ->where('completado', 0)
            ->where('estado', 1)->groupBy('id_sede', 'fecha', 'hora_programada')->count();
        // print_r('total'.$total);
        // print_r('cantidad'.$cantidad);
        if ($total === $cantidad) {
            ControlCamara::where('hora_programada', $ultimo->hora)
                ->where('id_sede', $request->id_sede)
                ->where('fecha', date('Y-m-d'))->update([
                    'completado' => 1,
                ]);
        }
    }
}

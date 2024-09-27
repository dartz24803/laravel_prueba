<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\Base;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\SeguimientoCoordinador;
use App\Models\SubGerencia;
use App\Models\SupervisionTienda;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index_conf()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(2);

        return view('tienda.administracion.administrador.index', compact('list_notificacion', 'list_subgerencia',));
    }

    public function index_conf_st()
    {
        return view('tienda.administracion.administrador.supervision_tienda.index');
    }

    public function list_conf_st()
    {
        $list_c_supervision_tienda = ContenidoSupervisionTienda::select('id', 'descripcion')->where('estado', 1)->get();
        return view('tienda.administracion.administrador.supervision_tienda.lista', compact('list_c_supervision_tienda'));
    }

    public function create_conf_st($validador = null)
    {
        $validador = $validador;
        return view('tienda.administracion.administrador.supervision_tienda.modal_registrar', compact('validador'));
    }

    public function store_conf_st(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ], [
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ContenidoSupervisionTienda::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            ContenidoSupervisionTienda::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_conf_st($id)
    {
        $get_id = ContenidoSupervisionTienda::findOrFail($id);
        return view('tienda.administracion.administrador.supervision_tienda.modal_editar', compact('get_id'));
    }

    public function update_conf_st(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ], [
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ContenidoSupervisionTienda::where('descripcion', $request->descripcione)->where('estado', 1)->where('id', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            ContenidoSupervisionTienda::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_conf_st($id)
    {
        ContenidoSupervisionTienda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_conf_sc()
    {
        $list_base = Base::get_list_bases_tienda();
        $list_area = Area::select('id_area', 'nom_area')->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        return view('tienda.administracion.administrador.seguimiento_coordinador.index', compact('list_base', 'list_area'));
    }

    public function list_conf_sc(Request $request)
    {
        $list_c_seguimiento_coordinador = ContenidoSeguimientoCoordinador::get_list_c_seguimiento_coordinador(['base' => $request->base, 'id_area' => $request->area, 'id_periocidad' => $request->periocidad]);
        return view('tienda.administracion.administrador.seguimiento_coordinador.lista', compact('list_c_seguimiento_coordinador'));
    }

    public function create_conf_sc($validador = null)
    {
        $list_base = Base::get_list_bases_tienda();
        $list_area = Area::select('id_area', 'nom_area')->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        $list_dia_semana = DiaSemana::all();
        $list_mes = Mes::select('id_mes', 'nom_mes')->get();
        $validador = $validador;
        return view('tienda.administracion.administrador.seguimiento_coordinador.modal_registrar', compact('list_base', 'list_area', 'list_dia_semana', 'list_mes', 'validador'));
    }

    public function store_conf_sc(Request $request)
    {
        $rules = [
            'bases' => 'required_without:todos',
            'id_area' => 'gt:0',
            'id_periocidad' => 'gt:0',
        ];
        $messages = [
            'bases.required_without' => 'Debe seleccionar al menos una base.',
            'id_area.gt' => 'Debe seleccionar área.',
            'id_periocidad.gt' => 'Debe seleccionar periocidad.',
        ];
        if ($request->id_periocidad == "2") {
            if ($request->nom_dia_1 == "0" && $request->nom_dia_2 == "0" && $request->nom_dia_3 == "0") {
                $rules['dummy_field'] = 'gt:0';
                $messages['dummy_field.gt'] = 'Debe seleccionar al menos un día.';
            }
        } elseif ($request->id_periocidad == "3") {
            $rules['dia_1'] = 'gt:0';
            $messages['dia_1.gt'] = 'Debe seleccionar día 1.';
            $rules['dia_2'] = 'gt:0';
            $messages['dia_2.gt'] = 'Debe seleccionar día 2.';
        } elseif ($request->id_periocidad == "4") {
            $rules['dia'] = 'gt:0';
            $messages['dia.gt'] = 'Debe seleccionar día.';
        } elseif ($request->id_periocidad == "5") {
            $rules['mes'] = 'gt:0';
            $messages['mes.gt'] = 'Debe seleccionar mes.';
            $rules['dia'] = 'gt:0';
            $messages['dia.gt'] = 'Debe seleccionar día.';
        }
        $rules['descripcion'] = 'required';
        $messages['descripcion.required'] = 'Debe ingresar descripción.';

        $request->validate($rules, $messages);

        if ($request->todos == "1") {
            $list_base = Base::get_list_bases_tienda();
            foreach ($list_base as $list) {
                ContenidoSeguimientoCoordinador::create([
                    'base' => $list->cod_base,
                    'id_area' => $request->id_area,
                    'id_periocidad' => $request->id_periocidad,
                    'nom_dia_1' => $request->nom_dia_1,
                    'nom_dia_2' => $request->nom_dia_2,
                    'nom_dia_3' => $request->nom_dia_3,
                    'dia_1' => $request->dia_1,
                    'dia_2' => $request->dia_2,
                    'dia' => $request->dia,
                    'mes' => $request->mes,
                    'descripcion' => $request->descripcion,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        } else {
            foreach ($request->bases as $base) {
                ContenidoSeguimientoCoordinador::create([
                    'base' => $base,
                    'id_area' => $request->id_area,
                    'id_periocidad' => $request->id_periocidad,
                    'nom_dia_1' => $request->nom_dia_1,
                    'nom_dia_2' => $request->nom_dia_2,
                    'nom_dia_3' => $request->nom_dia_3,
                    'dia_1' => $request->dia_1,
                    'dia_2' => $request->dia_2,
                    'dia' => $request->dia,
                    'mes' => $request->mes,
                    'descripcion' => $request->descripcion,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }
    }

    public function edit_conf_sc($id)
    {
        $get_id = ContenidoSeguimientoCoordinador::findOrFail($id);
        $list_base = Base::get_list_bases_tienda();
        $list_area = Area::select('id_area', 'nom_area')->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        $list_dia_semana = DiaSemana::all();
        $list_mes = Mes::select('id_mes', 'nom_mes')->get();
        return view('tienda.administracion.administrador.seguimiento_coordinador.modal_editar', compact('get_id', 'list_base', 'list_area', 'list_dia_semana', 'list_mes'));
    }

    public function update_conf_sc(Request $request, $id)
    {
        $rules = [
            'basese' => 'not_in:0',
            'id_areae' => 'gt:0',
            'id_periocidade' => 'gt:0',
        ];
        $messages = [
            'basese.not_in' => 'Debe seleccionar base.',
            'id_areae.gt' => 'Debe seleccionar área.',
            'id_periocidade.gt' => 'Debe seleccionar periocidad.',
        ];
        if ($request->id_periocidade == "2") {
            if ($request->nom_dia_1e == "0" && $request->nom_dia_2e == "0" && $request->nom_dia_3e == "0") {
                $rules['dummy_fielde'] = 'gt:0';
                $messages['dummy_fielde.gt'] = 'Debe seleccionar al menos un día.';
            }
        } elseif ($request->id_periocidade == "3") {
            $rules['dia_1e'] = 'gt:0';
            $messages['dia_1e.gt'] = 'Debe seleccionar día 1.';
            $rules['dia_2e'] = 'gt:0';
            $messages['dia_2e.gt'] = 'Debe seleccionar día 2.';
        } elseif ($request->id_periocidade == "4") {
            $rules['diae'] = 'gt:0';
            $messages['diae.gt'] = 'Debe seleccionar día.';
        } elseif ($request->id_periocidade == "5") {
            $rules['mese'] = 'gt:0';
            $messages['mese.gt'] = 'Debe seleccionar mes.';
            $rules['diae'] = 'gt:0';
            $messages['diae.gt'] = 'Debe seleccionar día.';
        }
        $rules['descripcione'] = 'required';
        $messages['descripcione.required'] = 'Debe ingresar descripción.';

        $request->validate($rules, $messages);

        ContenidoSeguimientoCoordinador::findOrFail($id)->update([
            'base' => $request->basese,
            'id_area' => $request->id_areae,
            'id_periocidad' => $request->id_periocidade,
            'nom_dia_1' => $request->nom_dia_1e,
            'nom_dia_2' => $request->nom_dia_2e,
            'nom_dia_3' => $request->nom_dia_3e,
            'dia_1' => $request->dia_1e,
            'dia_2' => $request->dia_2e,
            'dia' => $request->diae,
            'mes' => $request->mese,
            'descripcion' => $request->descripcione,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_conf_sc($id)
    {
        ContenidoSeguimientoCoordinador::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(2);

        return view('tienda.administrador.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_st()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('tienda.administrador.supervision_tienda.index', compact('list_base'));
    }

    public function list_st(Request $request)
    {
        $list_supervision_tienda = SupervisionTienda::get_list_supervision_tienda(['base' => $request->base]);
        return view('tienda.administrador.supervision_tienda.lista', compact('list_supervision_tienda'));
    }

    public function create_st()
    {
        $list_contenido = ContenidoSupervisionTienda::select('id', 'descripcion')->orderBy('descripcion', 'ASC')->get();
        return view('tienda.administrador.supervision_tienda.modal_registrar', compact('list_contenido'));
    }

    public function previsualizacion_captura_st()
    {
        if ($_FILES["photo"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if (file_exists('https://lanumerounocloud.com/intranet/SUPERVISION_TIENDA/temporal_st_' . session('usuario')->id_usuario . '.jpg')) {
                    ftp_delete($con_id, 'SUPERVISION_TIENDA/temporal_st_' . session('usuario')->id_usuario . '.jpg');
                }

                $path = $_FILES["photo"]["name"];
                $source_file = $_FILES['photo']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_st_" . session('usuario')->id_usuario;
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "SUPERVISION_TIENDA/" . $nombre, $source_file, FTP_BINARY);
                if (!$subio) {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }
    }

    public function store_st(Request $request)
    {
        $valida = SupervisionTienda::where('base', $request->base)->where('fecha', $request->fecha)->where('estado', 1)->exists();

        if ($valida) {
            echo "error";
        } else {
            $supervision_tienda = SupervisionTienda::create([
                'base' => $request->base,
                'fecha' => $request->fecha,
                'observacion' => addslashes($request->observacion),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            $list_contenido = ContenidoSupervisionTienda::select('id', 'descripcion')->orderBy('descripcion', 'ASC')->get();
            foreach ($list_contenido as $list) {
                if ($request->input('radio_' . $list->id) == null) {
                    $valor = 2;
                } else {
                    $valor = $request->input('radio_' . $list->id);
                }
                DetalleSupervisionTienda::create([
                    'id_supervision_tienda' => $supervision_tienda->id,
                    'id_contenido' => $list->id,
                    'valor' => $valor,
                ]);
            }

            if ($request->hasFile('archivos') && count($request->file('archivos')) > 0) {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    for ($count = 0; $count < count($_FILES["archivos"]["name"]); $count++) {
                        $path = $_FILES["archivos"]["name"][$count];

                        if (
                            pathinfo($path, PATHINFO_EXTENSION) == 'JPG' ||
                            pathinfo($path, PATHINFO_EXTENSION) == 'jpg' ||
                            pathinfo($path, PATHINFO_EXTENSION) == 'PNG' ||
                            pathinfo($path, PATHINFO_EXTENSION) == 'png' ||
                            pathinfo($path, PATHINFO_EXTENSION) == 'JPEG' ||
                            pathinfo($path, PATHINFO_EXTENSION) == 'jpeg'
                        ) {
                            $source_file = $_FILES['archivos']['tmp_name'][$count];

                            $fecha = date('YmdHis');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli = "Evidencia_" . $supervision_tienda->id . "_" . $fecha . "_" . $count;
                            $nombre = $nombre_soli . "." . strtolower($ext);

                            $archivo = "https://lanumerounocloud.com/intranet/SUPERVISION_TIENDA/" . $nombre;

                            ftp_pasv($con_id, true);
                            $subio = ftp_put($con_id, "SUPERVISION_TIENDA/" . $nombre, $source_file, FTP_BINARY);
                            if ($subio) {
                                ArchivoSupervisionTienda::create([
                                    'id_supervision_tienda' => $supervision_tienda->id,
                                    'archivo' => $archivo,
                                ]);
                            } else {
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }
                } else {
                    echo "No se conecto";
                }
            }

            if ($request->captura == "1") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $nombre_actual = "SUPERVISION_TIENDA/temporal_st_" . session('usuario')->id_usuario . ".jpg";
                    $nuevo_nombre = "SUPERVISION_TIENDA/Evidencia_" . $supervision_tienda->id . "_" . date('YmdHis') . "_captura.jpg";
                    ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                    $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

                    ArchivoSupervisionTienda::create([
                        'id_supervision_tienda' => $supervision_tienda->id,
                        'archivo' => $archivo,
                    ]);
                } else {
                    echo "No se conecto";
                }
            }
        }
    }

    public function edit_st($id)
    {
        $get_id = SupervisionTienda::findOrFail($id);
        $list_contenido = ContenidoSupervisionTienda::select('id', 'descripcion')->orderBy('descripcion', 'ASC')->get();
        $list_detalle = DetalleSupervisionTienda::select('id_contenido', 'valor')->where('id_supervision_tienda', $id)->get();
        $list_archivo = ArchivoSupervisionTienda::select('id', 'archivo')->where('id_supervision_tienda', $id)->get();
        return view('tienda.administrador.supervision_tienda.modal_editar', compact('get_id', 'list_contenido', 'list_detalle', 'list_archivo'));
    }

    public function download_st($id)
    {
        $get_id = ArchivoSupervisionTienda::findOrFail($id);

        // URL del archivo
        $url = $get_id->archivo;

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

    public function destroy_evidencia_st($id)
    {
        $get_id = ArchivoSupervisionTienda::findOrFail($id);

        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
        if ($con_id && $lr) {
            $file_to_delete = "SUPERVISION_TIENDA/" . basename($get_id->archivo);

            if (ftp_delete($con_id, $file_to_delete)) {
                ArchivoSupervisionTienda::where('id', $id)->delete();
            } else {
                echo "Error al eliminar el archivo.";
            }
        } else {
            echo "No se conecto";
        }
    }

    public function update_st(Request $request, $id)
    {
        SupervisionTienda::findOrFail($id)->update([
            'observacion' => addslashes($request->observacione),
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        DetalleSupervisionTienda::where('id_supervision_tienda', $id)->delete();

        $list_contenido = ContenidoSupervisionTienda::select('id', 'descripcion')->orderBy('descripcion', 'ASC')->get();
        foreach ($list_contenido as $list) {
            if ($request->input('radioe_' . $list->id) == null) {
                $valor = 2;
            } else {
                $valor = $request->input('radioe_' . $list->id);
            }
            DetalleSupervisionTienda::create([
                'id_supervision_tienda' => $id,
                'id_contenido' => $list->id,
                'valor' => $valor,
            ]);
        }

        if ($request->hasFile('archivose') && count($request->file('archivose')) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                for ($count = 0; $count < count($_FILES["archivose"]["name"]); $count++) {
                    $path = $_FILES["archivose"]["name"][$count];

                    if (
                        pathinfo($path, PATHINFO_EXTENSION) == 'JPG' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'jpg' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'PNG' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'png' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'JPEG' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'jpeg'
                    ) {
                        $source_file = $_FILES['archivose']['tmp_name'][$count];

                        $fecha = date('YmdHis');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "Evidencia_" . $id . "_" . $fecha . "_" . $count;
                        $nombre = $nombre_soli . "." . strtolower($ext);

                        $archivo = "https://lanumerounocloud.com/intranet/SUPERVISION_TIENDA/" . $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "SUPERVISION_TIENDA/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            ArchivoSupervisionTienda::create([
                                'id_supervision_tienda' => $id,
                                'archivo' => $archivo,
                            ]);
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            } else {
                echo "No se conecto";
            }
        }

        if ($request->capturae == "1") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $nombre_actual = "SUPERVISION_TIENDA/temporal_st_" . session('usuario')->id_usuario . ".jpg";
                $nuevo_nombre = "SUPERVISION_TIENDA/Evidencia_" . $id . "_" . date('YmdHis') . "_captura.jpg";
                ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;
                ArchivoSupervisionTienda::create([
                    'id_supervision_tienda' => $id,
                    'archivo' => $archivo,
                ]);
            } else {
                echo "No se conecto";
            }
        }
    }

    public function show_st($id)
    {
        $get_id = SupervisionTienda::findOrFail($id);
        $list_contenido = ContenidoSupervisionTienda::select('id', 'descripcion')->orderBy('descripcion', 'ASC')->get();
        $list_detalle = DetalleSupervisionTienda::select('id_contenido', 'valor')->where('id_supervision_tienda', $id)->get();
        $list_archivo = ArchivoSupervisionTienda::select('id', 'archivo')->where('id_supervision_tienda', $id)->get();
        return view('tienda.administrador.supervision_tienda.modal_ver', compact('get_id', 'list_contenido', 'list_detalle', 'list_archivo'));
    }

    public function destroy_st($id)
    {
        SupervisionTienda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function evidencia_st($id)
    {
        $list_archivo = ArchivoSupervisionTienda::select('id', 'archivo')->where('id_supervision_tienda', $id)->get();
        return view('tienda.administrador.supervision_tienda.modal_evidencia', compact('list_archivo'));
    }

    public function index_sc()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('tienda.administrador.seguimiento_coordinador.index', compact('list_base'));
    }

    public function list_sc(Request $request)
    {
        $list_seguimiento_coordinador = SeguimientoCoordinador::get_list_seguimiento_coordinador(['base' => $request->base]);
        return view('tienda.administrador.seguimiento_coordinador.lista', compact('list_seguimiento_coordinador'));
    }

    public function valida_sc()
    {
        $list_contenido = ContenidoSeguimientoCoordinador::get_list_contenido_seguimiento_coordinador(['fecha' => date('Y-m-d')]);

        if (count($list_contenido) > 0) {
            echo "Si";
        } else {
            echo "No";
        }
    }

    public function create_sc()
    {
        $list_contenido = ContenidoSeguimientoCoordinador::get_list_contenido_seguimiento_coordinador(['fecha' => date('Y-m-d')]);
        return view('tienda.administrador.seguimiento_coordinador.modal_registrar', compact('list_contenido'));
    }

    public function store_sc(Request $request)
    {
        $valida = SeguimientoCoordinador::where('base', $request->base)->where('fecha', $request->fecha)->where('estado', 1)->exists();

        if ($valida) {
            echo "error";
        } else {
            $list_contenido = ContenidoSeguimientoCoordinador::get_list_contenido_seguimiento_coordinador(['fecha' => date('Y-m-d')]);

            if (count($list_contenido) > 0) {
                $seguimiento_coordinador = SeguimientoCoordinador::create([
                    'base' => $request->base,
                    'fecha' => $request->fecha,
                    'observacion' => addslashes($request->observacion),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                foreach ($list_contenido as $list) {
                    if ($request->input('radio_' . $list->id) == null) {
                        $valor = 2;
                    } else {
                        $valor = $request->input('radio_' . $list->id);
                    }
                    DetalleSeguimientoCoordinador::create([
                        'id_seguimiento_coordinador' => $seguimiento_coordinador->id,
                        'id_contenido' => $list->id,
                        'valor' => $valor,
                    ]);
                }

                if ($request->hasFile('archivos') && count($request->file('archivos')) > 0) {
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                    if ($con_id && $lr) {
                        for ($count = 0; $count < count($_FILES["archivos"]["name"]); $count++) {
                            $path = $_FILES["archivos"]["name"][$count];

                            if (
                                pathinfo($path, PATHINFO_EXTENSION) == 'JPG' ||
                                pathinfo($path, PATHINFO_EXTENSION) == 'jpg' ||
                                pathinfo($path, PATHINFO_EXTENSION) == 'PNG' ||
                                pathinfo($path, PATHINFO_EXTENSION) == 'png' ||
                                pathinfo($path, PATHINFO_EXTENSION) == 'JPEG' ||
                                pathinfo($path, PATHINFO_EXTENSION) == 'jpeg'
                            ) {
                                $source_file = $_FILES['archivos']['tmp_name'][$count];

                                $fecha = date('YmdHis');
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $nombre_soli = "Evidencia_" . $seguimiento_coordinador->id . "_" . $fecha . "_" . $count;
                                $nombre = $nombre_soli . "." . strtolower($ext);

                                $archivo = "https://lanumerounocloud.com/intranet/SEGUIMIENTO_COORDINADOR/" . $nombre;

                                ftp_pasv($con_id, true);
                                $subio = ftp_put($con_id, "SEGUIMIENTO_COORDINADOR/" . $nombre, $source_file, FTP_BINARY);
                                if ($subio) {
                                    ArchivoSeguimientoCoordinador::create([
                                        'id_seguimiento_coordinador' => $seguimiento_coordinador->id,
                                        'archivo' => $archivo,
                                    ]);
                                } else {
                                    echo "Archivo no subido correctamente";
                                }
                            }
                        }
                    } else {
                        echo "No se conecto";
                    }
                }
            } else {
                echo "sin_contenido";
            }
        }
    }

    public function edit_sc($id)
    {
        $get_id = SeguimientoCoordinador::findOrFail($id);
        $list_contenido = ContenidoSeguimientoCoordinador::get_list_contenido_seguimiento_coordinador(['fecha' => date('Y-m-d')]);
        $list_detalle = DetalleSeguimientoCoordinador::select('id_contenido', 'valor')->where('id_seguimiento_coordinador', $id)->get();
        $list_archivo = ArchivoSeguimientoCoordinador::select('id', 'archivo')->where('id_seguimiento_coordinador', $id)->get();
        return view('tienda.administrador.seguimiento_coordinador.modal_editar', compact('get_id', 'list_contenido', 'list_detalle', 'list_archivo'));
    }

    public function download_sc($id)
    {
        $get_id = ArchivoSeguimientoCoordinador::findOrFail($id);

        // URL del archivo
        $url = $get_id->archivo;

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

    public function destroy_evidencia_sc($id)
    {
        $get_id = ArchivoSeguimientoCoordinador::findOrFail($id);

        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
        if ($con_id && $lr) {
            $file_to_delete = "SEGUIMIENTO_COORDINADOR/" . basename($get_id->archivo);

            if (ftp_delete($con_id, $file_to_delete)) {
                ArchivoSeguimientoCoordinador::where('id', $id)->delete();
            } else {
                echo "Error al eliminar el archivo.";
            }
        } else {
            echo "No se conecto";
        }
    }

    public function update_sc(Request $request, $id)
    {
        SeguimientoCoordinador::findOrFail($id)->update([
            'observacion' => addslashes($request->observacione),
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        DetalleSeguimientoCoordinador::where('id_seguimiento_coordinador', $id)->delete();

        $list_contenido = ContenidoSeguimientoCoordinador::get_list_contenido_seguimiento_coordinador(['fecha' => date('Y-m-d')]);
        foreach ($list_contenido as $list) {
            if ($request->input('radioe_' . $list->id) == null) {
                $valor = 2;
            } else {
                $valor = $request->input('radioe_' . $list->id);
            }
            DetalleSeguimientoCoordinador::create([
                'id_seguimiento_coordinador' => $id,
                'id_contenido' => $list->id,
                'valor' => $valor,
            ]);
        }

        if ($request->hasFile('archivose') && count($request->file('archivose')) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                for ($count = 0; $count < count($_FILES["archivose"]["name"]); $count++) {
                    $path = $_FILES["archivose"]["name"][$count];

                    if (
                        pathinfo($path, PATHINFO_EXTENSION) == 'JPG' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'jpg' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'PNG' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'png' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'JPEG' ||
                        pathinfo($path, PATHINFO_EXTENSION) == 'jpeg'
                    ) {
                        $source_file = $_FILES['archivose']['tmp_name'][$count];

                        $fecha = date('YmdHis');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "Evidencia_" . $request->id . "_" . $fecha . "_" . $count;
                        $nombre = $nombre_soli . "." . strtolower($ext);

                        $archivo = "https://lanumerounocloud.com/intranet/SEGUIMIENTO_COORDINADOR/" . $nombre;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "SEGUIMIENTO_COORDINADOR/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            ArchivoSeguimientoCoordinador::create([
                                'id_seguimiento_coordinador' => $id,
                                'archivo' => $archivo,
                            ]);
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            } else {
                echo "No se conecto";
            }
        }
    }

    public function show_sc($id)
    {
        $get_id = SeguimientoCoordinador::findOrFail($id);
        $list_contenido = ContenidoSeguimientoCoordinador::get_list_contenido_seguimiento_coordinador(['fecha' => date('Y-m-d')]);
        $list_detalle = DetalleSeguimientoCoordinador::select('id_contenido', 'valor')->where('id_seguimiento_coordinador', $id)->get();
        $list_archivo = ArchivoSeguimientoCoordinador::select('id', 'archivo')->where('id_seguimiento_coordinador', $id)->get();
        return view('tienda.administrador.seguimiento_coordinador.modal_ver', compact('get_id', 'list_contenido', 'list_detalle', 'list_archivo'));
    }

    public function destroy_sc($id)
    {
        SeguimientoCoordinador::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function evidencia_sc($id)
    {
        $list_archivo = ArchivoSeguimientoCoordinador::select('id', 'archivo')->where('id_seguimiento_coordinador', $id)->get();
        return view('tienda.administrador.seguimiento_coordinador.modal_evidencia', compact('list_archivo'));
    }
}

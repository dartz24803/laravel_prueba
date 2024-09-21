<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Notificacion;
use App\Models\SeguridadAsistencia;
use App\Models\Usuario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\SubGerencia;

class AsistenciaSegController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(1);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();            
        return view('seguridad.asistencia.index',compact('list_notificacion','list_subgerencia'));
    }

    public function index_lec()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('seguridad.asistencia.lectora.index', compact('list_base'));
    }

    public function list_lec(Request $request)
    {
        $list_lectora = SeguridadAsistencia::get_list_lectora();
        return view('seguridad.asistencia.lectora.lista', compact('list_lectora'));
    }

    public function store_lec(Request $request)
    {
        $request->validate([
            'num_doc' => 'required'
        ], [
            'num_doc.required' => 'Debe ingresar n° documento.'
        ]);

        $valida = Usuario::where('num_doc', $request->num_doc)->where('estado', 1)->exists();

        if ($valida) {
            $get_id = Usuario::select(
                'users.id_usuario',
                'users.foto',
                DB::raw('LOWER(users.usuario_nombres) AS nombre_minuscula'),
                DB::raw('LOWER(CONCAT(users.usuario_apater," ",users.usuario_amater)) AS apellido_minuscula'),
                DB::raw('LOWER(puesto.nom_puesto) AS puesto_minuscula'),
                'users.centro_labores'
            )
                ->join('puesto', 'puesto.id_puesto', '=', 'users.id_puesto')
                ->where('users.num_doc', $request->num_doc)->where('users.estado', 1)->first();
            if ($request->horario_registro == "2") {
                $valida = SeguridadAsistencia::where('id_usuario', $get_id->id_usuario)->where('estado', 1)
                    ->where('fecha', date('Y-m-d'))->exists();
                if ($valida) {
                    if ($request->cod_base) {
                        $cod_base = $request->cod_base;
                    } else {
                        $cod_base = session('usuario')->centro_labores;
                    }
                    SeguridadAsistencia::where('id_usuario', $get_id->id_usuario)->where('estado', 1)
                        ->where('fecha', date('Y-m-d'))->orderBy('id_seguridad_asistencia', 'DESC')->first()
                        ->update([
                            'cod_sedes' => $cod_base,
                            'fecha_salida' => now(),
                            'h_salida' => now(),
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario
                        ]);
                    echo $get_id->foto . "*" . ucwords($get_id->nombre_minuscula) . "*" . ucwords($get_id->apellido_minuscula) . "*" . ucwords($get_id->puesto_minuscula) . "*" . $get_id->centro_labores;
                } else {
                    echo "sin_ingreso";
                }
            } else {
                if ($request->cod_base) {
                    $cod_base = $request->cod_base;
                } else {
                    $cod_base = session('usuario')->centro_labores;
                }
                SeguridadAsistencia::create([
                    'id_usuario' => $get_id->id_usuario,
                    'base' => $cod_base,
                    'cod_sede' => $cod_base,
                    'fecha' => now(),
                    'h_ingreso' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
                echo $get_id->foto . "*" . ucwords($get_id->nombre_minuscula) . "*" . ucwords($get_id->apellido_minuscula) . "*" . ucwords($get_id->puesto_minuscula) . "*" . $get_id->centro_labores;
            }
        } else {
            echo "error";
        }
    }

    public function edit_lec($id, $tipo)
    {
        $get_id = SeguridadAsistencia::get_list_lectora(['id_seguridad_asistencia' => $id]);
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('seguridad.asistencia.lectora.modal_editar', compact('get_id', 'tipo', 'list_base'));
    }

    public function update_lec(Request $request, $id, $tipo)
    {
        if ($tipo == "ingreso") {
            $request->validate([
                'cod_sedee' => 'not_in:0',
                'h_ingresoe' => 'required'
            ], [
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
        } else {
            $request->validate([
                'fecha_salidae' => 'required',
                'cod_sedese' => 'not_in:0',
                'h_salidae' => 'required'
            ], [
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
        }
    }

    public function image_lec($id)
    {
        $get_id = SeguridadAsistencia::findOrFail($id);
        return view('seguridad.asistencia.lectora.modal_imagen', compact('get_id'));
    }

    public function download_lec($id)
    {
        $get_id = SeguridadAsistencia::findOrFail($id);

        // URL del archivo
        $url = $get_id->imagen;

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

    public function update_image_lec(Request $request, $id)
    {
        $get_id = SeguridadAsistencia::findOrFail($id);

        $archivo = "";
        if ($_FILES["imagene"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if ($get_id->imagen != "") {
                    ftp_delete($con_id, 'SEGURIDAD/ASISTENCIA/' . basename($get_id->imagen));
                }
                $path = $_FILES["imagene"]["name"];
                $source_file = $_FILES['imagene']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Evidencia_" . $get_id->id_seguridad_asistencia . "_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "SEGURIDAD/ASISTENCIA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $archivo = "https://lanumerounocloud.com/intranet/SEGURIDAD/ASISTENCIA/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        SeguridadAsistencia::findOrFail($id)->update([
            'imagen' => $archivo,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_lec($id)
    {
        SeguridadAsistencia::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel_lec()
    {
        $list_lectora = SeguridadAsistencia::get_list_lectora();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencia con Lectora');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(50);

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

        $sheet->setCellValue('A1', 'Fecha Ingreso');
        $sheet->setCellValue('B1', 'Base');
        $sheet->setCellValue('C1', 'Colaborador');
        $sheet->setCellValue('D1', 'Hora Ingreso');
        $sheet->setCellValue('E1', 'Sede');
        $sheet->setCellValue('F1', 'Fecha Salida');
        $sheet->setCellValue('G1', 'Hora Salida');
        $sheet->setCellValue('H1', 'Sede');
        $sheet->setCellValue('I1', 'Observaciones');

        $contador = 1;

        foreach ($list_lectora as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->f_ingreso));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->base);
            $sheet->setCellValue("C{$contador}", $list->colaborador);
            $sheet->setCellValue("D{$contador}", $list->h_ingreso);
            $sheet->setCellValue("E{$contador}", $list->cod_sede);
            if ($list->f_salida != "") {
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list->f_salida));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("G{$contador}", $list->h_salida);
            $sheet->setCellValue("H{$contador}", $list->cod_sedes);
            $sheet->setCellValue("I{$contador}", $list->observacion);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencia con lectora';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function index_man()
    {
        if (
            session('usuario')->id_puesto == 21 ||
            session('usuario')->id_puesto == 279 ||
            session('usuario')->id_puesto == 22 ||
            session('usuario')->id_puesto == 23 ||
            session('usuario')->id_puesto == 19 ||
            session('usuario')->id_nivel == 1 ||
            session('usuario')->id_puesto == 24 ||
            session('usuario')->id_puesto == 209 ||
            session('usuario')->id_puesto == 277
        ) {
            if (session('usuario')->id_puesto == 24) {
                $list_base = Base::select('cod_base')->whereIn('id_base', [15, 19, 34])->get();
                $list_colaborador = Usuario::select(
                    'id_usuario',
                    DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                )
                    ->whereIn('centro_labores', ['AMT', 'CD', 'EXT', 'OFC'])
                    ->where('id_nivel', '!=', 8)->get();
            } else {
                $list_base = Base::get_list_todas_bases_agrupadas();
                $list_colaborador = Usuario::select(
                    'id_usuario',
                    DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                )
                    ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
            }
            return view('seguridad.asistencia.manual.index', compact('list_base', 'list_colaborador'));
        } elseif (session('usuario')->id_puesto == 36) {
            $list_colaborador = Usuario::select(
                'id_usuario',
                DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
            )
                ->where('centro_labores', session('usuario')->centro_labores)
                ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
            return view('seguridad.asistencia.manual.index', compact('list_colaborador'));
        }
    }

    public function list_man(Request $request)
    {
        $list_manual = SeguridadAsistencia::get_list_manual(['cod_base' => $request->cod_base, 'id_colaborador' => $request->id_colaborador, 'fecha_inicio' => $request->fecha_inicio, 'fecha_fin' => $request->fecha_fin]);
        return view('seguridad.asistencia.manual.lista', compact('list_manual'));
    }

    public function traer_colaborador_man(Request $request)
    {
        $validacion = $request->validacion;
        if (
            session('usuario')->id_puesto == 23 ||
            session('usuario')->id_nivel == 1 ||
            session('usuario')->id_puesto == 24 ||
            session('usuario')->id_puesto == 22
        ) {
            if (session('usuario')->id_puesto == 24) {
                if ($request->cod_base == "0") {
                    $list_colaborador = Usuario::select(
                        'id_usuario',
                        DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                    )
                        ->whereIn('centro_labores', ['AMT', 'CD', 'EXT', 'OFC'])
                        ->where('id_nivel', '!=', 8)->get();
                } else {
                    $list_colaborador = Usuario::select(
                        'id_usuario',
                        DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                    )
                        ->where('centro_labores', $request->cod_base)
                        ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
                }
            } else {
                if ($request->cod_base == "0") {
                    $list_colaborador = Usuario::select(
                        'id_usuario',
                        DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                    )
                        ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
                } else {
                    $list_colaborador = Usuario::select(
                        'id_usuario',
                        DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                    )
                        ->where('centro_labores', $request->cod_base)
                        ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
                }
            }
        } elseif (session('usuario')->id_puesto == 36) {
            $list_colaborador = Usuario::select(
                'id_usuario',
                DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
            )
                ->where('centro_labores', session('usuario')->centro_labores)
                ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
        }
        return view('seguridad.asistencia.manual.colaborador', compact('validacion', 'list_colaborador'));
    }

    public function create_man()
    {
        if (
            session('usuario')->id_puesto == 23 ||
            session('usuario')->id_nivel == 1 ||
            session('usuario')->id_puesto == 22
        ) {
            $list_base = Base::get_list_todas_bases_agrupadas();
            $list_colaborador = Usuario::select(
                'id_usuario',
                DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
            )
                ->where('centro_labores', session('usuario')->centro_labores)
                ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
        } elseif (
            session('usuario')->id_puesto == 24 ||
            session('usuario')->id_puesto == 36
        ) {
            $list_base = Base::select('cod_base')->whereIn('id_base', [15, 19, 34])->get();
            if (session('usuario')->id_puesto == 24) {
                $list_colaborador = Usuario::select(
                    'id_usuario',
                    DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                )
                    ->whereIn('centro_labores', ['AMT', 'CD', 'EXT', 'OFC'])
                    ->where('id_nivel', '!=', 8)->get();
            } else {
                $list_colaborador = Usuario::select(
                    'id_usuario',
                    DB::raw('CONCAT(usuario_apater," ",usuario_amater,", ",usuario_nombres) AS nom_usuario')
                )
                    ->where('centro_labores', session('usuario')->centro_labores)
                    ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
            }
        }
        return view('seguridad.asistencia.manual.modal_registrar', compact('list_base', 'list_colaborador'));
    }

    public function store_man(Request $request)
    {
        if (session('usuario')->id_puesto == 36) {
            $request->validate([
                'fecha' => 'required',
                'id_colaborador' => 'required_without:todos',
                'cod_sede' => 'not_in:0',
                'h_ingreso' => 'required'
            ], [
                'fecha.required' => 'Debe ingresar fecha.',
                'id_colaborador.required_without' => 'Debe seleccionar al menos un colaborador.',
                'cod_sede.not_in' => 'Debe seleccionar sede.',
                'h_ingreso.required' => 'Debe ingresar hora ingreso.'
            ]);
        } else {
            $request->validate([
                'fecha' => 'required',
                'cod_base' => 'not_in:0',
                'id_colaborador' => 'required_without:todos',
                'cod_sede' => 'not_in:0',
                'h_ingreso' => 'required'
            ], [
                'fecha.required' => 'Debe ingresar fecha.',
                'cod_base.not_in' => 'Debe seleccionar base.',
                'id_colaborador.required_without' => 'Debe seleccionar al menos un colaborador.',
                'cod_sede.not_in' => 'Debe seleccionar sede.',
                'h_ingreso.required' => 'Debe ingresar hora ingreso.'
            ]);
        }

        if ($request->todos) {
            $list_colaborador = Usuario::select('id_usuario')
                ->where('centro_labores', $request->cod_base)
                ->where('estado', 1)->where('id_nivel', '!=', 8)->get();
            foreach ($list_colaborador as $list) {
                SeguridadAsistencia::create([
                    'id_usuario' => $list->id_usuario,
                    'base' => $request->cod_base,
                    'cod_sede' => $request->cod_sede,
                    'fecha' => $request->fecha,
                    'h_ingreso' => $request->h_ingreso,
                    'observacion' => $request->observacion,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        } else {
            foreach ($request->id_colaborador as $id_usuario) {
                SeguridadAsistencia::create([
                    'id_usuario' => $id_usuario,
                    'base' => $request->cod_base,
                    'cod_sede' => $request->cod_sede,
                    'fecha' => $request->fecha,
                    'h_ingreso' => $request->h_ingreso,
                    'observacion' => $request->observacion,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }
    }

    public function edit_man($id, $tipo)
    {
        $get_id = SeguridadAsistencia::get_list_lectora(['id_seguridad_asistencia' => $id]);
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('seguridad.asistencia.manual.modal_editar', compact('get_id', 'tipo', 'list_base'));
    }

    public function image_man($id)
    {
        $get_id = SeguridadAsistencia::findOrFail($id);
        return view('seguridad.asistencia.manual.modal_imagen', compact('get_id'));
    }

    public function obs_man($id)
    {
        $get_id = SeguridadAsistencia::get_list_lectora(['id_seguridad_asistencia' => $id]);
        return view('seguridad.asistencia.manual.modal_obs', compact('get_id'));
    }

    public function update_obs_man(Request $request, $id)
    {
        SeguridadAsistencia::findOrFail($id)->update([
            'observacion' => $request->observaciono,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function excel_man($cod_base, $id_colaborador, $fecha_inicio, $fecha_fin)
    {
        $list_manual = SeguridadAsistencia::get_list_manual(['cod_base' => $cod_base, 'id_colaborador' => $id_colaborador, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencia Manual');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(18);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(50);

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

        $sheet->setCellValue('A1', 'Fecha Ingreso');
        $sheet->setCellValue('B1', 'Base');
        $sheet->setCellValue('C1', 'Colaborador');
        $sheet->setCellValue('D1', 'Hora Ingreso');
        $sheet->setCellValue('E1', 'Sede');
        $sheet->setCellValue('F1', 'Fecha Salida');
        $sheet->setCellValue('G1', 'Hora Salida');
        $sheet->setCellValue('H1', 'Sede');
        $sheet->setCellValue('I1', 'Observaciones');

        $contador = 1;

        foreach ($list_manual as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->f_ingreso));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->base);
            $sheet->setCellValue("C{$contador}", $list->colaborador);
            $sheet->setCellValue("D{$contador}", $list->h_ingreso);
            $sheet->setCellValue("E{$contador}", $list->cod_sede);
            if ($list->f_salida != "") {
                $sheet->setCellValue("F{$contador}", Date::PHPToExcel($list->f_salida));
                $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("G{$contador}", $list->h_salida);
            $sheet->setCellValue("H{$contador}", $list->cod_sedes);
            $sheet->setCellValue("I{$contador}", $list->observacion);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencia Manual';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

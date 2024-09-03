<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FuncionTemporal;
use App\Models\Notificacion;
use App\Models\Puesto;
use App\Models\TareasFuncionTemporal;
use App\Models\Usuario;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FuncionTemporalController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();            
        $list_usuario = Usuario::get_list_usuario_ft();
        return view('tienda.funcion_temporal.index', compact('list_notificacion','list_usuario'));
    }

    public function list($id_usuario)
    {
        $list_funcion_temporal = FuncionTemporal::get_list_funcion_temporal(['id_usuario'=>$id_usuario]);
        return view('tienda.funcion_temporal.lista', compact('list_funcion_temporal'));
    }

    public function create()
    {
        $list_usuario = Usuario::get_list_usuario_ft(['base'=>session('usuario')->centro_labores]);
        return view('tienda.funcion_temporal.modal_registrar', compact('list_usuario'));
    }
 
    public function tipo_funcion(Request $request)
    {
        $id_tipo = $request->id_tipo;
        $v = $request->v;
        if($id_tipo=="1"){
            $list_puesto = Puesto::get_list_puesto_ft();
            return view('tienda.funcion_temporal.tipo_funcion', compact('list_puesto', 'id_tipo', 'v'));
        }else{
            $list_tarea = TareasFuncionTemporal::all();
            return view('tienda.funcion_temporal.tipo_funcion', compact('list_tarea', 'id_tipo', 'v'));
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'id_usuario' => 'gt:0',
            'id_tipo' => 'gt:0',
            'fecha' => 'date',
            'hora_inicio' => 'required',
        ];

        $messages = [
            'id_usuario.gt' => 'Debe seleccionar colaborador.',
            'id_tipo.gt' => 'Debe seleccionar tipo.',
            'fecha.date' => 'Debe ingresar fecha.',
            'hora_inicio.required' => 'Debe ingresar hora de inicio.',
        ];

        if($request->id_tipo=="1"){
            $rules['tarea'] = 'gt:0';
            $messages['tarea.gt'] = 'Debe seleccionar función.';
        }elseif($request->id_tipo=="2"){
            $rules['select_tarea'] = 'gt:0';
            $messages['select_tarea.gt'] = 'Debe seleccionar tipo de tarea.';
            if($request->select_tarea=="19"){
                $rules['tarea'] = 'required';
                $messages['tarea.required'] = 'Debe ingresar tarea.';
            }
        }

        $request->validate($rules, $messages);

        /*$request->validate([
            'id_usuario' => 'gt:0',
            'id_tipo' => 'gt:0',
            'fecha' => 'date',
            'hora_inicio' => 'date_format:H:i',
        ],[
            'id_usuario.gt' => 'Debe seleccionar colaborador.',
            'id_tipo.gt' => 'Debe seleccionar tipo.',
            'fecha.date' => 'Debe ingresar fecha.',
            'hora_inicio.date_format' => 'Debe ingresar hora de inicio.',
        ]);*/

        $centro_labores = Usuario::where('id_usuario', $request->id_usuario)->value('centro_labores');
        FuncionTemporal::create([
            'id_usuario' => $request->id_usuario,
            'base' => $centro_labores,
            'id_tipo' => $request->id_tipo,
            'select_tarea' => $request->select_tarea,
            'tarea' => $request->tarea,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function edit($id_funcion)
    {
        $get_id = FuncionTemporal::findOrFail($id_funcion);
        $list_usuario = Usuario::get_list_usuario_ft(['base'=>session('usuario')->centro_labores]);
        if($get_id->id_tipo=="1"){
            $list_puesto = Puesto::get_list_puesto_ft();
            return view('tienda.funcion_temporal.modal_editar', compact('get_id', 'list_usuario', 'list_puesto'));
        }else{
            $list_tarea = TareasFuncionTemporal::all();
            return view('tienda.funcion_temporal.modal_editar', compact('get_id', 'list_usuario', 'list_tarea'));
        }
    }

    public function update(Request $request, $id_funcion)
    {
        $rules = [
            'id_usuarioe' => 'gt:0',
            'id_tipoe' => 'gt:0',
            'fechae' => 'date',
            'hora_inicioe' => 'required',
        ];

        $messages = [
            'id_usuarioe.gt' => 'Debe seleccionar colaborador.',
            'id_tipoe.gt' => 'Debe seleccionar tipo.',
            'fechae.date' => 'Debe ingresar fecha.',
            'hora_inicioe.required' => 'Debe ingresar hora de inicio.',
        ];

        if($request->id_tipoe=="1"){
            $rules['tareae'] = 'gt:0';
            $messages['tareae.gt'] = 'Debe seleccionar función.';
        }elseif($request->id_tipoe=="2"){
            $rules['select_tareae'] = 'gt:0';
            $messages['select_tareae.gt'] = 'Debe seleccionar tipo de tarea.';
            if($request->select_tareae=="19"){
                $rules['tareae'] = 'required';
                $messages['tareae.required'] = 'Debe ingresar tarea.';
            }
        }

        $request->validate($rules, $messages);

        $centro_labores = Usuario::where('id_usuario', $request->id_usuarioe)->value('centro_labores');
        FuncionTemporal::findOrFail($id_funcion)->update([
            'id_usuario' => $request->id_usuarioe,
            'base' => $centro_labores,
            'id_tipo' => $request->id_tipoe,
            'select_tarea' => $request->select_tareae,
            'tarea' => $request->tareae,
            'fecha' => $request->fechae,
            'hora_inicio' => $request->hora_inicioe,
            'hora_fin' => $request->hora_fine,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function show($id_funcion)
    {
        $get_id = FuncionTemporal::findOrFail($id_funcion);
        $list_usuario = Usuario::get_list_usuario_ft(['base'=>session('usuario')->centro_labores]);
        if($get_id->id_tipo=="1"){
            $list_puesto = Puesto::get_list_puesto_ft();
            return view('tienda.funcion_temporal.modal_ver', compact('get_id', 'list_usuario', 'list_puesto'));
        }else{
            $list_tarea = TareasFuncionTemporal::all();
            return view('tienda.funcion_temporal.modal_ver', compact('get_id', 'list_usuario', 'list_tarea'));
        }
    }

    public function destroy($id_funcion)
    {
        FuncionTemporal::findOrFail($id_funcion)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel($id_usuario)
    {
        $list_funcion_temporal = FuncionTemporal::get_list_funcion_temporal(['id_usuario'=>$id_usuario]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Función Temporal');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(20);

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:F1")->getFill()
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

        $sheet->getStyle("A1:F1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Base');     
        $sheet->setCellValue("B1", 'Colaborador');           
        $sheet->setCellValue("C1", 'Tipo');             
        $sheet->setCellValue("D1", 'Actividad');             
        $sheet->setCellValue("E1", 'Fecha');             
        $sheet->setCellValue("F1", 'Horario');       

        $contador=1;
        
        foreach($list_funcion_temporal as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->base);
            $sheet->setCellValue("B{$contador}", ucwords($list->nom_usuario));
            $sheet->setCellValue("C{$contador}", $list->nom_tipo);
            $sheet->setCellValue("D{$contador}", ucfirst($list->actividad));
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $list->horario);
        }

        $writer = new Xlsx($spreadsheet);
        $filename ='Función Temporal';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }
}
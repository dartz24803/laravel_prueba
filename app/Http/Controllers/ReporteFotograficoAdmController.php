<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotograficoAdm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\CodigosReporteFotografico;
use App\Models\Area;
use Exception;

class ReporteFotograficoAdmController extends Controller
{
    //variables a usar
    protected $request;
    protected $modelo;
    protected $modelocodigos;
    protected $modeloarea;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new ReporteFotograficoAdm();
        $this->modelocodigos = new CodigosReporteFotografico();
        $this->modeloarea = new Area();
    }

    public function index(){
        //retornar vista si esta logueado
        return view('tienda.administracion.ReporteFotografico.reportefotograficoadm');
    }
    
    public function listar(){
        $datos = $this->modelo->listar();
        $data = array();
        //listar cada fila de la tabla
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['id'];
            $sub_array[] = $row['nom_area'];
            $sub_array[] = $row['tipo'];
            $sub_array[] = $row['fecha_registro'];
            $sub_array[] = '<div class="btn-group" role="group" aria-label="Button group">
            <a class="btn btn-success" href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="'. route("tienda.administracion.ReporteFotografico.modal_editar", $row['id']).'">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg>
            </a>
            <a class="btn btn-danger" onClick="Delete_Reporte_Fotografico_Adm(' . $row['id'] . ')" title="Eliminar">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                <line x1="10" y1="11" x2="10" y2="17"></line>
                <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
            </a>
        </div>';
            $data[] = $sub_array;
        }
        $results = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );
        //retornar resultados para el datatable
        return response()->json($results);
    }
    
    public function ModalRegistroReporteFotograficoAdm(){
        //listar codigos reporte fotografico
        $list_area = $this->modeloarea->listar();
        $list_tipos = $this->modelocodigos->listar_tipos();
        // Retorna la vista con los datos
        return view('tienda.administracion.ReporteFotografico.modal_registrar', compact('list_tipos', 'list_area'));
    }
    
    public function ModalUpdatedReporteFotograficoAdm($id){
        // Lógica para obtener los datos necesarios
        $list_area = $this->modeloarea->listar();
        $list_tipos = $this->modelocodigos->listar_tipos();
        $get_id = $this->modelo->where('id', $id)->get();
        // Retorna la vista con los datos
        return view('tienda.administracion.ReporteFotografico.modal_editar', compact('list_area','list_tipos','get_id'));
    }
    
    public function Registrar_Reporte_Fotografico_Adm(Request $request){
        //validacion de codigo, q vaya con datos
        $validator = Validator::make($request->all(), [
            'codigo' => 'required',
            'area' => 'required'
        ], [
            'codigo.required' => 'Tipo: Campo obligatorio',
            'area.required' => 'Area: Campo obligatorio',
        ]);
        //alerta de validacion
        if ($validator->fails()) {
            $respuesta['error'] = $validator->errors()->get('codigo');
            $respuesta['error'] = $validator->errors()->get('area');
        }else{
            $dato = [
                'area' => $request->input("area"),
                'tipo' => $request->input("codigo"),
                'estado' => '1',
                'fec_reg' => now(),
                'user_reg' => Session::get('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => Session::get('usuario')->id_usuario,
            ];
            $this->modelo->insert($dato);
            $respuesta['error'] = "";
        }
        return response()->json($respuesta);
    }

    public function Delete_Reporte_Fotografico_Adm(Request $request){
        $id = $request->input('id');
        $respuesta = array();
        try {
            $this->modelo->where('id', $id)->delete();
            $respuesta['error'] = "";
        } catch (Exception $e) {
            $respuesta['error']=$e->getMessage();
        }
        return response()->json($respuesta);
    }

    public function Update_Registro_Fotografico_Adm(Request $request){
        //validacion de codigo, q vaya con datos
        $validator = Validator::make($request->all(), [
            'codigo_e' => 'required',
            'area_e' => 'required'
        ], [
            'codigo_e.required' => 'Tipo: Campo obligatorio',
            'area_e.required' => 'Area: Campo obligatorio',
        ]);
        //alerta de validacion
        if ($validator->fails()) {
            $respuesta['error'] = $validator->errors()->get('codigo_e');
            $respuesta['error'] = $validator->errors()->get('area_e');
        }else{
            $id = $request->input("id");
            $dato = [
                'area' => $request->input("area_e"),
                'tipo' => $request->input("codigo_e"),
                'estado' => '1',
                'fec_reg' => now(),
                'user_reg' => Session::get('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => Session::get('usuario')->id_usuario,
            ];
            $this->modelo->where('id', $id)->update($dato);
            $respuesta['error'] = "";
        }
        return response()->json($respuesta);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotograficoAdm;
use Illuminate\Support\Facades\Validator;
use App\Models\CodigosReporteFotografico;
use App\Models\Area;
use App\Models\Base;
use App\Models\ReporteFotograficoDetalle;
use Exception;

class ReporteFotograficoAdmController extends Controller
{
    //variables a usar
    protected $request;
    protected $modelo;
    protected $modelocodigos;
    protected $modeloarea;
    protected $modelobase;
    protected $modelodetalle;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new ReporteFotograficoAdm();
        $this->modelocodigos = new CodigosReporteFotografico();
        $this->modeloarea = new Area();
        $this->modelodetalle = new ReporteFotograficoDetalle();
    }

    public function index(){
        //retornar vista si esta logueado
        return view('tienda.administracion.ReporteFotografico.categorias.reportefotograficoadm');
    }
    
    public function listar(){
        $datos = $this->modelo->listar();
        $data = array();
        //listar cada fila de la tabla
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['id'];
            $sub_array[] = $row['categoria'];
            $sub_array[] = $row['detalles'];
            $sub_array[] = $row['fec_reg'];
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
        return view('tienda.administracion.ReporteFotografico.categorias.modal_registrar', compact('list_tipos', 'list_area'));
    }
    
    public function ModalUpdatedReporteFotograficoAdm($id){
        // Lógica para obtener los datos necesarios
        $list_area = $this->modeloarea->listar();
        $get_id = $this->modelo->where('id', $id)->get();
        $get_id2 = $this->modelodetalle->where('id_reporte_fotografico_adm', $id)->get();
        // Retorna la vista con los datos
        return view('tienda.administracion.ReporteFotografico.categorias.modal_editar', compact('list_area','get_id','get_id2'));
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
            $respuesta['error'] = $validator->errors()->all();
        }else{
            $valida = $this->modelo->where('categoria', $request->input("codigo"))->get();
            if(!$valida->isEmpty()){
                $respuesta['error'][0] = "Esta categoría ya está registrada!!";
            }else{
                $dato = [
                    'categoria' => $request->input("codigo"),
                    'estado' => '1',
                    'fec_reg' => now(),
                    'user_reg' => Session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => Session('usuario')->id_usuario,
                ];
                // Insertar el dato y obtener el ID del último registro insertado
                $id = $this->modelo->insertGetId($dato);
                for ($i = 0; $i < count($_POST['area']); $i++) {
                    $datos2 = [
                        'id_reporte_fotografico_adm' => $id,
                        'id_area' => $_POST['area'][$i],
                    ];
                    $this->modelodetalle->insert($datos2);
                }
                $respuesta['error'] = "";
            }
        }
        return response()->json($respuesta);
    }

    public function Delete_Reporte_Fotografico_Adm(Request $request){
        $id = $request->input('id');
        $respuesta = array();
        try {
            $dato = [
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => session('usuario')->id_usuario,
            ];
            $this->modelo->where('id', $id)->update($dato);
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
            $respuesta['error'] = $validator->errors()->all();
        }else{
            $id = $request->input("id");
            $dato = [
                'categoria' => $request->input("codigo_e"),
                'estado' => '1',
                'fec_reg' => now(),
                'user_reg' => Session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => Session('usuario')->id_usuario,
            ];
            $this->modelo->where('id', $id)->update($dato);
            $this->modelodetalle->where('id_reporte_fotografico_adm', $id)->delete();
            for ($i = 0; $i < count($_POST['area_e']); $i++) {
                $datos2 = [
                    'id_reporte_fotografico_adm' => $id,
                    'id_area' => $_POST['area_e'][$i],
                ];
                $this->modelodetalle->insert($datos2);
            }
            $respuesta['error'] = "";
        }
        return response()->json($respuesta);
    }

    public function Tabla_RF(){
        //enviar listas a la vista
        return view('tienda.administracion.ReporteFotografico.index');
    }

    public function Codigos_Reporte_Fotografico(){
        $list_bases = Base::get_list_bases_tienda();
        $list_categorias = $this->modelo->where('estado',1)->get();
        return view('tienda.administracion.ReporteFotografico.codigos.index', compact('list_bases','list_categorias'));
    }
    
    public function Codigos_Reporte_Fotografico_Listar(Request $request){
        $base= $request->input("base");
        $categoria= $request->input("categoria");
        $list = $this->modelocodigos->listar_codigos($base,$categoria);
        //print_r($list);
        return view('tienda.administracion.ReporteFotografico.codigos.listar', compact('list'));
    }
    
    public function ModalRegistroCodigosReporteFotograficoAdm(){
        $list_bases = Base::get_list_bases_tienda();
        $list_categorias = $this->modelo->where('estado',1)->get();
        // Retorna la vista con los datos
        return view('tienda.administracion.ReporteFotografico.codigos.modal_registrar',compact('list_categorias','list_bases'));
    }
    
    public function ModalUpdatedCodigoReporteFotograficoAdm($id){
        // Lógica para obtener los datos necesarios
        $get_id = $this->modelocodigos->where('id', $id)->get();
        $list_categorias = $this->modelo->where('estado',1)->get();
        $list_bases = Base::get_list_bases_tienda();
        // Retorna la vista con los datos
        return view('tienda.administracion.ReporteFotografico.codigos.modal_editar', compact('get_id','list_categorias','list_bases'));
    }
    
    public function Registrar_Codigo_Reporte_Fotografico_Adm(Request $request){
        //validacion de codigo, q vaya con datos
        $validator = Validator::make($request->all(), [
            'bases' => 'not_in:0',
            'codigo' => 'required',
            'categoria' => 'not_in:0'
        ], [
            'bases.not_in' => 'Base: Campo obligatorio',
            'codigo.required' => 'Codigo: Campo obligatorio',
            'categoria.not_in' => 'Categoria: Campo obligatorio',
        ]);
        //alerta de validacion
        if ($validator->fails()) {
            $respuesta['error'] = $validator->errors()->all();
        }else{
            $valida = $this->modelocodigos->where('tipo', $request->input('categoria'))
            ->where('descripcion',$request->input("codigo"))
            ->where('base',$request->input("bases"))->get();
            if(!$valida->isEmpty()){
                $respuesta['error'][0] = "Este código ya está registrado en esta base!!";
            }else{
                $dato = [
                    'base' => $request->input("bases"),
                    'tipo' => $request->input("categoria"),
                    'descripcion' => $request->input("codigo"),
                    'estado' => '1',
                    'fec_reg' => now(),
                    'user_reg' => Session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => Session('usuario')->id_usuario,
                ];
                $this->modelocodigos->insert($dato);
                $respuesta['error'] = "";
            }
        }
        return response()->json($respuesta);
    }

    public function Delete_Codigo_Reporte_Fotografico_Adm(Request $request){
        $id = $request->input('id');
        $respuesta = array();
        try {
            $dato = [
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => session('usuario')->id_usuario,
            ];
            $this->modelocodigos->where('id', $id)->update($dato);
            $respuesta['error'] = "";
        } catch (Exception $e) {
            $respuesta['error']=$e->getMessage();
        }
        return response()->json($respuesta);
    }

    public function Update_Codigo_Registro_Fotografico_Adm(Request $request){
        //validacion de codigo, q vaya con datos
        $validator = Validator::make($request->all(), [
            'bases_e' => 'not_in:0',
            'codigo_e' => 'required',
            'categoria_e' => 'not_in:0'
        ], [
            'bases_e.not_in' => 'Base: Campo obligatorio',
            'codigo_e.required' => 'Codigo: Campo obligatorio',
            'categoria_e.not_in' => 'Categoria: Campo obligatorio',
        ]);
        //alerta de validacion
        if ($validator->fails()) {
            $respuesta['error'] = $validator->errors()->all();
        }else{
            $id = $request->input("id");
            $dato = [
                'base' => $request->input("bases_e"),
                'tipo' => $request->input("categoria_e"),
                'descripcion' => $request->input("codigo_e"),
                'estado' => '1',
                'fec_reg' => now(),
                'user_reg' => Session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => Session('usuario')->id_usuario,
            ];
            $this->modelocodigos->where('id', $id)->update($dato);
            $respuesta['error'] = "";
        }
        return response()->json($respuesta);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Inicio extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $request;
    protected $modelo;
    public function __construct(Request $request)
    {
        $this->request = $request;
        //$this->modelo = new CarteraModel();
    }
    public function index()
    {
        if (session('usuario')) {
            return view('inicio');
        }else{
            return redirect('/');
        }
    }
    /*
    public function listar()
    {
        $datos = $this->modelo->orderBy('id_cartera', 'DESC')->get();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row->id_cartera;
            $sub_array[] = $row->codigo;
            $sub_array[] = $row->ruc;
            $sub_array[] = $row->razon_social;
            $sub_array[] = $row->nombre_comercial;
            $sub_array[] = '<div class="btn-group" role="group" aria-label="Button group">
            <a class="btn btn-success" onClick="editar(' . $row->id_cartera . ')" title="Actualizar"><i class="fa fa-edit"></i></a>
            <a class="btn btn-danger" onClick="eliminar(' . $row->id_cartera . ')" title="Eliminar"><i class="fa fa-trash"></i></a>
        </div>';
            $data[] = $sub_array;
        }
        $results = array(
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );
        return response()->json($results);
    }
    public function registraryeditar(Request $request)
    {
        $respuesta = array();
        $id = $request->input('id_cartera');
        $data = [
            'codigo' => $request->input('codigo'),
            'ruc' => $request->input('ruc'),
            'razon_social' => $request->input('razon_social'),
            'nombre_comercial' => $request->input('nombre_comercial'),
        ];
        if (empty($id)) {
            if ($this->modelo->insert($data)) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Datos guardados correctamente";
            } else {
                $respuesta["error"] = "Problemas al realizar Operación";
            }
        } else {
            if ($this->modelo->where('id_cartera', $id)->update($data)) {
                $respuesta['error'] = "";
                $respuesta['ok'] = "Datos Actualizados correctamente";
            } else {
                $respuesta["error"] = "Problemas al realizar Operación";
            }
        }
        return response()->json($respuesta);
    }
    public function buscar(Request $request)
    {
        $id = $request->input('id');
        $data['data'] = $this->modelo->buscar($id);
        return response()->json($data);
    }
    public function eliminar(Request $request)
    {
        $id = $request->input('id');
        $respuesta = array();
        try {
            $this->modelo->where('id_cartera', $id)->delete();
            $respuesta['error'] = "";
            $respuesta['ok'] = "Se Elimino Correctamente";
        } catch (Exception $e) {
            $respuesta['error']=$e->getMessage();
            //$respuesta['error'] = "Problemas al realizar Operación!";
        }
        return response()->json($respuesta);
    }*/
}

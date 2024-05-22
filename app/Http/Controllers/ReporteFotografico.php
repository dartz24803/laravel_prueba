<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotograficoModel;

class ReporteFotografico extends Controller
{
    protected $request;
    protected $modelo;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->modelo = new ReporteFotograficoModel();
    }

    public function index(){
        if (session('usuario')) {
            return view('reportefotografico');
        }else{
            return redirect('/');
        }
    }
/*
    public function listar(){
        $datos['list'] = $this->modelo->get();
        return view('reportefotograficolistar', $datos);
    }
*/
    public function listar()
    {
        $datos = $this->modelo->get();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row->id_cartera;
            $sub_array[] = $row->codigo;
            $sub_array[] = $row->ruc;
            $sub_array[] = $row->razon_social;
            $sub_array[] = $row->nombre_comercial;
            $sub_array[] = '<div class="btn-group" role="group" aria-label="Button group">
            <a class="btn btn-success" onClick="editar(' . $row->id . ')" title="Actualizar"><i class="fa fa-edit"></i></a>
            <a class="btn btn-danger" onClick="eliminar(' . $row->id . ')" title="Eliminar"><i class="fa fa-trash"></i></a>
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
}

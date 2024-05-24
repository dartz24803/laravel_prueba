<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotograficoModel;
use App\Models\AreaModel;
use App\Models\BaseModel;
use App\Models\CodigosReporteFotograficoModel;

class ReporteFotografico extends Controller
{
    protected $request;
    protected $modelo;
    protected $modeloarea;
    protected $modelobase;
    protected $modelocodigos;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->modelo = new ReporteFotograficoModel();
        $this->modeloarea = new AreaModel();
        $this->modelobase = new BaseModel();
        $this->modelocodigos = new CodigosReporteFotograficoModel();
    }

    public function index(){
        if (session('usuario')) {
            $list_area = $this->modeloarea->listar();
            $list_bases = $this->modelobase->listar();
            $list_codigos = $this->modelocodigos->listar();
            return view('tienda.reportefotografico', compact('list_area', 'list_bases', 'list_codigos'));
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
        $datos = $this->modelo->listar();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row['id'];
            $sub_array[] = $row['base'];
            $sub_array[] = $row['codigo_rf']; 
            if($row['letra_id'] == 'A')
            { $categoria = 'ALMACÉN'; }
            else if($row['letra_id'] == 'H')
            { $categoria = 'HOMBRE';}
            else if($row['letra_id'] == 'I')
            { $categoria = 'INFANTIL';}
            else if($row['letra_id'] == 'M')
            { $categoria = 'MUJER';}
            else if($row['letra_id'] == 'P')
            { $categoria = 'PROBADORES';}
            else if($row['letra_id'] == 'S')
            { $categoria = 'SERVICIOS';}
            else if($row['letra_id'] == 'F')
            { $categoria = 'FACHADA';}
            else if($row['letra_id'] == 'C')
            { $categoria = 'CAJA';}
            else{ $categoria = 'PERSONAS';} 
            $sub_array[] = $categoria;
            $sub_array[] = $row['areas'];
            $sub_array[] = $row['fecha_rf'];
            $sub_array[] = '<div class="btn-group" role="group" aria-label="Button group">
            <a class="btn btn-success" title="Ver evidencia" href="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/'.$row['foto'].'" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            </a>
            </div>';
            $sub_array[] = '<div class="btn-group" role="group" aria-label="Button group">
            <a class="btn btn-success" onClick="editar(' . $row['id'] . ')" title="Actualizar">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
            </svg>
            </a>
            <a class="btn btn-danger" onClick="eliminar(' . $row['id'] . ')" title="Eliminar">
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
        return response()->json($results);
    }
    public function modalRegistrarReporteFotografico()
    {
            // Lógica para obtener los datos necesarios
            $list_codigos = $this->modelocodigos->listar();
            // Retorna la vista con los datos
            return view('tienda.modal_registrar', compact('list_codigos'));
    }
}

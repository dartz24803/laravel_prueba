<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;

class TablaCuadroControlVisualController extends Controller
{
    protected $request;
    protected $modelobase;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelobase = new Base();
    }

    public function index(){
        //retornar vista si esta logueado
        // $list_area = $this->modeloarea->listar();
        // $list_bases = $this->modelobase->listar();
        // $list_codigos = $this->modelocodigos->listar();
        //enviar listas a la vista
        return view('tienda.administracion.CuadroControlVisual.tabla_ccv');
    }

    public function Horarios_Cuadro_Control(){
        $list_bases = $this->modelobase->listar();
        return view('tienda.administracion.CuadroControlVisual.Horarios.index', compact('list_bases'));
    }

    public function Lista_Horarios_Cuadro_Control(){
        
    }
}

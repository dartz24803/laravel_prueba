<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TablaCuadroControlVisualController extends Controller
{
    protected $request;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
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
        return view('tienda.administracion.CuadroControlVisual.Horarios.index');
    }
}

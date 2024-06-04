<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TablaCuadroControlVisualController extends Controller
{
    public function index(){
        //retornar vista si esta logueado
        if (session('usuario')) {
            // $list_area = $this->modeloarea->listar();
            // $list_bases = $this->modelobase->listar();
            // $list_codigos = $this->modelocodigos->listar();
            //enviar listas a la vista
            return view('tienda.administracion.ReporteFotografico.tabla_ccv');
        }else{
            return redirect('/');
        }
    }
}

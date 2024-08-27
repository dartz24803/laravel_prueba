<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class InicioComercialController extends Controller
{
    public function __construct(){
        $this->middleware('verificar.sesion.usuario')->except(['validar_reporte_fotografico_dia_job']);
    }
    public function index() {
        return view('comercial.inicio_comercial');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecursosHumanosInicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('rrhh.index');
    }
}

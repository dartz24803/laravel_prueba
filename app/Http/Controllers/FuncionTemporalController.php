<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FuncionTemporal;
use Illuminate\Http\Request;

class FuncionTemporalController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('tienda.funcion_temporal.index');
    }

    public function list()
    {
        $list_funcion_temporal = FuncionTemporal::get_list_funcion_temporal();
        return view('tienda.funcion_temporal.lista', compact('list_funcion_temporal'));
    }
}

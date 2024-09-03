<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class RecursosHumanosInicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.index', compact('list_notificacion'));
    }
}

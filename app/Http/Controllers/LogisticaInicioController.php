<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class LogisticaInicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.index', compact('list_notificacion', 'list_subgerencia'));
    }
}

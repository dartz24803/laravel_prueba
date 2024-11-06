<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class InfraestructuraInicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(10);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('infraestructura.index', compact('list_notificacion', 'list_subgerencia'));
    }
}

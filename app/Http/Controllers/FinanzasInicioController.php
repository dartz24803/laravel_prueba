<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class FinanzasInicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        $subgerenciaId = 8;

        $list_subgerencia = SubGerencia::list_subgerencia(8);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('finanzas.index', compact('list_notificacion', 'list_subgerencia', 'subgerenciaId'));
    }
}

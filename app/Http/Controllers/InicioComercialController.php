<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\SubGerencia;

class InicioComercialController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario')->except(['validar_reporte_fotografico_dia_job']);
    }
    public function index()
    {
        //NOTIFICACIONES
        $list_subgerencia = SubGerencia::list_subgerencia(3);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('comercial.inicio_comercial', compact('list_notificacion', 'list_subgerencia'));
    }
}

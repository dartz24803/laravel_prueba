<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class InicioSeguridadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $request;
    protected $modelo;
    public function __construct(Request $request)
    {
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
    }
    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(1);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('seguridad.inicio_seguridad', compact('list_notificacion', 'list_subgerencia'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class InicioTiendaController extends Controller
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
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        // $list_subgerencia = SubGerencia::list_subgerencia(2);
        $list_subgerencia = SubGerencia::list_subgerencia_with_validation_tienda(2);

        return view('tienda.inicio_tienda', compact('list_notificacion', 'list_subgerencia'));
    }
}

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
        $subgerenciaId = 2;
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        // $list_subgerencia = SubGerencia::list_subgerencia(2);
        $list_subgerencia = SubGerencia::list_subgerencia_with_validation(2);
        return view('tienda.inicio_tienda', compact('list_notificacion', 'list_subgerencia', 'subgerenciaId'));
    }
    // public function index()
    // {
    //     //NOTIFICACIONES
    //     $list_notificacion = Notificacion::get_list_notificacion();
    //     $list_subgerencia = SubGerencia::list_subgerencia(2);
    //     $list_subgerencia_secundaria = SubGerencia::list_subgerencia(7);
    //     $mostrarNuevoLi = true;
    //     $id_subgerencia_sec = 7;
    //     return view('tienda.inicio_tienda', compact('list_notificacion', 'list_subgerencia', 'list_subgerencia_secundaria', 'mostrarNuevoLi', 'id_subgerencia_sec'));
    // }
}

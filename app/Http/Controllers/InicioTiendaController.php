<?php

namespace App\Http\Controllers;

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
        return view('tienda.inicio_tienda');
    }
}

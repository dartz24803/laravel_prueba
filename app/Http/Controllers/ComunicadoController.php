<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Base;


class ComunicadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $request;
    protected $modelo;
    protected $modelobase;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
        $this->modelo = new Slide();
        $this->modelobase = new Base();
    }
    public function index()
    {
        $list_base = $this->modelobase->select('cod_base')
                        ->where('estado', 1)
                        ->groupBy('cod_base')
                        ->orderBy('cod_base', 'ASC');
        return view('rrhh.Comunicado.index', compact('list_base'));
    }
}

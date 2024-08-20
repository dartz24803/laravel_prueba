<?php

namespace App\Http\Controllers;

use App\Models\CarteraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class IntencionRenunciaConfController extends Controller
{
public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('rrhh.administracion.intencion_renuncia.index');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\CarteraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Notificacion;

class IntencionRenunciaConfController extends Controller
{
public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.administracion.intencion_renuncia.index', compact('list_notificacion'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\CarteraModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Notificacion;
use App\Models\SubGerencia;

class IntencionRenunciaConfController extends Controller
{
public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.administracion.intencion_renuncia.index', compact('list_notificacion', 'list_subgerencia'));
    }
}
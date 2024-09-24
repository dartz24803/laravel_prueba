<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class TablaMaestraTesoreriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(8);
        return view('finanzas.tesoreria.tabla_maestra.index',compact('list_notificacion','list_subgerencia'));
    }

    public function list(Request $request)
    {
        $list_tabla_maestra = CajaChica::get_list_tabla_maestra();
        return view('finanzas.tesoreria.tabla_maestra.lista', compact('list_tabla_maestra'));
    }
}

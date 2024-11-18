<?php

namespace App\Http\Controllers;

use App\Models\CajaChicaPago;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TbContabilidad;
use Illuminate\Http\Request;

class FacturacionController extends Controller
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
        return view('finanzas.tesoreria.facturacion.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function list(Request $request)
    {
        $list_tabla_maestra = TbContabilidad::transferData();
        dd($list_tabla_maestra);
        return view('finanzas.tesoreria.facturacion.lista', compact('list_tabla_maestra'));
    }
}

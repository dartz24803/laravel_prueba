<?php

namespace App\Http\Controllers;

use App\Models\AperturaCierreTienda;
use App\Models\Sedes;
use Illuminate\Http\Request;

class ControlCamaraController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.control_camara.index');
    }

    public function index_reg()
    {
        return view('seguridad.control_camara.registro.index');
    }

    public function list_reg(Request $request)
    {
        $list_control_camara = AperturaCierreTienda::get_list_apertura_cierre_tienda(['cod_base'=>$request->cod_base,'fec_ini'=>$request->fec_ini,'fec_fin'=>$request->fec_fin]);
        return view('seguridad.control_camara.registro.lista', compact('list_control_camara'));
    }

    public function create_reg()
    {
        $list_sede = Sedes::select('id_sede','nombre_sede')->get();                                     
        return view('seguridad.control_camara.registro.modal_registrar', compact('list_sede'));
    }
}
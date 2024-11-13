<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function Traer_Puesto_Cargo_Colaborador(Request $request){
        $id_area = $request->input("id_area");
        $list_puesto = Puesto::select('id_puesto', 'nom_puesto')
                        ->where('estado', 1)
                        ->where('id_area', $id_area)
                        ->get();
        return view('rrhh.administracion.colaborador.puesto', compact('list_puesto'));
    }
}

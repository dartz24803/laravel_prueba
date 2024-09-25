<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BiReporte;
use App\Models\Notificacion;
use App\Models\SubGerencia;

class BiReporteDepartamentoController extends Controller
{
    public function handleAreaP($id_area, $id_subgerencia)
    {
        // dd($id_subgerencia);
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia($id_subgerencia);
        $list_reportes = BiReporte::getByAreaDestino($id_area);
        // dd($list_reportes);
        return view('reportenew.indexp', compact('id_area', 'list_notificacion', 'list_subgerencia', 'list_reportes'));
    }



    // public function handleAreaP($id_area, $id_subgerencia, $id_subgerencia_sec)
    // {
    //     // dd($id_subgerencia);
    //     $list_notificacion = Notificacion::get_list_notificacion();
    //     $list_subgerencia = SubGerencia::list_subgerencia($id_subgerencia); // Pasar el id_subgerencia aquí
    //     $mostrarNuevoLi = true;
    //     $id_subgerencia_sec = $id_subgerencia_sec;
    //     $list_subgerencia_secundaria = SubGerencia::list_subgerencia($id_subgerencia_sec);
    //     return view('reportenew.indexp', compact('id_area', 'list_notificacion', 'list_subgerencia', 'mostrarNuevoLi', 'list_subgerencia_secundaria', 'id_subgerencia_sec'));
    // }
}

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
        $list_notificacion = Notificacion::get_list_notificacion();

        if ($id_subgerencia == "2") {
            $list_subgerencia = SubGerencia::list_subgerencia_with_validation($id_subgerencia);
        } else {
            $list_subgerencia = SubGerencia::list_subgerencia($id_subgerencia);
        }
        $id_puesto = session('usuario')->id_puesto;
        $list_reportes = BiReporte::getByAreaDestino($id_area, $id_puesto);
        // dd($list_reportes);
        return view('reportenew.indexp', compact('id_area', 'list_notificacion', 'list_subgerencia', 'list_reportes'));
    }
}

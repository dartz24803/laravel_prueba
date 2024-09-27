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

        if ($id_subgerencia == 2) {
            $list_subgerencia = SubGerencia::list_subgerencia_with_validation($id_subgerencia);
        } else {
            $list_subgerencia = SubGerencia::list_subgerencia($id_subgerencia);
        }

        $id_puesto = session('usuario')->id_puesto;
        $list_reportes = BiReporte::getByAreaDestino($id_area, $id_puesto);

        // Asignar el valor de $nominicio basado en $id_subgerencia
        switch ($id_subgerencia) {
            case 1:
                $nominicio = 'seguridad';
                break;
            case 2:
                $nominicio = 'tienda';
                break;
            case 3:
                $nominicio = 'comercial';
                break;
            case 4:
                $nominicio = 'manufactura';
                break;
            case 5:
                $nominicio = 'rrhh';
                break;
            case 6:
                $nominicio = 'general';
                break;
            case 7:
                $nominicio = 'logistica';
                break;
            case 8:
                $nominicio = 'finanzas';
                break;
            case 9:
                $nominicio = 'interna'; // Repetido, asegúrate de que este valor sea correcto
                break;
            case 10:
                $nominicio = 'infraestructura';
                break;
            case 11:
                $nominicio = 'materiales';
                break;
            case 12:
                $nominicio = 'finanzas'; // Repetido, asegúrate de que este valor sea correcto
                break;
            case 13:
                $nominicio = 'caja';
                break;
            default:
                $nominicio = 'default'; // Valor por defecto si no coincide con ningún caso
                break;
        }

        return view('reportenew.indexp', compact('id_area', 'list_notificacion', 'list_subgerencia', 'list_reportes', 'nominicio'));
    }
}

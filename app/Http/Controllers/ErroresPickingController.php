<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\Base;
use App\Models\Capacitacion;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\ErroresPicking;
use App\Models\ErrorPicking;
use App\Models\Gerencia;
use App\Models\Mes;
use App\Models\NivelJerarquico;
use App\Models\Procesos;
use App\Models\ProcesosHistorial;
use App\Models\Puesto;
use App\Models\SeguimientoCoordinador;
use App\Models\SupervisionTienda;
use App\Models\TipoPortal;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\User;

class ErroresPickingController extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.error_picking.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list_le()
    {
        // Obtener la lista de errores picking con los campos requeridos
        $list_errores_picking = ErroresPicking::select(
            'error_picking.id',
            'error_picking.fec_reg AS orden',
            'error_picking.semana',
            DB::raw("CASE WHEN error_picking.pertenece = '0' THEN '' ELSE error_picking.pertenece END AS pertenece"),
            DB::raw("CASE WHEN error_picking.encontrado = '0' THEN '' ELSE error_picking.encontrado END AS encontrado"),
            'area_error_picking.nombre AS area',
            'error_picking.estilo',
            'error_picking.color',
            'talla_error_picking.nombre AS talla',
            'error_picking.prendas_devueltas',
            'tipo_error_picking.nombre AS tipo_error',
            DB::raw("CONCAT(SUBSTRING_INDEX(users.usuario_nombres, ' ', 1), ' ', users.usuario_apater) AS responsable"),
            DB::raw("CASE WHEN error_picking.solucion = 1 THEN 'SI' WHEN error_picking.solucion = 2 THEN 'NO' ELSE '' END AS solucion"),
            'error_picking.observacion'
        )
            ->leftJoin('area_error_picking', 'error_picking.id_area', '=', 'area_error_picking.id')
            ->leftJoin('talla_error_picking', 'error_picking.id_talla', '=', 'talla_error_picking.id')
            ->leftJoin('tipo_error_picking', 'error_picking.id_tipo_error', '=', 'tipo_error_picking.id')
            ->leftJoin('users', 'error_picking.id_responsable', '=', 'users.id_usuario')
            ->where('error_picking.estado', '=', 1)
            ->orderBy('error_picking.fec_reg', 'DESC')
            ->get();

        return view('logistica.error_picking.lista', compact('list_errores_picking'));
    }
}

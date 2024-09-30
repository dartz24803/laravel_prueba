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

class StockInfosapController extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.stock_infosap.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list_infosap()
    {

        // Tamaño de la página
        $row_pag_size = 10000;
        $offset = 1 * $row_pag_size; // Calcular el desplazamiento

        // Obtener el total de registros (ejecutar el SP para contar los registros)
        $totalRecords = DB::connection('sqlsrv')->select("EXEC usp_ver_stock_almacenes_web ?, ?", [0, 0]);
        $total = count($totalRecords); // Contar el total de registros

        // Obtener los registros paginados desde la base de datos
        $list_stock = DB::connection('sqlsrv')
            ->select("EXEC usp_ver_stock_almacenes_web ?, ?", [$offset, $row_pag_size]);


        // Mostrar los datos para depuración (puedes eliminarlo en producción)
        // dd(response()->json($data)); 

        // Retornar solo list_stock a la vista
        return view('logistica.stock_infosap.lista', compact('list_stock'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AreaErrorPicking;
use App\Models\Base;
use App\Models\Capacitacion;
use App\Models\Consumible;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\ErroresPicking;
use App\Models\ErrorPicking;
use App\Models\Gerencia;
use App\Models\Inventario;
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
use App\Models\TallaErrorPicking;
use App\Models\TipoErrorPicking;
use App\Models\User;
use App\Models\Usuario;

class ConsumibleController extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.administracion.index', compact('list_notificacion', 'list_subgerencia'));
    }
    public function indexcons_conf()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.administracion.articulo.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list_cons()
    {
        $list_inventario = Consumible::get_list_consumible(-1);
        // dd($list_inventario);
        return view('logistica.consumible.lista', compact('list_inventario'));
    }


    public function edit_cons($id)
    {
        $get_id = ErroresPicking::findOrFail($id);
        // dd($get_id);

        $list_tipo_error = TipoErrorPicking::select('id', 'nombre')->get();

        $list_talla = TallaErrorPicking::select('id', 'nombre')
            ->where('talla_error_picking.estado', 1)
            ->get();

        $list_base = Base::get_list_todas_bases_agrupadas_bi();


        $list_area = AreaErrorPicking::select('id', 'nombre')
            ->orderBy('id', 'ASC')
            ->get();


        return view('logistica.error_picking.modal_editar', compact(
            'list_base',
            'list_tipo_error',
            'list_area',
            'list_talla',
            'get_id'
        ));
    }



    public function create_cons()
    {

        $list_base = Base::get_list_todas_bases_agrupadas_bi();
        $list_usuario = Usuario::get_list_usuario_inventario();

        return view('logistica.consumible.modal_registrar', compact(
            'list_base',
            'list_usuario'
        ));
    }

    public function store_cons(Request $request)
    {
        $request->validate([
            'fecha' => 'required',
            'base' => 'required',
            'responsable' => 'required',

        ], [
            'fecha.required' => 'Debe ingresar fecha.',
            'base.required' => 'Debe ingresar nase.',
            'responsable.required' => 'Debe seleccionar responsable',

        ]);

        $anio = date('Y');
        $totalRows_t = DB::table('inventario')->count();
        // $totalRows_t = count($this->Model_Logistica->cont_carga_inverntario());
        $aniof = substr($anio, 2, 2);
        if ($totalRows_t < 9) {
            $codigofinal = "I" . $aniof . "0000" . ($totalRows_t + 1);
        }
        if ($totalRows_t > 8 && $totalRows_t < 99) {
            $codigofinal = "I" . $aniof . "000" . ($totalRows_t + 1);
        }
        if ($totalRows_t > 98 && $totalRows_t < 999) {
            $codigofinal = "I" . $aniof . "00" . ($totalRows_t + 1);
        }
        if ($totalRows_t > 998 && $totalRows_t < 9999) {
            $codigofinal = "I" . $aniof . "0" . ($totalRows_t + 1);
        }
        if ($totalRows_t > 9998) {
            $codigofinal = "I" . $aniof . ($totalRows_t + 1);
        }
        $cod_inventario = $codigofinal;

        Inventario::create([
            'cod_inventario'  => $cod_inventario,
            'fecha' => $request->fecha ?? null,
            'base' => $request->base ?? null,
            'id_responsable' => $request->responsable ?? null,
            'conteo' => 0.00,
            'stock' => 0.00,
            'diferencia' =>  0.00,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);


        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Datos guardados exitosamente');
    }

    public function update_cons(Request $request, $id)
    {
        $request->validate([
            'semanae' => 'required',
            'pertenecee' => 'required',
            'encontradoe' => 'required',
            'id_areae' => 'required',
            'estiloe.*' => 'required',
            'colore.*' => 'required',
            'id_tallae.*' => 'required',
            'prendas_devueltase.*' => 'required',
            'id_tipo_errore.*' => 'required',
            'id_responsable.*' => 'required',
            'solucione.*' => 'required',
            'observacione.*' => 'required',
        ], [
            'semanae.required' => 'Debe ingresar semana.',
            'pertenecee.required' => 'Debe ingresar pertenece.',
            'encontradoe.required' => 'Debe seleccionar encontrado',
            'id_areae.required' => 'Debe seleccionar Area.',
            'estiloe.*.required' => 'Debe ingresar un estilo.',
            'colore.*.required' => 'Debe ingresar una color.',
            'id_tallae.*.required' => 'Debe seleccionar una talla.',
            'prendas_devueltase.*.required' => 'Debe seleccionar una prendas devueltas.',
            'id_tipo_errore.*.required' => 'Debe ingresar un tipo de error.',
            'id_responsablee.*.required' => 'Debe ingresar un responsable.',
            'solucione.*.required' => 'Debe seleccionar una solución.',
            'observacione.*.required' => 'Debe seleccionar una observación.',
        ]);

        ErroresPicking::where('id', $id)->update([
            'semana'  => $request->semanae,
            'pertenece' => $request->pertenecee,
            'encontrado' => $request->encontradoe,
            'id_area' => $request->id_areae,
            'estilo' => $request->estiloe,
            'color' => $request->colore,
            'id_talla' => $request->id_tallae,
            'prendas_devueltas' => $request->prendas_devueltase,
            'id_tipo_error' => $request->id_tipo_errore,
            'id_responsable' => $request->id_responsablee,
            'solucion' => $request->solucione,
            'observacion' => $request->observacione,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);
    }



    public function destroy_cons($id)
    {
        ErroresPicking::where('ID', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

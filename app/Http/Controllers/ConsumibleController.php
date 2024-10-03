<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AreaErrorPicking;
use App\Models\Articulos;
use App\Models\Base;
use App\Models\Capacitacion;
use App\Models\Consumible;
use App\Models\ConsumibleDetalle;
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
use App\Models\UnidadLogistica;
use App\Models\User;
use App\Models\Usuario;

class ConsumibleController extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.consumible.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list_cons()
    {
        $list_inventario = Consumible::get_list_consumible(-1);
        // dd($list_inventario);
        return view('logistica.consumible.lista', compact('list_inventario'));
    }


    public function edit_cons($id)
    {
        $get_id = Consumible::findOrFail($id);
        // dd($get_id);

        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        $list_articulos = Articulos::select('id_articulo', 'nom_articulo')
            ->where('articulo.estado', 1)
            ->get();

        $list_unidades = UnidadLogistica::select('id_unidad', 'nom_unidad')
            ->where('unidad_log.estado', 1)
            ->get();

        $list_colaborador = Usuario::get_list_colaborador_all();


        $list_consumibles_detalle = ConsumibleDetalle::select('id_detalle_consumible', 'articulo', 'unidad', 'cantidad')
            ->where('consumible_detalle.estado', 1)
            ->where('consumible_detalle.id_consumible', $id)
            ->get();

        // dd($list_consumibles_detalle);
        return view('logistica.consumible.modal_editar', compact(
            'list_unidades',
            'list_articulos',
            'list_area',
            'list_colaborador',
            'list_consumibles_detalle',
            'get_id'
        ));
    }



    public function create_cons()
    {
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        $list_articulos = Articulos::select('id_articulo', 'nom_articulo')
            ->where('articulo.estado', 1)
            ->get();

        $list_unidades = UnidadLogistica::select('id_unidad', 'nom_unidad')
            ->where('unidad_log.estado', 1)
            ->get();

        $list_colaborador = Usuario::get_list_colaborador_all();

        return view('logistica.consumible.modal_registrar', compact(
            'list_articulos',
            'list_area',
            'list_unidades',
            'list_colaborador'
        ));
    }

    public function store_cons(Request $request)
    {
        $request->validate([
            'areacon' => 'required',
            'colaborador' => 'required',
            'cantidad' => 'required',
            'articulo' => 'required',

        ], [
            'areacon.required' => 'Debe ingresar area.',
            'colaborador.required' => 'Debe ingresar colaborador.',
            'articulo.required' => 'Debe seleccionar articulo',

        ]);
        $tableData = json_decode($request->input('tableData'), true);
        // dd($tableData);
        $anio = date('Y');
        $aniof = substr($anio, 2, 2);
        $ultimoId = DB::table('consumible')->max('id_consumible');
        $nuevoId = $ultimoId ? $ultimoId + 1 : 1;
        // Generar el código final en formato A2300001 basado en el nuevo id
        $codigofinal = 'C' . $aniof . str_pad($nuevoId, 5, '0', STR_PAD_LEFT);

        $consumible = Consumible::create([
            'cod_consumible'  => $codigofinal,
            'id_area' => $request->areacon ?? null,
            'id_usuario' => $request->colaborador ?? null,
            'observacion' => '',
            'estado_consumible' => 1,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);

        foreach ($tableData as $index => $data) {
            // Crear un nuevo registro en la tabla consumible_detalle
            ConsumibleDetalle::create([
                'id_consumible' => $consumible->id_consumible,
                'articulo' => $data['articulo'],
                'unidad' => $data['unidad'],
                'cantidad' => $data['cantidad'],
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'user_eli' => 0,
            ]);
        }
        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Datos guardados exitosamente');
    }

    public function update_cons(Request $request, $id)
    {
        // Validar los campos del formulario
        $request->validate([
            'areacon' => 'required',
            'colaborador' => 'required',

        ], [
            'areacon.required' => 'Debe ingresar el área.',
            'colaborador.required' => 'Debe ingresar el colaborador.',

        ]);

        // Actualizar el registro del consumible
        $consumible = Consumible::findOrFail($id);
        $consumible->update([
            'id_area' => $request->areacon,
            'id_usuario' => $request->colaborador,
            'observacion' => $request->observacion ?? '',
            'estado_consumible' => 1,
            'estado' => 1,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
        ]);
        // dd($request->all());
        // Eliminar los registros anteriores de consumible_detalle para este consumible
        ConsumibleDetalle::where('id_consumible', $consumible->id_consumible)->delete();
        $id_unidades = $request->input('id_unidad', []);
        $id_articulos = $request->input('id_articulo', []);
        $cantidades = $request->input('cantidad', []);
        // dd($id_unidades);
        foreach ($cantidades as $index => $cantidad) {
            ConsumibleDetalle::create([
                'id_consumible' => $consumible->id_consumible,
                'articulo' => $id_articulos[$index],
                'unidad' => $id_unidades[$index],
                'cantidad' => $cantidad,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
            ]);
        }

        return response()->json([
            'message' => 'Consumible actualizado correctamente',
        ]);
    }



    public function destroy_cons($id)
    {
        Consumible::where('id_consumible', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
        ConsumibleDetalle::where('id_consumible', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

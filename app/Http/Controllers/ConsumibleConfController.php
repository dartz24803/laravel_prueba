<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaErrorPicking;
use App\Models\Articulos;
use App\Models\Base;
use App\Models\ErroresPicking;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TallaErrorPicking;
use App\Models\TipoErrorPicking;
use App\Models\UnidadLogistica;
use App\Models\User;
use App\Models\Usuario;

class ConsumibleConfController extends Controller
{

    public function index_cons()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.administracion.consumibles.index', compact('list_notificacion', 'list_subgerencia'));
    }
    public function indexart()
    {
        return view('logistica.administracion.consumibles.articulo.index');
    }



    public function list_art()
    {
        $list_articulos = Articulos::select('id_articulo', 'nom_articulo')
            ->where('articulo.estado', 1)
            ->get();
        // dd($list_inventario);
        return view('logistica.administracion.consumibles.articulo.lista', compact('list_articulos'));
    }



    public function edit_art($id)
    {
        $get_id = Articulos::findOrFail($id);
        return view('logistica.administracion.consumibles.articulo.modal_editar', compact(
            'get_id'
        ));
    }


    public function create_art()
    {
        return view('logistica.administracion.consumibles.articulo.modal_registrar');
    }

    public function store_art(Request $request)
    {
        $request->validate([
            'nom_art' => 'required',
        ], [
            'nom_art.required' => 'Debe seleccionar nombre',

        ]);

        $anio = date('Y');
        $aniof = substr($anio, 2, 2);
        $ultimoId = DB::table('articulo')->max('id_articulo');
        $nuevoId = $ultimoId ? $ultimoId + 1 : 1;

        // Generar el código final en formato A2300001 basado en el nuevo id
        $codigofinal = 'A' . $aniof . str_pad($nuevoId, 5, '0', STR_PAD_LEFT);

        Articulos::create([
            'nom_articulo' => $request->nom_art ?? null,
            'cod_articulo'  => $codigofinal,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);
        return redirect()->back()->with('success', 'Datos guardados exitosamente');
    }



    public function update_art(Request $request, $id)
    {
        $request->validate([
            'nom_arte' => 'required',
        ], [
            'nom_arte.required' => 'Debe seleccionar nombre',

        ]);

        Articulos::where('id_articulo', $id)->update([
            'nom_articulo'  => $request->nom_arte,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,

        ]);
    }



    public function destroy_art($id)
    {
        Articulos::where('id_articulo', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    // ADMINISTRABLE UNIDAD
    public function indexuni()
    {
        return view('logistica.administracion.consumibles.unidad.index');
    }


    public function list_uni()
    {
        $list_unidades = UnidadLogistica::select('id_unidad', 'nom_unidad')
            ->where('unidad_log.estado', 1)
            ->get();
        // dd($list_inventario);
        return view('logistica.administracion.consumibles.unidad.lista', compact('list_unidades'));
    }


    public function edit_uni($id)
    {
        $get_id = Articulos::findOrFail($id);
        return view('logistica.administracion.consumibles.unidad.modal_editar', compact(
            'get_id'
        ));
    }


    public function create_uni()
    {
        return view('logistica.administracion.consumibles.unidad.modal_registrar');
    }

    public function store_uni(Request $request)
    {
        $request->validate([
            'nom_art' => 'required',
        ], [
            'nom_art.required' => 'Debe seleccionar nombre',

        ]);

        $anio = date('Y');
        $aniof = substr($anio, 2, 2);
        $ultimoId = DB::table('articulo')->max('id_articulo');
        $nuevoId = $ultimoId ? $ultimoId + 1 : 1;

        // Generar el código final en formato A2300001 basado en el nuevo id
        $codigofinal = 'A' . $aniof . str_pad($nuevoId, 5, '0', STR_PAD_LEFT);

        Articulos::create([
            'nom_articulo' => $request->nom_art ?? null,
            'cod_articulo'  => $codigofinal,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);
        return redirect()->back()->with('success', 'Datos guardados exitosamente');
    }



    public function update_uni(Request $request, $id)
    {
        $request->validate([
            'nom_arte' => 'required',
        ], [
            'nom_arte.required' => 'Debe seleccionar nombre',

        ]);

        Articulos::where('id_articulo', $id)->update([
            'nom_articulo'  => $request->nom_arte,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,

        ]);
    }


    public function destroy_uni($id)
    {
        Articulos::where('id_articulo', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

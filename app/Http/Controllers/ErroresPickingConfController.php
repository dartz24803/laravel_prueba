<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Articulos;
use App\Models\Puesto;

use Illuminate\Http\Request;

use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TallaErrorPicking;

use App\Models\Usuario;

class ErroresPickingConfController extends Controller
{
    protected $modelopuesto;
    protected $modelousuarios;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');

        $this->modelousuarios = new Usuario();
        $this->modelopuesto = new Puesto();
    }

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.administracion.error_picking.index', compact('list_notificacion', 'list_subgerencia'));
    }
    public function indexerpi()
    {
        return view('logistica.administracion.error_picking.talla.index');
    }


    // ADMINISTRABLE TALLA 
    public function list_ta()
    {
        // Obtener la lista de errores picking con los campos requeridos
        $list_talla = TallaErrorPicking::select('id', 'nombre')
            ->where('talla_error_picking.estado', 1)
            ->get();

        return view('logistica.administracion.error_picking.talla.lista', compact('list_talla'));
    }


    public function create_ta()
    {
        return view('logistica.administracion.error_picking.talla.modal_registrar');
    }

    public function edit_ta($id)
    {
        $get_id = TallaErrorPicking::findOrFail($id);
        return view('logistica.administracion.error_picking.talla.modal_editar', compact('get_id'));
    }


    public function store_ta(Request $request)
    {
        $request->validate([
            'nom_talla' => 'required',

        ], [
            'nom_talla.required' => 'Debe ingresar nombre.',

        ]);

        TallaErrorPicking::create([
            'nombre'  => $request->nom_talla ?? null,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);
    }

    public function update_ta(Request $request, $id)
    {
        $request->validate([
            'nom_tallae' => 'required',

        ], [
            'nom_tallae.required' => 'Debe ingresar nombre.',

        ]);

        TallaErrorPicking::where('id', $id)->update([
            'nombre'  => $request->nom_tallae ?? null,
            'estado' => 1,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,

        ]);
    }

    public function destroy_ta($id)
    {


        TallaErrorPicking::where('id', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}

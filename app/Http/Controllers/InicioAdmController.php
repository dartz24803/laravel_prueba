<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\SliderInicio;
use Illuminate\Support\Facades\Validator;
use App\Models\Notificacion;
use App\Models\SubGerencia;

class InicioAdmController extends Controller
{
    protected $modelobase;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna/administracion/Inicio/slider/index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function Slider_Inicio_Listar()
    {
        $list = SliderInicio::get();
        return view('interna/administracion/Inicio/slider/lista', compact('list'));
    }

    public function Modal_Update_Slider_Inicio($id)
    {
        $dato['get_id'] = SliderInicio::where('id', $id)->get();
        return view('interna/administracion/Inicio/slider/modal_editar', $dato);
    }

    public function Update_Slider_Inicio(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required'
        ], [
            'titulo.required' => 'Titulo: Campo obligatorio',
            'descripcion.required' => 'Descripcion: Campo obligatorio',
        ]);

        $dato['titulo'] = $request->input("titulo");
        $dato['descripcion'] = $request->input("descripcion");
        $dato['link'] = $request->input("link");
        SliderInicio::where('id', $request->input("id"))->update($dato);
    }
}
